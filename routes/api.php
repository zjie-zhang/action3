<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Route::group(['prefix' => 'GraphQL','namespace' => 'GraphQL'], function(){
//    Route::any('Query/index','Query@index')->name('querygraph');
//});

//Route::middleware('auth:api')->any('GraphQL/Query/index', function (Request $request) {
//    return $request->index();
//});

//Route::middleware('auth:api')->post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login']);


//Route::middleware('api')->any('Admin/Query/index/{query}', 'GraphQL\Query@index')->name('graphql');

// elemental生成action文件通知接口
Route::middleware('api')->post('data/actionFile', 'Api\Data@actionFile')->name('actionFile');
