<?php

namespace App\Http\Controllers;

use App\Produit;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function show()
    {
        $client = new Client();
        $mailClient = $client->getMailClient(); // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $products = Produit::all();

        return view('welcome', ['products' => $products, 'mailClient' => $mailClient]);
    }
}
