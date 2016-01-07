<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Theme;
use App\Entry;
use Input;
use Validator;
use Redirect;
use Config;
use App\Exchange;
use Form;
use Pagetheme;

class CommunitiesController extends Controller
{

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
    $community = new \App\Community();
    $validator = Validator::make(Input::all(), $community->rules);

    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator->messages());
    } else {

      $community->name	= e(Input::get('name'));
      $community->subdomain	= e(Input::get('subdomain'));
      $community->created_by	= Auth::user()->id;

      if ($community->save()) {
        $community->members()->attach(Auth::user(), ['is_admin' => true]);
        return redirect('http://'.$community->subdomain.'.'.Config::get('app.domain'))->with('success','Welcome to your new Community!');
      }

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
    $validator = Validator::make(Input::all(), $community->rules);

    if ($validator->fails()) {
      return Redirect::back()->withInput()->withErrors($validator->messages());
    } else {

      $community->name	= e(Input::get('name'));
      $community->subdomain	= e(Input::get('subdomain'));

      if ($community->save()) {
        return redirect('http://'.$community->subdomain.'.'.Config::get('app.domain'))->with('success',trans('general.community.messages.save_edits'));
      }
    }
  }



}
