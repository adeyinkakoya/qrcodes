<?php

use Illuminate\Support\Facades\Storage;

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

Route::group(['middleware' => 'auth'], function() {

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('qrcodes', 'QrcodeController');
Route::resource('users', 'UserController');
Route::resource('transactions', 'TransactionController');
Route::resource('roles', 'RoleController');

});
