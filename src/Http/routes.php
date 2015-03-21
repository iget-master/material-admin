<?php

Route::group(array('namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => 'auth'), function()
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

	Route::get('/setting', array('as' => 'setting.index', 'uses' => 'SettingController@index'));
	Route::get('/setting/{setting}', array('as' => 'setting.show', 'uses' => 'SettingController@show'));
	Route::get('/setting/{setting}/edit/{id}', array('as' => 'setting.edit', 'uses' => 'SettingController@edit'));
	Route::get('/setting/{setting}/delete/{id}', array('as' => 'setting.delete', 'uses' => 'SettingController@destroy'));
	Route::get('/setting/{setting}/create', array('as' => 'setting.create', 'uses' => 'SettingController@create'));
	Route::patch('/setting/{setting}/update/{id}', array('as' => 'setting.update', 'uses' => 'SettingController@update'));
	Route::post('/setting/{setting}/store', array('as' => 'setting.store', 'uses' => 'SettingController@store'));
	Route::delete('/setting/{setting}/update/{id}', array('as' => 'setting.destroy', 'uses' => 'SettingController@destroy'));

});

Route::group(array('namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => 'guest'), function()
{
	Route::get('/login', array('as' => 'materialadmin.login', 'uses' => 'SessionController@create'));
	Route::post('/login', array('as' => 'materialadmin.authenticate', 'uses' => 'SessionController@store'));
});
