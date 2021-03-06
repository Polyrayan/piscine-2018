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
use App\Admin;
use App\Vendeur;


class ProductController extends Controller
{

    public function show($id)
    {
        $product = Produit::productWithId($id);
        $avis = Avis::allReviewsOfThisProduct($id);
        $commerce = Commerce::shopWithSiret($product->numSiretCommerce);
        $noteMoy = Produit::noteMoy($avis);
        $productsOfCategory = Produit::productsOfThisGroup($product->numGroupeVariante);
        $suggest = Produit::productsOfThisCategoryRandom($product->nomTypeProduit);
        $suggestions=[];
        $products=Produit::groupBy('numGroupeVariante')->inRandomOrder()->get();
        foreach ($suggest as $suggestion) {
          if ($suggestion->numProduit != $id) {
            array_push($suggestions,$suggestion);
          }
        }
        if(empty($suggestions)) {
          foreach ($products as $prod) {
            if ($prod->numProduit != $id) {
              array_push($suggestions,$prod);
            }
          }
        }
        $clientConnected = Client::isConnected();
        if($clientConnected){
          $nbCompare = Client::calculNumberOfProductToCompare();
          $id = Client::getIdClient();
          return view('product')->with(['products' => $products, 'productsOfCategory' => $productsOfCategory ,
              'product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy, 'id' => $id,
              'nbCompare' => $nbCompare, 'suggestions' => $suggestions, 'clientConnected' => 'Client']);
        }
        else{
          $favoriteShop = Vendeur::getMyFavoriteShop();
          $adminConnected = Admin::isConnected();
          return view('product')->with(['products' => $products , 'productsOfCategory' => $productsOfCategory ,
              'product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy ,
              'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected, 'clientConnected' => 'Seller']);
        }
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
        }elseif ($request->has('deleteReview')) {
            Avis::deleteAvis(request('numberReview'));
            flash('Cet avis a été supprimé')->success();
            return back();
        }
    }
}
