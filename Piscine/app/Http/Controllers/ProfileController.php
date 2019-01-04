<?php

namespace App\Http\Controllers;

use App\Appartenir;
use App\Avis;
use App\Client;

use App\Panier;
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
        return view('profiles.myClientProfile')->with(['client'=>$client, 'points'=> $points, 'id' => $id]);
    }


    public function idClient($id){
        $client = Client::getClientWithId($id);
        return view('profiles.clientProfile', ['client' => $client]);
    }

    public function purchaseClient($id)
    {
        $client = Client::getClientWithId($id);
        $commandes = Panier::getPurchaseOfThisMailClient($client->mailClient);
        return view('myPurchases', ['commandes' => $commandes, 'client' => $client]);
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
