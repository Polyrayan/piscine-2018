<?php

namespace App\Http\Controllers;

use App\Avis;
use App\Contenir;
use App\Produit;
use App\Reservation;
use App\Commande;
use App\Panier;
use App\Detenir;
use Illuminate\Http\Request;
use App\Client;
use App\Commerce;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    public function show($id)
    {
        $mailClient = Client::getMailClient();
        $product = Produit::productWithId($id);
        $avis = Avis::allReviewsOfThisProduct($id);
        $commerce = Commerce::shopWithSiret($product->numSiretCommerce);
        $noteMoy = Produit::noteMoy($avis);

        //ajout de toute les couleurs
        $allProducts = Produit::all();
        $product->colors = $product->addColors($allProducts);

        return view('product')->with(['product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy, 'mailClient' => $mailClient]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('addToProduct')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('book')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));

        } elseif ($request->has('add')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0', 'max:99999']
            ]);

            $panier = Panier::firstOrNewPanier(request('mailClient'));
            Panier::addPriceToThisShoppingCart($panier,request('productPrice'),request('quantity'));

            $commande = Commande::firstOrNewCommande($panier,request('numSiret'));
            Commande::addPriceToThisOrder($commande,request('productPrice'),request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande,request('product'));
            Detenir::storeQuantity($detenir,request('quantity'));

            return back();
        }

    }

}
