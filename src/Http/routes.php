<?php

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => ['web', 'auth']], function () {
    /*
    |-------------------------------
    | Authentication related routes
    |-------------------------------
    */

    Route::get('/logout', ['as' => 'materialadmin.logout', 'uses' => 'SessionController@destroy']);

    /*
    |--------------------------------------------------------------------------
    | Package Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/', ['as'=>'materialadmin.empty', 'uses' => 'HomeController@index']);

    /*
    |-----------------------
    | Get/Post Image Engine
    |-----------------------
    */
    Route::get('/user/{id}/photo', ['as'=>'user.getImage', 'uses' => 'UserController@getUserImage']);
    Route::get('/user/photo/{filename}', ['as'=>'user.getTemporaryImage', 'uses' => 'UserController@getTemporaryImage']);

    /*
    |----------------------
    | Message system routes
    |----------------------
    */
    Route::resource('message', "MessageController", ['except' => ['edit', 'update']]);
    Route::get('/message/{id}/mark/read', ['as' => 'message.markread', 'uses' => 'MessageController@markAsRead']);
    Route::get('/message/{id}/mark/unread', ['as' => 'message.markunread', 'uses' => 'MessageController@markAsUnread']);
});

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => ['web', 'auth', 'permission']], function () {
    /*
	|---------------------
	| User related routes
	|---------------------
	*/

    Route::resource('user', "UserController", ['except' => ['show']]);
    Route::get('/user/password/{id?}', ['as' => 'user.edit_password', 'uses' => 'UserController@editPassword']);
    Route::patch('/user/password/{id?}', ['as' => 'user.update_password', 'uses' => 'UserController@updatePassword']);


    Route::get('/setting', ['as' => 'setting.index', 'uses' => 'SettingController@index']);
    Route::get('/setting/{setting}', ['as' => 'setting.show', 'uses' => 'SettingController@show']);
    Route::get('/setting/{setting}/edit/{id}', ['as' => 'setting.edit', 'uses' => 'SettingController@edit']);
    Route::get('/setting/{setting}/delete/{id}', ['as' => 'setting.delete', 'uses' => 'SettingController@destroy']);
    Route::get('/setting/{setting}/create', ['as' => 'setting.create', 'uses' => 'SettingController@create']);
    Route::patch('/setting/{setting}/update/{id}', ['as' => 'setting.update', 'uses' => 'SettingController@update']);
    Route::post('/setting/{setting}/store', ['as' => 'setting.store', 'uses' => 'SettingController@store']);

    Route::post('/user/photo', ['as'=>'user.uploadImage', 'uses' => 'UserController@uploadUserImage']);

});

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => ['web', 'guest']], function () {

    Route::get('/login', ['as' => 'materialadmin.login', 'uses' => 'SessionController@create']);
    Route::post('/login', ['as' => 'materialadmin.authenticate', 'uses' => 'SessionController@store']);
});

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => ['web']], function () {
    Route::get('/auth/check', ['as' => 'materialadmin.check', 'uses' => 'SessionController@check']);
});

/*
|---------------
| Search Engine
|---------------
*/

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware'=>['public-api','cors']], function () {
    Route::get('/search/{model}/{query}/{scope0?}/{scope1?}/{scope2?}/{scope3?}/{scope4?}', ['as' => 'search', 'uses' => 'SearchController@search']);
});
