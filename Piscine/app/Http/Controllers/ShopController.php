<?php

namespace App\Http\Controllers;

use App\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function show()
    {
        $mailClient = 'vendeur@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $mailClient)->get();

        return view('sellerShops',['shops' => $shops]);
    }
}
