<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Client;
use App\Reduction;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderOkController extends Controller
{

    public function showReceipt($id)
    {
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $products = Panier::getPanierClient($client->mailClient);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $numPanier = Panier::getShoppingCartNumber();

        $sum = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();

        $total = $sum->total;

        $points = 0;
        foreach ($products as $product) {
          $points+=Panier::calculPoints($product->livrer, $product->prixProduit, $product->qteCommande);
        }

        return view('myReceipt')->with(['products' => $products,'total' => $total, 'points' => $points ,'id' => $id, 'nbCompare' => $nbCompare, 'numPanier' => $numPanier]);
    }

    public function selectForm(Request $request)
    {
        if ($request->has('paid')) {
            $date = Date::now()->format('Y-m-d H:i:s');
            $shoppingCartNumber = request('shoppingCartNumber');
            Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
            Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date ,'etatCommande' => "traitement", 'paiementEnLigne' => 0]);
            $client = Client::getClientWithId(request('id'));
            $reduction = Reduction::where('mailClient', $client->mailClient)->first();
            $newPoints = $reduction->pointsReduction + intval(request('points'));
            $reduction->update('pointsReduction' , $newPoints);
            flash("Félicitations, votre commande a été prise en compte.")->success();
            return redirect('/client/profil');
        }
    }
}
