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

Route::view('/','welcome');

Route::get('/register', 'RegisterClientController@showForm');
Route::post('/register', 'RegisterClientController@findUser');

Route::get('/login', 'LoginController@showForm');
Route::post('/login', 'LoginController@findUser');

Route::get('/register/optionalForm', 'RegisterClientController@showOptionalForm');
Route::post('/register/optionalForm', 'RegisterClientController@applyOptionalForm');


Route::get('/client/profil', 'ProfileController@show');
Route::get('/vendeur/profil', 'ProfileController@show');


