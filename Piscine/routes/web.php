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

Route::view('/','welcome2');

Route::get('/register', 'RegisterClientController@showForm');
Route::post('/register', 'RegisterClienControllert@applyForm');

Route::get('/login', 'loginController@showForm');
Route::post('/login', 'loginController@applyForm');

Route::view('/register2','register');