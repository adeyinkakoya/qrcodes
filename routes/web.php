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
Route::resource('users', 'UserController');

// Sending a post request from a form to the routes and routing to a controller
Route::post('/accounts/payout','AccountController@payout')->name('accounts.payout');


// Webmaster , Admin , Moderator
Route::group(['middleware' => 'checkwebmaster'], function() {
  
    Route::resource('qrcodes', 'QrcodeController');
    

    // Admin and Moderator
    Route::group(['middleware' => 'checkmoderator'], function() {

        // remove index and create routes of accounts and restrict them Admin/Moderator. Only admin should be able to view and create accounts and account Histories
        Route::get('/accounts','AccountController@index')->name('accounts.index');
        Route::get('/accountHistories', 'Account_historyController@index')->name('accountHistories.index');
        Route::get('/users','UserController@index')->name('users.index');
        // Mark as paid is an admin function. Add to the admin/Moderator group middleware
        Route::post('/accounts/mark_as_paid','AccountController@mark_as_paid')
        ->name('accounts.mark_as_paid');


        // Admin alone. Attached to a single route , no need for group. Its just 1 route
        Route::resource('roles', 'RoleController')->middleware('checkadmin');
        Route::get('accounts/create','AccountController@create')->name('accounts.create')
        ->middleware('checkadmin');
        Route::get('/accountHistories/create', 'Account_historyController@index')->name('accountHistories.create')
        ->middleware('checkadmin');
        Route::get('/users/create','UserController@create')->name('users.create');
    

    });
    

});


});
