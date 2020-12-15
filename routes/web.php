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
 return  redirect('/admin') ;
   // return view('welcome');
});

// Route::get('/home', function () { 
//   return view('home');
// });

// Route::get('/login', function () { 
//   return view('auth.login');
// });
// Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('facebook.login');
// Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle')->name('google.login');
// Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/admin', 'AdminController@index')->name('admin.home');

Route::prefix('admin')->group(function(){
  Route::get('/','AdminController@index')->name('admin.dashboard');

  Route::get('/logout','AdminController@logout')->name('admin.logout');  
  Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');

  /***********************Admin User Start*************************************/

  Route::get('/adminregister','AdminController@register')->name('admin.register');
  Route::post('/adminregister','AdminController@store')->name('admin.register.submit');
  Route::post('/admin/{id}/edit','AdminController@update')->name('admin.edit.submit');
  Route::post('/admin/{id}/delete', 'AdminController@destory')->name('admin.delete');
  Route::get('/adminlist','AdminController@adminlist')->name('admin.list');
  Route::get('/adminlist/search/post', 'AdminController@searchpost')->name('search');

  //Route::get('/adminhistory/{id}','AdminController@adminhistory')->name('adminhistory.list');

  /***********************Admin User End*************************************/
  /***********************Category Start*************************************/

  Route::get('/CategoryList','CategoryController@index')->name('category.list');
  Route::post('/CategoryStore','CategoryController@store')->name('category.store');
  Route::get('/CategoryList/search/post', 'CategoryController@searchcategory')->name('category.search');
  Route::post('/CategoryList/{id}/edit','CategoryController@update')->name('category.edit');
  Route::post('/CategoryList/{id}/delete', 'CategoryController@destroy')->name('category.delete');

  /***********************Category End*************************************/
  /***********************Sub-Category Start*************************************/
  
  Route::get('/SubCategoryList','SubCategoryController@index')->name('subcategory.list');
  Route::get('/SubCategoryList/search/post', 'SubCategoryController@searchsubcategory')->name('subcategory.search');
  Route::post('/SubCategoryStore','SubCategoryController@store')->name('subcategory.store');
  Route::post('/SubCategoryList/{id}/edit','SubCategoryController@update')->name('subcategory.update');
  Route::post('/SubCategoryList/{id}/delete', 'SubCategoryController@destroy')->name('subcategory.delete');

  /***********************Sub-Category End*************************************/
  /***********************Movie Name Start*************************************/

  Route::get('/MovieNameList','MovieNameController@index')->name('moviename.list');
  Route::get('/MovieNameList/search/post', 'MovieNameController@searchmoviename')->name('moviename.search');
  Route::get('/MovieNameList/subcategory/get/{id}', 'MovieNameController@getsubcategory');
  Route::post('/MovieNameList/image_upload', 'MovieNameController@imageupload')->name('uploads');
  Route::post('/MovieNameStore','MovieNameController@store')->name('moviename.store');
  Route::post('/MovieNameList/{id}/edit','MovieNameController@update')->name('moviename.update');
  Route::post('/MovieNameList/{id}/delete', 'MovieNameController@destroy')->name('moviename.delete');

  /***********************Movie Name End*************************************/
  /***********************Movie Upload Start*************************************/

  Route::get('/MovieListSearch','MovieController@index')->name('moviesearch.list');
  Route::get('/MovieListSearch/subcategory/get/{id}', 'MovieController@getsubcategory');
  Route::get('/MovieListSearch/search/list', 'MovieController@moviesearchlist')->name('moviesearchlist.search');
  Route::get('/MovieListSearch/searchmovie/list/{category_id}/{subcategory_id}', 'MovieController@moviesearchmovielist')->name('moviesearchmovielist.search');
 /***** Episode Start *******/
  Route::get('/MovieEpisodeList/{moviename_id}', 'MovieController@movieepisodelist')->name('movieepisodelist');
  Route::post('/MovieEpisodeStore', 'MovieController@store')->name('movieepisode.store');
  Route::post('/MovieEpisodeList/{moviename_id}/{id}/edit','MovieController@update')->name('movieepisode.update');
  Route::post('/MovieEpisodeList/{moviename_id}/{id}/delete', 'MovieController@destroy')->name('movieepisode.delete');
  /***** Episode End *******/
  /***** Single Movie Start *******/
  Route::get('/MovieSingleList/{moviename_id}', 'MovieController@moviesinglelist')->name('moviesinglelist');
  Route::post('/MovieSingleStore', 'MovieController@singlemoviestore')->name('moviesingle.store');
  Route::post('/MovieSingleList/{moviename_id}/{id}/edit','MovieController@updatemoviesingle')->name('moviesingle.update');
  Route::post('/MovieSingleList/{moviename_id}/{id}/delete', 'MovieController@destroymoviesingle')->name('moviesingle.delete');

  Route::post('/MovieSingleList/{moviename_id}/statusupdate', 'MovieController@statusupdate')->name('statusupdate');
  /***** Single Movie End *******/
  /***********************Movie Upload End*************************************/
  /***********************History Comment Start*************************************/

  Route::get('/HistoryList','CommentController@index')->name('comment.list');
  Route::get('/HistoryListDay/{day}','CommentController@dayindex')->name('commentday.list');
  Route::get('/HistoryListDay/search/{day}', 'CommentController@searchday')->name('commentsearchday');
  Route::get('/HistoryListDate/{date}','CommentController@dateindex')->name('commentdate.list');
  Route::get('/HistoryListDate/searchmovie/list/{date}', 'CommentController@searchdate')->name('commentsearchdate');

  /***********************History Comment End *************************************/
  /***********************User Start*************************************/
  Route::get('/UserList','UserController@index')->name('user.list');
  Route::get('/UserList/search/post', 'UserController@searchuser')->name('user.search');
  Route::post('/UserList/{id}/typeofuser', 'UserController@usertypeupdate')->name('usertypesupdate');
 Route::post('/UserList/{id}/userstatus', 'UserController@userstatusupdate')->name('userstatusupdate');
 Route::post('/UserList/{id}/changepassword', 'UserController@changepassword')->name('changepassword');
 Route::post('/UserList/{id}/delete', 'UserController@destroyuser')->name('userfor.delete');
  /***********************User End*************************************/
  /*************************************************************/
  // Route::get('/VideoExample','UserController@videoexample')->name('videoexample');
  // Route::post('/VideoExample','UserController@videoexamplesave')->name('videoexample.save');


//    Route::get('/video', 'VideoController@index');
 
//     Route::get('/uploader', 'VideoController@uploader')->name('uploader');
 
     Route::post('/upload', 'VideoController@store')->name('upload');

//     Route::get('/queue-start', function (){
//   \Artisan::call('queue:work');
// });
  /*************************************************************/
  /***********************Advertising Start*************************************/
  Route::get('/AdvertisingList','AdvertisingController@index')->name('ads.list');
   Route::get('/AdvertisingList/search/post', 'AdvertisingController@searchdate')->name('ads.searchdate');
  Route::get('/AdvertisingAdd','AdvertisingController@create')->name('ads.create');
  Route::post('/AdvertisingAdd','AdvertisingController@store')->name('ads.store');
  Route::get('/AdvertisingEdit/{id}','AdvertisingController@edit')->name('ads.edit');
  Route::post('/AdvertisingList/{id}/edit','AdvertisingController@update')->name('ads.update');
  Route::post('/AdvertisingList/{id}/delete', 'AdvertisingController@destroy')->name('ads.delete');

  Route::get('/MediaLibrary','AvatorController@index')->name('avator.index');
  Route::post('/MediaLibraryCreate','AvatorController@store')->name('avator.store');
  Route::post('/MediaLibraryDelete/{id}','AvatorController@destroy')->name('avator.destroy');

  Route::get('/MediaLibrarySelected/{id}','AdvertisingController@select')->name('avator.select');

  Route::get('/MediaLibrarySelectedEdit/{id}/{avator_id}','AdvertisingController@selectedit')->name('avator.selectedit');

  Route::get('/MediaLibraryEdit/{id}','AvatorController@indexedit')->name('avator.indexedit');
  /***********************Advertising End*************************************/
  /***********************History Start*************************************/
  // Route::get('/history','HistoryController@index')->name('history.list');
  // Route::get('/historylist/search/post', 'HistoryController@searchpost')->name('history.search');

  /***********************History End*************************************/
  /***********************FTTH Start*************************************/
  // Route::get('/FTTH','FTTHController@index')->name('FTTH.list'); 
  // Route::post('/DeviceEntry','FTTHController@store')->name('device.entry.submit');
  // Route::get('/devicelist/search/post', 'FTTHController@searchpost')->name('device.search'); 
  // Route::post('/device/{id}/delete', 'FTTHController@destroy')->name('device.delete');
  // Route::post('/device/{id}/edit','FTTHController@update')->name('device.edit.submit');

  /***********************FTTH End*************************************/
  /***********************Category Start*************************************/
  // Route::get('/Category/{title}','CategoryController@index')->name('Category.list'); 
  // Route::get('/CategoryEntry/{title}','CategoryController@create')->name('Category.entry');
  // Route::post('/CategoryEntry/{title}','CategoryController@store')->name('Category.entry.submit');

 

  /***********************Category End*************************************/
  /***********************Items Start*************************************/
  // Route::post('/ItemnameEntry','ItemnameController@store')->name('itemname.store.submit');
  // Route::get('/ItemnameList/{title}','ItemnameController@index')->name('itemname.list');
  // Route::post('/ItemnameList/{id}/edit','ItemnameController@update')->name('itemname.edit.submit');
  // Route::post('/ItemnameList/{id}/delete', 'ItemnameController@destroy')->name('device.delete');
  // Route::get('/ItemnameList/show/{title}/{id}','ItemnameController@show')->name('itemnamelist.show');
  // Route::get('/ItemnameList/{title}/search/post', 'ItemnameController@searchpost')->name('ItemnameList.search');
  /***********************Items Start*************************************/
  /***********************Supplier Start*************************************/
  // Route::post('/SupplierEntry','SupplierController@store')->name('supplier.store.submit');
  // Route::get('/SupplierList','SupplierController@index')->name('supplier.list');
  // Route::post('/Supplier/{id}/delete', 'SupplierController@destroy')->name('device.delete');
  // Route::post('/Supplier/{id}/edit','SupplierController@update')->name('supplier.edit.submit');
  // Route::get('/supplierlist/search/post', 'SupplierController@searchpost')->name('supplier.search'); 

  /***********************Supplier End*************************************/
  
});
 Route::get('/users/logout','Auth\LoginController@userLogout')->name('user.logout');

 Route::get('/customer','CustomerController@index')->name('customer');