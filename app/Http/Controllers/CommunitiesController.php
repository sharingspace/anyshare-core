<?php

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

class CommunitiesController extends Controller
{

  protected $community;

  public function __construct(\App\Community $community)
  {
      $this->community = $community;
  }


  public function getHomepage()
  {
    return view('home');
  }


  /*
  Get the entries view in current community
  */
  public function getEntriesView()
  {
    return view('browse');
  }



  /*
  Get the members in current community
  */
  public function getMembers(Request $request)
  {
    $members = $request->whitelabel_group->members()->get();
    return view('members')->with('members',$members);
  }

  /*
  Get the create community page
  */
  public function getCreate()
  {
    $themes = \App\Pagetheme::select('name')->where('public','=',1)->get()->lists('name');
    return view('communities.edit')->with('themes',$themes);
  }


  /*
  * Save new community
  */
  public function postCreate(Request $request)
  {

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // exit;
    $token = Input::get('stripeToken');

    // No stripe token - something went wrong :(
    if (!isset($token)) {
        return Redirect::back()->withInput()->with('error','Something went wrong. Please make sure javascript is enabled in your browser.');
    }

    $community = new \App\Community();

    $community->name	= e(Input::get('name'));
    $community->subdomain	= strtolower(e(Input::get('subdomain')));
    $community->group_type	= e(Input::get('group_type'));
    $community->created_by	= Auth::user()->id;

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

      $customer->createStripeCustomer([
          'email' => $customer->email,
          'description' => 'Name: '.$customer->getDisplayName().', Hub Name: '.e(Input::get('name')),
          'metadata' => $metadata,
      ]);

    }

    $data['name'] = $customer->getDisplayName();
    $data['email'] = $customer->email;
    $data['community_name'] = e(Input::get('name'));
    $data['subdomain'] = strtolower(Input::get('subdomain'));
    $data['type'] = e(Input::get('subscription_type'));

    if (!$customer->save()) {
      return Redirect::back()->withInput()->with('error','Something went wrong.');
    }

    try {
      $card = $customer->card()->makeDefault()->create($token);
    } catch (\Exception $e) {
      return Redirect::back()->withInput()->with('error','Something went wrong while trying to authorise your card: '.$e->getMessage().'');
    }

    // Create the subscription
    try {
      $stripe_subscription = $customer
      ->subscription()
      ->onPlan(e(Input::get('subscription_type')))
      ->create();

      // set the given discount
      if (Input::has('coupon')) {
        try {
          $customer->applyStripeDiscount(e(Input::get('coupon')));
        } catch (\Exception $e) {
          return Redirect::back()->withInput()->with('error','Something went wrong while trying to process your coupon request: '.$e->getMessage().'');
        }
      }

    } catch (\Exception $e) {
      return Redirect::back()->withInput()->with('error','Something went wrong creating your subscription: '.$e->getMessage().'');
    }


    $customer->subscription()->syncWithStripe();
    $customer->card()->syncWithStripe();


  if ($community->save()) {

    // Save the community_id to the subscriptions table
    $subscription = \App\CommunitySubscription::where('stripe_id','=',$stripe_subscription->stripe_id)->first();
    $subscription->community_id = $community->id;
    $subscription->save();

    $community->members()->attach(Auth::user(), ['is_admin' => true]);
    $community->exchangeTypes()->saveMany(\App\ExchangeType::all());

    Mail::send(['text' => 'emails.welcome'], $data, function($message) use ($data)
    {
      $message->to($data['email'], $data['name'])->subject('Welcome to AnySha.re!');
    });

    return redirect('http://'.$community->subdomain.'.'.Config::get('app.domain').'/entry/new')->with('success',trans('general.community.save_success'));

    }

  }


  /*
  Get the create community page
  */
  public function getEdit(Request $request)
  {
    $themes = \App\Pagetheme::select('name')->where('public','=',1)->get()->lists('name');

    $community = \App\Community::find($request->whitelabel_group->id);
    return view('community.edit')->with('community',$community)->with('themes',$themes);
  }


  /*
  Get the create community page
  */
  public function postEdit(Request $request)
  {
    $community = \App\Community::find($request->whitelabel_group->id);

      $community->name	= e(Input::get('name'));
      $community->subdomain	= e(Input::get('subdomain'));
      $community->group_type	= e(Input::get('group_type'));

      if (!$community->save()) {
         return Redirect::back()->withInput()->withErrors($community->getErrors());
      }

      $community->exchangeTypes()->sync(Input::get('community_exchange_types'));
      return redirect('http://'.$community->subdomain.'.'.Config::get('app.domain'))->with('success',trans('general.community.messages.save_edits'));

  }



}
