<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Vendeur;
use App\Admin;
use Illuminate\Http\Request;

class ShopProductsController extends Controller
{

    public function show($siret,$groupNumber)
    {

        $products = Produit::productsOfThisGroup($groupNumber);
        $exemple = Produit::firstProductOfThisGroup($groupNumber);
        $category = Produit::category($groupNumber);
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $adminConnected = Admin::isConnected();

        return view('editVariantesShop')->with(['products' => $products , 'numShop' => $siret , 'category'=> $category ,
            'exemple' => $exemple , 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('add')) {
            //Produit::validateProduct();
            Produit::createProduct(request('variantNumber'));
            return back();

        } elseif ($request->has('delete')) {
            Produit::deleteProduct(request('productNumber'));
            return back();

        } elseif ($request->has('edit')) {
            return redirect('/vendeur/commerces/produit/'.request('variant'));

        }
    }
}
