<?php

namespace App\Http\Controllers;

use App\Client;

use App\Vendeur;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        //return view('clientProfile');
        //var_dump(Auth::guard('client')->check());
        //var_dump(auth('seller')->check());
        return view('myClientProfile');
        // var_dump(\Auth::check());

        //return auth('client')->user();


        /*if (auth('client')->check()){
            return 'client';
            //return view('myClientProfile');
        }
        if(auth('seller')){
            return view('mySellerProfile');
        }
        else{
            return redirect('/login')->withInput()->withErrors([
                "mailSeller" => "veuilez vous connecter",
            ]);
        }
        */
    }


    public function idClient($id){
        $client = Client::where('idClient',$id)->firstOrFail();
        return view('profiles.clientProfile', ['client' => $client]);
    }

    public function idVendeur($id){
        $seller = Vendeur::where('idVendeur',$id)->firstOrFail();
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $seller->mailVendeur)->get();
        return view('profiles.sellerProfile', ['seller' => $seller, 'shops' => $shops]);
    }
}
