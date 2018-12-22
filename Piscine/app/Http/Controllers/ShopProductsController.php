<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Avis;
use App\Client;

use App\Panier;
use App\Produit;
use App\Reduction;
use App\Variante;
use App\Vendeur;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopProductsController extends Controller
{

    public function show($siret,$groupNumber)
    {
        $products = Produit::productsOfThisGroup($groupNumber);
        $exemple = Produit::firstProductOfThisGroup($groupNumber);
        $category = Produit::category($groupNumber);

        return view('editVariantesShop')->with(['products' => $products , 'numShop' => $siret , 'category'=> $category , 'exemple' => $exemple]);
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
            return 'a faire';
        }
    }
}
