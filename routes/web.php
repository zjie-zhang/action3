<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::any('auth/login', [ 'as' => 'login-get', 'uses' => 'Auth\LoginController@login' ])->name("login");

//Route::any('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login']);

Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware'=>''], function(){
    Route::get('dataCenter/index','dataCenter@index')->name('datacenter');
    Route::get('dataCenter/store','dataCenter@store');
    Route::get('dataCenter/update','dataCenter@update');
});

//Route::group(['prefix' => 'GraphQL','namespace' => 'GraphQL'], function(){
//    Route::any('Query/index','Query@index')->name('querygraph');
//});
