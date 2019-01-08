<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Avis;
use App\Client;
use App\Commande;
use App\Panier;
use App\Reduction;
use App\Vendeur;
use App\Commerce;
use App\Detenir;
use App\Produit;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function showClient()
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
                $couleur = Produit::productWithId($detenir->numProduit)->couleurProduit;
                $taille = Produit::productWithId($detenir->numProduit)->tailleProduit;
                $qte = Detenir::firstOrNewDetenir($his, $numProduit)->qteCommande;
                $livrer = Detenir::firstOrNewDetenir($his, $numProduit)->livrer;
                array_push($aux, [$nomProduit, $qte , $couleur , $taille, $livrer]);
            }
            $his->produits = $aux;
        }
        $processingOrders = Commande::processingOrders($id);
        foreach ($processingOrders as $his){
            $his->store = Commerce::nameOfThisShop($his->numSiretCommerce);
            $detenirs = Detenir::getDetenirForThisCommande($his);
            $aux = array();
            foreach ($detenirs as $detenir) {
                $nomProduit = Produit::productWithId($detenir->numProduit)->nomProduit;
                $numProduit = Produit::productWithId($detenir->numProduit)->numProduit;
                $couleur = Produit::productWithId($detenir->numProduit)->couleurProduit;
                $taille = Produit::productWithId($detenir->numProduit)->tailleProduit;
                $qte = Detenir::firstOrNewDetenir($his, $numProduit)->qteCommande;
                $livrer = Detenir::firstOrNewDetenir($his, $numProduit)->livrer;
                array_push($aux, [$nomProduit, $qte , $couleur , $taille, $livrer]);
            }
            $his->produits = $aux;
        }


        $reduction = Reduction::where('mailClient', $client->mailClient)->first();
        $dateNow = Carbon::now();
        $dateFinale = $reduction->dateFinReduction;
        $dateFinale = Carbon::parse($dateFinale);
        $timeLeft = $dateFinale->diffInSeconds($dateNow);
        $dateFinaleStr = $dateFinale->format("d/M/Y");
        $points = $reduction->pointsReduction;

        if($dateNow > $dateFinale) {
            return view('profiles.myClientProfile')->with(['dateFinaleSet' => False, 'client' => $client, 'points' => $points, 'id' => $id, 'completedOrders' => $history, 'processingOrders' => $processingOrders, 'nbCompare' => $nbCompare]);
        }

        return view('profiles.myClientProfile')->with(['dateFinaleSet' => True, 'start'=>$dateNow, 'time'=>$timeLeft, 'client' => $client, 'points' => $points, 'id' => $id, 'completedOrders' => $history, 'processingOrders' => $processingOrders, 'nbCompare' => $nbCompare]);

    }

    public function showSeller()
    {
        $sellerMail = Vendeur::getSellerMail();
        $seller = Vendeur::sellerWithThisMail($sellerMail);
        $adminConnected = Admin::isConnected();
        $favoriteShop = Vendeur::getMyFavoriteShop();

        return view('profiles.mySellerProfile')->with(['seller' => $seller , 'adminConnected' => $adminConnected , 'favoriteShop' => $favoriteShop ]);
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
        $reviews = Panier::getReviewsOfThisMailClient($client->mailClient);
        return view('myPurchases', ['id' => $id, 'reviews' =>  $reviews ,'commandes' => $commandes, 'client' => $client,'nbCompare' => $nbCompare]);
    }
    public function selectForm(Request $request)
    {
        // view myPurchases

        if ($request->has('rate')) {
            Avis::validateReview();
            Avis::createOrUpdateClientReviewOnThisProduct();
            flash("Avis envoyé !")->success();
            return back();
        }

        // view myClientProfile

        elseif ($request->has('editClient')){
            Client::validateUpdate();
            Client::updateClient();
            flash('modification prise en compte')->success();
            return back();
        }

        // view mySellerProfile
        elseif ($request->has('editSeller')) {
            Vendeur::validateUpdate();
            Vendeur::updateSeller();
            flash('modification prise en compte')->success();
            return back();
        }
    }

    public function idVendeur($id){
        $seller = Vendeur::sellerWithThisId($id);
        $shops = Appartenir::shopsOfThisSeller($seller->mailVendeur);
        return view('profiles.sellerProfile', ['seller' => $seller, 'shops' => $shops]);
    }

}
