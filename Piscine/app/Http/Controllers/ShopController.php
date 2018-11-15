<?php

namespace App\Http\Controllers;

use App\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function show()
    {
        $mailSeller = 'vendeur@gmail.com'; // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $mailSeller)->get();

        return view('sellerShops', ['shops' => $shops, 'mailSeller' => $mailSeller]);
    }

    public function selectForm(Request $request)
    {
        if($request->has('visit')) {
            $numShop = request('visit');
            $shopName = request('shopName');
            $sellers =  DB::table('appartenir')->join('vendeurs','appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce',$numShop)->get(['vendeurs.mailVendeur','vendeurs.nomVendeur']);
            return view('myShop', ['sellers' => $sellers, 'numShop'=> $numShop, 'shopName' => $shopName]);
        }

        elseif ($request->has('quit')){
            $numShop = request('quit');
            $mailSeller = request('mailSeller');
        }

        elseif ($request->has('join')){
                                                // todo :  vérifier que le nom et le code sont vrais
            return request('nameShop');
        }

    }

    public function numSiret($numSiretCommerce)
    {
        $shopName = Commerce::where('numSiretCommerce',$numSiretCommerce)->firstOrFail();
        $sellers =  DB::table('appartenir')->join('vendeurs','appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')->where('numSiretCommerce',$numSiretCommerce)->get(['vendeurs.mailVendeur','vendeurs.nomVendeur']);

        return view('myShop',['sellers' => $sellers, 'numShop'=> $numSiretCommerce, 'shopName' => $shopName]);
    }
}
