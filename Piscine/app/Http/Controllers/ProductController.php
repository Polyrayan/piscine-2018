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


class ProductController extends Controller
{

    public function show($id)
    {
        $product = Produit::productWithId($id);
        $avis = Avis::allReviewsOfThisProduct($id);
        $commerce = Commerce::shopWithSiret($product->numSiretCommerce);
        $noteMoy = Produit::noteMoy($avis);
        $products = Produit::productsOfThisGroup($product->numGroupeVariante);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $id = Client::getIdClient();
        return view('product')->with(['products' => $products ,'product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy, 'id' => $id,'nbCompare' => $nbCompare]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('addToProduct')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('book')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));

        } elseif ($request->has('add')) {
            request()->validate(['quantity' => ['bail', 'required', 'min:0', 'max:99999']]);

            $product = Produit::productWithId(request('variant'));

            $panier = Panier::firstOrNewPanier(Client::getMailClient());
            Panier::addPriceToThisShoppingCart($panier, $product->prixProduit, request('quantity'));

            $commande = Commande::firstOrNewCommande($panier, $product->numSiretCommerce );
            Commande::addPriceToThisOrder($commande, $product->prixProduit, request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande, $product->numProduit);
            Detenir::storeQuantity($detenir, request('quantity'));

            flash("Nouvel ajout au panier ")->success();
            return back();
        }
    }
}