<?php
/**
 * This controller handles all actions related to Communities (Hubs) for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use Input;
use Validator;
use Redirect;
use Config;
use App\ExchangeType;
use Form;
use Pagetheme;
use Mail;
use Helper;
use Carbon;
use DB;
use Log;
use App\Community;

class CommunitiesController extends Controller
{

    protected $community;

    public function __construct(\App\Community $community)
    {
        $this->community = $community;
    }


    /**
    * Returns the homepage view
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getHomepage()
    {
        return view('home');
    }


    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content to display the entries within a community, which
    * is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::getDatatable() method that generates the JSON response
    * @since  [v1.0]
    * @return View
    */
    public function getEntriesView()
    {
        return view('browse');
    }

    /**
    * Returns a view that allows a user to request access to a community that is
    * non-public.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getRequestAccess(Request $request)
    {
        $user = Auth::user();
        $requests = DB::table('community_join_requests')
        ->where('user_id', '=', $user->id)
        ->where('community_id', '=', $request->whitelabel_group->id)
        ->count();
        return view('request-access')->with('requests', $requests);
    }

    /**
    * Stores the access request
    *
    * @todo   Send an email to the community owner
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::getRequestAccess()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postRequestAccess(Request $request)
    {
        $user = Auth::user();
        DB::table('community_join_requests')->insert(
            [
            'user_id' => $user->id,
            'community_id' => $request->whitelabel_group->id,
            'message' => e(Input::get('message')),
            ]
        );
        return redirect()->route('community.request-access.form');
    }



    /**
    * Returns a view lists the members of a community.
    *
    * @todo   Integrate server-side datatables
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::getDatatable() method that generates the JSON response
    * @since  [v1.0]
    * @return View
    */
    public function getMembers(Request $request)
    {
        $members = $request->whitelabel_group->members()->get();
        return view('members')->with('members', $members);
    }

    /**
    * Returns a view that displays the form to create a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::postCreate()
    * @since  [v1.0]
    * @return View
    */
    public function getCreate()
    {
        $themes = \App\Pagetheme::select('name')->where('public', '=', 1)->get()->lists('name');
        return view('communities.edit')->with('themes', $themes);
    }


    /**
    * Validates and stores the data for a new community. This method also handles
    * creating a subscription in Stripe for the user.
    *
    * @todo   Rip out Cartalyst's commercial stripe billing package and use Stripe native
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::getCreate()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postCreate(Request $request)
    {

        $token = Input::get('stripeToken');

        // No stripe token - something went wrong :(
        if (!isset($token)) {
            return Redirect::back()->withInput()->with('error', 'Something went wrong. Please make sure javascript is enabled in your browser.');
        }

        $community = new \App\Community();

        $community->name    = e(Input::get('name'));
        $community->subdomain    = strtolower(e(Input::get('subdomain')));
        $community->group_type    = e(Input::get('group_type'));
        $community->created_by    = Auth::user()->id;

        if ($community->isInvalid()) {
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        $customer = Auth::user();
        $metadata = array(
        //'name' => $customer->name,
        //'subdomain' => strtolower(e(Input::get('subdomain'))).Config::get('session.domain'),
        //'email' => $customer->email,
        //'hub_name' => e(Input::get('name')),
        );


        if ($customer->stripe_id=='') {
            // Create the Stripe customer

            $customer->createStripeCustomer(
                [
                'email' => $customer->email,
                'description' => 'Name: '.$customer->getDisplayName().', Hub Name: '.e(Input::get('name')),
                'metadata' => $metadata,
                ]
            );

        }

        $data['name'] = $customer->getDisplayName();
        $data['email'] = $customer->email;
        $data['community_name'] = e(Input::get('name'));
        $data['subdomain'] = strtolower(Input::get('subdomain'));
        $data['type'] = e(Input::get('subscription_type'));

        if (!$customer->save()) {
            return Redirect::back()->withInput()->with('error', 'Something went wrong.');
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with('error', 'Something went wrong while trying to authorise your card: '.$e->getMessage().'');
        }

        // Create the subscription
        try {
            $stripe_subscription = $customer
                ->subscription()
                ->onPlan(e(Input::get('subscription_type')))
                ->trialFor(\Carbon::now()->addDays(30))
                ->create();

            // set the given discount
            if (Input::has('coupon')) {
                try {
                    $customer->applyStripeDiscount(e(Input::get('coupon')));
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error', 'Something went wrong while trying to process your coupon request: '.$e->getMessage().'');
                }
            }

        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with('error', 'Something went wrong creating your subscription: '.$e->getMessage().'');
        }


        $customer->subscription()->syncWithStripe();
        $customer->card()->syncWithStripe();


        if ($community->save()) {

            // Save the community_id to the subscriptions table
            $subscription = \App\CommunitySubscription::where('stripe_id', '=', $stripe_subscription->stripe_id)->first();
            $subscription->community_id = $community->id;
            $subscription->save();

            $community->members()->attach(Auth::user(), ['is_admin' => true]);
            $community->exchangeTypes()->saveMany(\App\ExchangeType::all());

            Mail::send(
                ['text' => 'emails.welcome'],
                $data,
                function ($message) use ($data) {

                    $message->to($data['email'], $data['name'])->subject('Welcome to AnySha.re!');
                }
            );

            return redirect('http://'.$community->subdomain.'.'.Config::get('app.domain').'/entry/new')->with('success', trans('general.community.save_success'));

        }

    }


    /**
    * Returns a view that makes a form to edit community details.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::postEdit()
    * @since  [v1.0]
    * @return View
    */
    public function getEdit(Request $request)
    {
        $themes = \App\Pagetheme::select('name')->where('public', '=', 1)->get()->lists('name');

        $community = \App\Community::find($request->whitelabel_group->id);
        return view('community.edit')->with('community', $community)->with('themes', $themes);
    }


    /**
    * Validates and stores the edited community data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see    CommunitiesController::getEdit()
    * @since  [v1.0]
    * @return Redirect
    */
    public function postEdit(Request $request)
    {
        $community = \App\Community::find($request->whitelabel_group->id);

        $community->name    = e(Input::get('name'));
        $community->subdomain    = e(Input::get('subdomain'));
        $community->group_type    = e(Input::get('group_type'));
        $community->about    = e(Input::get('about'));
        $community->welcome_text    = e(Input::get('welcome_text'));
        $community->slack_endpoint    = e(Input::get('slack_endpoint'));
        $community->slack_botname    = e(Input::get('slack_botname'));
        $community->slack_channel    = e(Input::get('slack_channel'));
        $community->ga    = e(Input::get('ga'));

        if (Input::get('location')) {
            $community->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
        }

        if (Input::hasFile('profile_img')) {
            $community->uploadImage(Auth::user(), Input::file('profile_img'), 'community-profiles');
        }

        if (Input::hasFile('cover_img')) {
            $community->uploadImage(Auth::user(), Input::file('cover_img'), 'community-covers');
        }

        if (Input::hasFile('logo')) {
            $community->uploadImage(Auth::user(), Input::file('logo'), 'community-logos');
        }


        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $community->latitude         = $latlong['lat'];
            $community->longitude     = $latlong['lng'];
        }

        if (!$community->save()) {
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        $community->exchangeTypes()->sync(Input::get('exchange_types'));

        return redirect()->route('community.edit.form')->with('success', trans('general.community.messages.save_edits'));
    }
}
