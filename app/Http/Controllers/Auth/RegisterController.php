<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;
use Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'display_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'terms_and_conditions' => 'accepted',
        ]
      );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      return User::create([
          'display_name' => $data['display_name'],
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
      ]);
    }
    
  public function showRegistrationForm(Request $request)
  {
    return view('auth.register')->with('subdomain', $request->whitelabel_group->subdomain)->with('shareName', $request->whitelabel_group->name);;
  }

  protected function registered(Request $request, $user)
  {
    // if this is an open share, join them
    if ($request->whitelabel_group->isOpen()) {
      if (Auth::user()->communities()->sync([$request->whitelabel_group->id])) {
        LOG::debug("getJoinCommunity: joined open share successfully");
      }
      else {
        LOG::debug("getJoinCommunity: error joining open share");
        return redirect()->route('home')->withInput()->with('error', 'Unable to join '.$request->whitelabel_group->name);
      }
    }
  }
}
