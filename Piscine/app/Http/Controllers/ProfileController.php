<?php

namespace App\Http\Controllers;

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
        //return view('profiles.clientProfile');
        //var_dump(Auth::guard('client')->check());
        //var_dump(auth('seller')->check());
        $Client = new Client();
        $mail = $Client->getMailClient();
        $client = Client::where('mailClient',$mail)->firstOrFail();
        $points = $this->getReductionPoints($mail);
        return view('profiles.myClientProfile')->with(['client'=>$client, 'points'=> $points]);
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

        // view myClientProfile

        elseif ($request->has('editClient')){

            return $this->updateClient(request('mail'),request('name'),request('firstName'),request('phone'),request('address'),request('city'),request('zipCode'));
        }
    }

    public function updateClient($mail,$name,$firstName,$phone,$address,$city,$zipCode){
        request()->validate([
            'name' => ['bail','required','string'],
            'firstName' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'zipCode' => ['bail','required','numeric'],
        ]);

        Client::where('mailClient',$mail)->update(['nomClient'=> $name , 'prenomClient'=> $firstName, 'telClient' => $phone,
                                                    'adresseClient' => $address ,'villeClient' => $city,'codePostalClient' => $zipCode]);
        return back();
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

    public function getReductionPoints($mail){

        $paniers = Panier::where('mailClient',$mail)->get();
        $nb = 0;
        foreach ($paniers as $panier){
            $date = new Date($panier->datePanier);
            $reduction = new Reduction();
            if (Date::now() <= $reduction->calculateDateToDestroyReductionPoints($date)) {
                $nb += $panier->qtePointsAcquis;
            }
        }
        return $nb;
    }
}
