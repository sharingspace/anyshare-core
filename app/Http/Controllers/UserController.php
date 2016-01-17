<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Input;
use Redirect;
use Helper;


class UserController extends Controller
{
    public function getDashboard()
    {
        if (Auth::check()) {
            // The user is logged in...
            $user = Auth::user();
            return view('home')->with('user',$user);
        }

    }

    public function getHistory()
    {
      $user = Auth::user();
      $subscriptions = $user->subscriptions;
      return view('account.history')->with('subscriptions',$subscriptions);
    }


    public function getSettings()
    {
      return view('account.settings');
    }


    /*
    * Save the user's updated settings
    *
    */
    public function postSettings()
    {

      if ($user = \App\User::find(Auth::user()->id)) {

        $user->first_name = e(Input::get('first_name'));
        $user->last_name = e(Input::get('last_name'));
        $user->email = e(Input::get('email'));
        $user->display_name = e(Input::get('display_name'));
        $user->website = e(Input::get('website'));
        $user->bio = e(Input::get('bio'));
        $user->location = e(Input::get('location'));

        if (Input::get('location')) {
          $latlong = Helper::latlong(Input::get('location'));
        }

        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
					$user->latitude 		= $latlong['lat'];
					$user->longitude 		= $latlong['lng'];
				}


        if (!$user->save()) {
           return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
        }

        return redirect()->route('user.settings.view')->with('success','Saved!');

      }

      // That user wasn't valid
      return redirect()->route('user.settings.view')->withInput()->with('error','Invalid user');

    }

    /*
    * Save the user's updated settings
    *
    */
    public function postUpdateSocial()
    {

      // print_r($_POST);
      // exit;

      if ($user = \App\User::find(Auth::user()->id)) {

        $user->fb_url = e(Input::get('fb_url'));
        $user->twitter = e(Input::get('twitter'));
        $user->google = e(Input::get('google'));
        $user->pinterest = e(Input::get('pinterest'));
        $user->youtube = e(Input::get('youtube'));

        if (!$user->save()) {
           return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
        }

        return redirect()->route('user.settings.view')->with('success','Saved!');

      }

      // That user wasn't valid
      return redirect()->route('user.settings.view')->withInput()->with('error','Invalid user');

    }

    /*
    * Save the user's updated password
    *
    */
    public function postUpdatePassword()
    {

      if ($user = \App\User::find(Auth::user()->id)) {

        $user->password = e(Input::get('password'));

        if (!$user->save()) {
           return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
        }

        return redirect()->route('user.settings.view')->with('success','Saved!');

      }

      // That user wasn't valid
      return redirect()->route('user.settings.view')->withInput()->with('error','Invalid user');

    }


    /*
    * Save the user's updated settings
    *
    */
    public function postUpdateNotifications()
    {

      if ($user = \App\User::find(Auth::user()->id)) {

        if (!$user->save()) {
           return redirect()->route('user.settings.view')->withInput()->withErrors($user->getErrors());
        }

        return redirect()->route('user.settings.view')->with('success','Saved!');

      }

      // That user wasn't valid
      return redirect()->route('user.settings.view')->withInput()->with('error','Invalid user');

    }




    public function getProfile($id)
    {
        if ($user = \App\User::findOrFail($id)) {
          return view('users.view')->with('user',$user);
        } else {
          echo 'Invalid user';
        }

    }

}
