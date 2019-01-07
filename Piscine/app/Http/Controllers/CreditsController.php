<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Client;
use App\Vendeur;

class CreditsController extends Controller
{

    public function show() {
        $clientConnected = Client::isConnected();
        $sellerConnected = Vendeur::isConnected();

        if($clientConnected) {
            $user = $clientConnected;
            $id = Client::getIdClient();
            $nbCompare = Client::calculNumberOfProductToCompare();
            return view('credits')->with(['id' => $id, 'nbCompare' => $nbCompare, 'user' => 'Client']);
        } else if ($sellerConnected) {
            $user = $sellerConnected;
            $adminConnected = Admin::isConnected();
            $favoriteShop = Vendeur::getMyFavoriteShop();
            return view('credits')->with(['seller' => $seller , 'adminConnected' => $adminConnected , 'favoriteShop' => $favoriteShop, 'user' => 'Seller' ]);
        } else {
            return view('credits');
        }
    }
}