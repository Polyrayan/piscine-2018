<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Avis;
use App\Client;
use App\Commande;
use App\Commerce;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Reduction;
use App\Vendeur;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $points = Reduction::getReductionPoints($client->mailClient);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $history = Commande::completedOrders($id);
        foreach ($history as $his){
            $his->store = Commerce::nameOfThisShop($his->numSiretCommerce);
            $detenirs = Detenir::getDetenirForThisCommande($his);
            $aux = array();
            foreach ($detenirs as $detenir) {
                $nomProduit = Produit::productWithId($detenir->numProduit)->nomProduit;
                $numProduit = Produit::productWithId($detenir->numProduit)->numProduit;
                $qte = Detenir::firstOrNewDetenir($his, $numProduit)->qteCommande;
                array_push($aux, [$nomProduit, $qte]);
            }
            $his->produits = $aux;
        }
        //return $history;
        return view('profiles.myClientProfile')->with(['client'=>$client, 'points'=> $points, 'id' => $id, 'completedOrders' => $history,'nbCompare' => $nbCompare]);
    }


    public function idClient($id){
        $client = Client::getClientWithId($id);
        return view('profiles.clientProfile', ['client' => $client]);
    }

    public function purchaseClient($id)
    {
        $nbCompare = Client::calculNumberOfProductToCompare();
        $client = Client::getClientWithId($id);
        $commandes = Panier::getPurchaseOfThisMailClient($client->mailClient);
        return view('myPurchases', ['id' => $id,'commandes' => $commandes, 'client' => $client,'nbCompare' => $nbCompare]);
    }
    public function selectForm(Request $request)
    {
        // view myPurchases

        if ($request->has('rate')) {
            Avis::validateReview();
            Avis::createOrUpdateClientReviewOnThisProduct();
            return back();
        }

        // view myClientProfile

        elseif ($request->has('editClient')){
            Client::validateUpdate();
            Client::updateClient();
            return back();
        }
    }

    public function rating($mailClient,$productNumber,$mark,$comment){


         return back();
    }

    public function idVendeur($id){
        $seller = Vendeur::sellerWithThisId($id);
        $shops = Appartenir::shopsOfThisSeller($seller->mailVendeur);
        return view('profiles.sellerProfile', ['seller' => $seller, 'shops' => $shops]);
    }

}
