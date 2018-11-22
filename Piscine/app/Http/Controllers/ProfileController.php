<?php

namespace App\Http\Controllers;

use App\Avis;
use App\Client;

use App\Panier;
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
        //return view('profiles.clientProfile');
        //var_dump(Auth::guard('client')->check());
        //var_dump(auth('seller')->check());
        return view('profiles.myClientProfile');
        // var_dump(\Auth::check());

        //return auth('client')->user();


        /*if (auth('client')->check()){
            return 'client';
            //return view('profiles.myClientProfile');
        }
        if(auth('seller')){
            return view('profiles.mySellerProfile');
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

    public function purchaseClient($id){
        $client = Client::where('idClient',$id)->firstOrFail();

        $commandes = Panier::where('mailClient',$client->mailClient)->whereNotNull('paniers.datePanier')
            ->join('commandes', 'paniers.numPanier','=','commandes.numPanier')
            ->join('detenir','detenir.numCommande','=','commandes.numCommande')
            ->join('produits','produits.numProduit', '=','detenir.numProduit')
            ->get();

        return view('myPurchases', ['commandes' => $commandes, 'client' => $client]);
    }
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('rate')) {
            return $this->rating(request('mailClient'),request('productNumber'),request('mark'),request('comment'));
        }
    }

    public function rating($mailClient,$productNumber,$mark,$comment){
        request()->validate([
            'mailClient' => ['required','email'],
            'productNumber' => ['required','int'],
            'mark' => ['required','min:0','max:10'],
            'comment' => ['required']
         ]);

         $avis = Avis::firstOrNew(['mailClient' => $mailClient , 'numProduit' => $productNumber]);
         $avis->noteAvis = $mark;
         $avis->commentaireAvis = $comment;
         $avis->dateAvis = Date::now()->format('Y-m-d H:i:s');
         $avis->save();
         return back();
    }

    public function idVendeur($id){
        $seller = Vendeur::where('idVendeur',$id)->firstOrFail();
        $shops = DB::table('appartenir')->join('commerces', 'appartenir.numSiretCommerce', '=', 'commerces.numSiretCommerce')->where('mailVendeur', $seller->mailVendeur)->get();
        return view('profiles.sellerProfile', ['seller' => $seller, 'shops' => $shops]);
    }
}
