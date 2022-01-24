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
});

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware' => ['web', 'auth', 'permission']], function () {
    Route::get('/setting', ['as' => 'setting.index', 'uses' => 'SettingController@index']);
    Route::get('/setting/{setting}', ['as' => 'setting.show', 'uses' => 'SettingController@show']);
    Route::get('/setting/{setting}/edit/{id}', ['as' => 'setting.edit', 'uses' => 'SettingController@edit']);
    Route::get('/setting/{setting}/delete/{id}', ['as' => 'setting.delete', 'uses' => 'SettingController@destroy']);
    Route::get('/setting/{setting}/create', ['as' => 'setting.create', 'uses' => 'SettingController@create']);
    Route::patch('/setting/{setting}/update/{id}', ['as' => 'setting.update', 'uses' => 'SettingController@update']);
    Route::post('/setting/{setting}/store', ['as' => 'setting.store', 'uses' => 'SettingController@store']);
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

Route::group(['namespace' => 'IgetMaster\MaterialAdmin\Controllers', 'middleware'=>['public-api']], function () {
    Route::get('/search/{model}/{query}/{scope0?}/{scope1?}/{scope2?}/{scope3?}/{scope4?}', ['as' => 'search', 'uses' => 'SearchController@search']);
});
