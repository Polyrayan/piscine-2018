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

Route::get('/','HomeController@show');
Route::post('/','ShopController@selectForm');

Route::get('/register','RegisterController@showForm');
Route::post('/register','RegisterController@findChoice');

Route::get('/register/optionalForm','RegisterController@showOptionalForm');
Route::post('/register/optionalForm','RegisterController@findChoice');

Route::get('/login','LoginController@showForm');
Route::post('/login','LoginController@selectForm');

Route::get('/client/profil','ProfileController@show');
Route::post('/client/profil','ProfileController@selectForm');

Route::get('/vendeur/profil','ProfileController@show');

Route::get('/vendeur/commerces','ShopController@show');
Route::post('/vendeur/commerces','ShopController@selectForm');

Route::get('/vendeur/commerces/{numSiretCommerce}','ShopController@myShop');
Route::post('/vendeur/commerces/{numSiretCommerce}','ShopController@selectForm');

Route::get('/vendeur/commerces/{numSiretCommerce}/ventes','ShopSalesController@mySales');
Route::post('/vendeur/commerces/{numSiretCommerce}/ventes','ShopSalesController@selectForm');

Route::get('/vendeur/commerces/{numSiretCommerce}/horaires','ShopScheduleController@show');
Route::post('/vendeur/commerces/{numSiretCommerce}/horaires','ShopScheduleController@selectForm');

Route::get('/vendeur/commerces/{numSiretCommerce}/variante/{group}','ShopProductsController@show');
Route::post('/vendeur/commerces/{numSiretCommerce}/variante/{group}','ShopProductsController@selectForm');


Route::get('/vendeur/{id}','ProfileController@idVendeur');
Route::get('/client/{id}','ProfileController@idClient');

Route::get('/client/{id}/reservations', 'ReservationController@show' );
Route::post('/client/{id}/reservations', 'ReservationController@selectForm' );

Route::get('/client/{id}/panier', 'ShoppingCartController@show' );
Route::post('/client/{id}/panier', 'ShoppingCartController@selectForm' );

Route::get('/client/{id}/panier/confirmation', 'ShoppingCartController@showConfirmation' );
Route::post('/client/{id}/panier/confirmation', 'ShoppingCartController@selectForm' );

Route::get('/client/{id}/commandes', 'ProfileController@purchaseClient' );
Route::post('/client/{id}/commandes', 'ProfileController@selectForm' );

Route::get('/commerces/{numSiretCommerce}','ShopController@numSiret');
Route::post('/commerces/{numSiretCommerce}','ShopController@selectForm');

Route::get('/produits/{id}','ProductController@show');

Route::get('/admin','AdminController@show');
Route::post('/admin','AdminController@selectForm');
