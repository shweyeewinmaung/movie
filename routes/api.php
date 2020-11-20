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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('alluser','api\UserManageController@index');
Route::get('/sociallogin','api\UserManageController@loginwithsocial');

Route::get('/userroute','api\UserManageController@userroute');
Route::get('/userrouteregister','api\UserManageController@userrouteregister');
Route::get('/userroutelogin','api\UserManageController@userroutelogin');

// Route::get('login/facebook', 'api\UserManageController@redirectToProviderfacebook');
// Route::get('login/facebook/callback', 'api\UserManageController@handleProviderCallbackfacebook');