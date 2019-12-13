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
Route::get('login', 'UserController@getLogin')->name('login');

Route::post('login', 'UserController@postLogin')->name('postLogin');

Route::post('logout', 'UserController@logout')->name('logout');

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
