<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'api/v1'), function () {

  /*
  |--------------------------------------------------------------------------
  | API Community Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'groups'), function () {
    Route::get('{id}/members', '\App\Http\Controllers\Api\CommunitiesController@memberlist');
    Route::get('{id}/entries', '\App\Http\Controllers\Api\CommunitiesController@entrylist');
    Route::get('{id}', '\App\Http\Controllers\Api\CommunitiesController@show');
    Route::get('/', '\App\Http\Controllers\Api\CommunitiesController@all');
  });

  /*
  |--------------------------------------------------------------------------
  | API Member Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'members'), function () {
    Route::get('{id}', '\App\Http\Controllers\Api\UsersController@show');
    Route::get('/', '\App\Http\Controllers\Api\UsersController@all');
  });

  /*
  |--------------------------------------------------------------------------
  | API Entry Routes
  |--------------------------------------------------------------------------
  */
  Route::group(array('prefix' => 'entries'), function () {
    Route::get('{id}', '\App\Http\Controllers\Api\EntriesController@show');
    Route::get('/', '\App\Http\Controllers\Api\EntriesController@all');
  });

});


Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'auth'), function () {

	 # Logout
    Route::get('logout', array('as' => 'logout', 'uses' => 'Auth\AuthController@getLogout'));

    # Login
    Route::get('login', array('as' => 'login', 'uses' => 'Auth\AuthController@getLogin'));
    Route::post('login', 'Auth\AuthController@postLogin');

    # Register
    Route::get('register', array('as' => 'register', 'uses' => 'Auth\AuthController@getRegister'));
    Route::post('register', 'Auth\AuthController@postRegister');

    # Social
    Route::get('{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');


});

/*
|--------------------------------------------------------------------------
| Entry routes
|--------------------------------------------------------------------------
*/
Route::get('browse', array('as' => 'browse', 'uses' => 'CommunitiesController@getEntriesView'));
Route::get('members', array('as' => 'members', 'uses' => 'CommunitiesController@getMembers'));
Route::get('account/settings', array('middleware' => 'auth','as' => 'user.settings', 'uses' => 'UserController@getSettings'));
Route::get('users/{userID}', array('as' => 'user.profile', 'uses' => 'UserController@getProfile'));
Route::get('community/new', array('middleware' => 'auth','as' => 'community.create.form', 'uses' => 'CommunitiesController@getCreate'));
Route::post('community/new', array('middleware' => 'auth','as' => 'community.create.save', 'uses' => 'CommunitiesController@postCreate'));

Route::get('entry/new', array('middleware' => 'auth','as' => 'entry.create.form', 'uses' => 'EntriesController@getCreate'));
Route::post('entry/new', array('middleware' => 'auth','as' => 'entry.create.save', 'uses' => 'EntriesController@postCreate'));

Route::get('json.browse', array('as' => 'json.browse', 'uses' => 'EntriesController@getEntriesDataView'));



/*
|--------------------------------------------------------------------------
| Default homepage stuff
|--------------------------------------------------------------------------
*/

Route::get('terms', function () {
  return view('terms');
});

Route::get('privacy', function () {
  return view('privacy');
});

Route::get('home', function () {
    return redirect('/');
 });


Route::get('/', array('as' => 'home', 'uses' => 'PagesController@getHomepage'));
});
