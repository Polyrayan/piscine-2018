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

Route::group(['middleware' => 'App\Http\Middleware\Admin'], function () {
    Route::get('/admin','AdminController@show');
    Route::post('/admin','AdminController@selectForm');

    Route::get('/admin/deconnexion','Auth\LoginController@logoutAdmin');
});

Route::group(['middleware' => 'App\Http\Middleware\Client'] , function () {

    Route::get('/','HomeController@show');
    Route::post('/','HomeController@selectForm');

    Route::get('/1','testController@show');
    Route::get('/1/action','testController@action')->name('testController.action');

    Route::get('/client/profil','ProfileController@showClient');
    Route::post('/client/profil','ProfileController@selectForm');

    Route::get('/client/{id}/reservations', 'ReservationController@show' );
    Route::post('/client/{id}/reservations', 'ReservationController@selectForm' );

    Route::get('/client/{id}/panier', 'ShoppingCartController@show' );
    Route::post('/client/{id}/panier', 'ShoppingCartController@selectForm' );

    Route::get('/client/{id}/panier/confirmation', 'ShoppingCartController@showConfirmation' );
    Route::post('/client/{id}/panier/confirmation', 'ShoppingCartController@selectForm' );

    Route::get('/client/{id}/panier/confirmation/facture', 'OrderOkController@showReceipt' );
    Route::post('/client/{id}/panier/confirmation/facture', 'OrderOkController@selectForm' );

    Route::get('/client/{id}/commandes', 'ProfileController@purchaseClient' );
    Route::post('/client/{id}/commandes', 'ProfileController@selectForm' );

    Route::get('/commerces/{numSiretCommerce}','ShopController@numSiret');
    Route::post('/commerces/{numSiretCommerce}','ShopController@selectForm');

    Route::get('/MesComparaisons','CompareController@show');
    Route::post('/MesComparaisons','CompareController@delete');

    Route::get('/client/{id}/reservationsConfirmed','ReservationsConfirmedController@show');

    Route::get('/client/deconnexion','Auth\LoginController@logoutClient');
});

Route::group(['middleware' => 'App\Http\Middleware\Vendeur'], function () {

    Route::get('/vendeur/commerces','ShopController@show');
    Route::post('/vendeur/commerces','ShopController@selectForm');

    Route::get('/vendeur/commerces/{numSiretCommerce}','ShopController@myShop');
    Route::post('/vendeur/commerces/{numSiretCommerce}','ShopController@selectForm');

    Route::get('/vendeur/commerces/{numSiretCommerce}/ventes','ShopSalesController@mySales');
    Route::post('/vendeur/commerces/{numSiretCommerce}/ventes','ShopSalesController@selectForm');

    Route::get('/vendeur/commerces/{numSiretCommerce}/horaires','ShopScheduleController@show');
    Route::post('/vendeur/commerces/{numSiretCommerce}/horaires','ShopScheduleController@selectForm');

    Route::get('/vendeur/commerces/{numSiretCommerce}/coupons','ShopCouponsController@show');
    Route::post('/vendeur/commerces/{numSiretCommerce}/coupons','ShopCouponsController@selectForm');

    Route::get('/vendeur/commerces/{numSiretCommerce}/variante/{group}','ShopProductsController@show');
    Route::post('/vendeur/commerces/{numSiretCommerce}/variante/{group}','ShopProductsController@selectForm');

    Route::get('/vendeur/commerces/produit/{id}','ShopController@editProduct');
    Route::post('/vendeur/commerces/produit/{id}','ShopController@selectForm');

    Route::get('/vendeur/profil','ProfileController@showSeller');
    Route::post('/vendeur/profil','ProfileController@selectForm');

    Route::get('/vendeur/deconnexion','Auth\LoginController@logoutSeller');
});

Route::get('/register','RegisterController@showForm');
Route::post('/register','RegisterController@findChoice');

Route::get('/register/optionalForm','RegisterController@showOptionalForm');
Route::post('/register/optionalForm','RegisterController@findChoice');

Route::get('/login','Auth\LoginController@showForm');
Route::post('/login','Auth\LoginController@selectForm');

Route::get('/login/admin','Auth\LoginController@showAdminForm');
Route::post('/login/admin','Auth\LoginController@selectForm');

Route::get('/client/{id}','ProfileController@idClient');

Route::get('/vendeur/{id}','ProfileController@idVendeur');

Route::get('/produits/{id}','ProductController@show');
Route::post('/produits/{id}','ProductController@selectForm');

Route::get('/contact', 'ContactController@show');

Route::get('/credits', 'CreditsController@show');