<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function show()
    {
        $mailClient = 'a@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle

        $products = DB::table('produits')->get();

        return view('welcome', ['products' => $products, 'mailClient' => $mailClient]);
    }
}
