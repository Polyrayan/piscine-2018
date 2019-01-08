<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Client;
use App\Vendeur;
use App\Admin;

class CreditsController extends Controller
{

    public function show() {
        $clientConnected = Client::isConnected();
        $sellerConnected = Vendeur::isConnected();

        if($clientConnected) {
            $user = "Client";
            $id = Client::getIdClient();
            $nbCompare = Client::calculNumberOfProductToCompare();
            return view('credits')->with(['id' => $id, 'nbCompare' => $nbCompare, 'user' => $user]);
        } else if ($sellerConnected) {
            $user = "Seller";
            $adminConnected = Admin::isConnected();
            $favoriteShop = Vendeur::getMyFavoriteShop();
            return view('credits')->with(['adminConnected' => $adminConnected , 'favoriteShop' => $favoriteShop, 'user' => $user ]);
        } else {
            return view('credits');
            $adminConnected = Admin::isConnected();
            $favoriteShop = Vendeur::getMyFavoriteShop();
        }
    }
}
