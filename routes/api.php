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
Route::post('/userrouteregister','api\UserManageController@userrouteregister');
Route::post('/userroutelogin','api\UserManageController@userroutelogin');


Route::group(['middleware' => 'auth:api'], function(){
Route::get('/allcategories','api\APICategoryController@allcategories');
Route::get('/subcategoriesbycat/{id}','api\APICategoryController@subcategories');
Route::get('/movienamebysub/{id}','api\APICategoryController@movienamebysub');
Route::get('/moviebyid/{id}','api\APICategoryController@moviebyid');
Route::get('/recentlymoviename','api\APICategoryController@recentlymoviename');
Route::get('/homeslider','api\APICategoryController@homeslider');
});



// Route::get('login/facebook', 'api\UserManageController@redirectToProviderfacebook');
// Route::get('login/facebook/callback', 'api\UserManageController@handleProviderCallbackfacebook');