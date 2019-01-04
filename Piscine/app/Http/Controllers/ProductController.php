<?php

namespace App\Http\Controllers;

use App\Avis;
use App\Contenir;
use App\Produit;
use App\Reservation;
use Illuminate\Http\Request;
use App\Client;
use App\Commerce;


class ProductController extends Controller
{

    public function show($id)
    {
        $product = Produit::productWithId($id);
        $avis = Avis::allReviewsOfThisProduct($id);
        $commerce = Commerce::shopWithSiret($product->numSiretCommerce);
        $noteMoy = Produit::noteMoy($avis);
        //ajout de toute les couleurs
        $allProducts = Produit::all();
        $product->colors = $product->addColors($allProducts);
        return view('product')->with(['product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('addToProduct')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('book')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));
        }
    }

}