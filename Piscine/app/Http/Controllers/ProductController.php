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
      $mailClient = Client::getMailClient();
      $product = Produit::productWithId($id);
      $avis = Avis::allReviewsOfThisProduct($id);
      $commerce = Commerce::shopWithSiret($product->numSiretCommerce);
      $noteMoy = Produit::noteMoy($avis);
      //ajout de toute les couleurs
      $allProducts = Produit::all();
      $product->colors = $product->addColors($allProducts);
      
      $id = Client::getIdClient();
      return view('product')->with(['product' => $product , 'avis' => $avis , 'commerce' => $commerce , 'noteMoy' => $noteMoy, 'mailClient' => $mailClient, 'id' => $id]);
  }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('addToProduct')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('book')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));

        } elseif ($request->has('add')) {

            if(null == request('quantity')){
              return back()->withInput()->withErrors(['qte' => "Veuillez choisir une quantité",]);
            }

            if("rien" == request('color')){
              return back()->withInput()->withErrors(['color' => "Veuillez choisir une couleur",]);
            }

            $productNumber = Produit::whichProduct(); // fonction a tester
            //$product = Produit::productWithId(request('product')); // sans passer par la fonction (ne marche pass pour $detenir)

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0']
            ]);

            $panier = Panier::firstOrNewPanier(request('mailClient'));
            Panier::addPriceToThisShoppingCart($panier,request('productPrice'),request('quantity'));

            $commande = Commande::firstOrNewCommande($panier,request('numSiret'));
            Commande::addPriceToThisOrder($commande,request('productPrice'),request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande,$productNumber); //request('product') == $product->numProduit
            Detenir::storeQuantity($detenir,request('quantity'));

            return back();
        }

    }

}
