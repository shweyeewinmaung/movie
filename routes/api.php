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


//Route::post('alluser','api\UserManageController@index');
//Route::post('/sociallogin','api\UserManageController@loginwithsocial');

Route::post('/socialuserroute','api\UserManageController@socialroute');
Route::post('/userrouteregister','api\UserManageController@userrouteregister');
Route::post('/userroutelogin','api\UserManageController@userroutelogin');


Route::group(['middleware' => 'auth:api'], function(){

Route::get('/allcategories','api\APICategoryController@allcategories');
Route::get('/subcategoriesbycat/{id}','api\APICategoryController@subcategories');
Route::get('/movienamebysub/{id}','api\APICategoryController@movienamebysub');
Route::get('/moviebyid/{id}','api\APICategoryController@moviebyid');
Route::get('/recentlymoviename','api\APICategoryController@recentlymoviename');
Route::get('/homeslider','api\APICategoryController@homeslider');
Route::get('/moviesbycat/{id}','api\APICategoryController@moviesbycat');

Route::get('/samplelink','api\APICategoryController@samplelink');

Route::get('/samplehomeslider','api\APICategoryController@samplehomeslider');
Route::get('/samplehomeslidermovie/{id}','api\APICategoryController@samplehomeslidermovie');
Route::get('/samplehomeslidermovieid/{id}/{season}','api\APICategoryController@samplehomeslidermovieid');

Route::get('/samplerecent','api\APICategoryController@samplerecent');

Route::get('/samplemoviebycat/{id}','api\APICategoryController@samplemoviebycat');

Route::get('/samplesearchmovie/{name}','api\APICategoryController@samplesearchmovie');

Route::get('/contact','api\APICategoryController@contact');

Route::get('/tvcategories','api\APICategoryController@tvcategories');
Route::get('/tvchannelsbytvcat/{id}','api\APICategoryController@tvchannelsbytvcat');

});



// Route::get('login/facebook', 'api\UserManageController@redirectToProviderfacebook');
// Route::get('login/facebook/callback', 'api\UserManageController@handleProviderCallbackfacebook');