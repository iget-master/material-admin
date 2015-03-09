<?php

Route::group(array('namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => 'permission'), function()
{
	/*
	|--------------------------------------------------------------------------
	| Package Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('/', array('as'=>'materialadmin.empty', function() { return View::make('materialadmin::empty'); }));

	/*
	|-------------------------------
	| Authentication related routes
	|-------------------------------
	*/

	Route::get('/logout', array('as' => 'materialadmin.logout', 'uses' => 'SessionController@destroy'));

	/*
	|---------------------
	| User related routes
	|---------------------
	*/

	Route::resource('user', "UserController",  array('except' => array('show')));
	Route::delete('/user/multiple_destroy', array('as' => 'user.multiple_destroy', 'uses' => 'UserController@multiple_destroy'));

	route::get('/settings', function() {
		return view('materialadmin::settings');
	});
});

Route::group(array('namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => 'guest'), function()
{
	Route::get('/login', array('as' => 'materialadmin.login', 'uses' => 'SessionController@create'));
	Route::post('/login', array('as' => 'materialadmin.authenticate', 'uses' => 'SessionController@store'));
});
