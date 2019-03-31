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

Route::get('contact/submit', function(){

    return " This is using the url helper";
});

Route::get('/test', function(){

    return view('test');
});

Auth::routes();

// All of these routes need only authentication. General routes
Route::group(['middleware' => 'auth'], function() {

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('transactions', 'TransactionController');

Route::resource('accounts', 'AccountController');

Route::resource('accountHistories', 'Account_historyController');

// The following routes needs Authorization. Admin and Moderators and Webmasters
Route::group(['middleware' => 'checkwebmaster'], function() {
  
    Route::resource('qrcodes', 'QrcodeController');
    
    // Admin and Moderator
    Route::group(['middleware' => 'checkmoderator'], function() {

        Route::resource('users', 'UserController');

        // Admin alone. Attached to a single route , no need for group. Its just 1 route
        Route::resource('roles', 'RoleController')->middleware('checkadmin');

    });
    

});


});
