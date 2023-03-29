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

Route::get('/', 'Auth\LoginController@showLoginForm');

// route used for chat
Route::resource('messages', 'MessagesController');
Route::post('storeConversations', 'MessagesController@store')->name('storeConversations');
Route::get('getConversations', 'MessagesController@getConversations')->name('getConversations');
// end of route
Route::get('json-response1', 'MessagesController@show1')->name('json-response1');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');