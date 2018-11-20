<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Detenir;
use App\Panier;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;


class ShoppingCartController extends Controller
{

    public function show($id)
    {
        $client = Client::select('mailClient')->where('idClient',$id)->firstOrFail();
        $products = Panier::where('mailClient',$client->mailClient)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->get();

        if($products->isEmpty()){
            return view('myShoppingCart');
        }

        $sum = Panier::where('mailClient',$client->mailClient)
        ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
        ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
        ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
        ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();

        $total = $sum->total;

        return view('myShoppingCart')->with(['products' => $products,'total' => $total]);
    }
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('update')) {
            return $this->updateQuantity(request('orderNumber'),request('productNumber'),request('quantity'),request('price'),request('shoppingCartNumber'));

        } elseif ($request->has('delete')) {
            return $this->deleteQuantity(request('orderNumber'),request('productNumber'),request('shoppingCartNumber'));
        }
    }

    public function updateQuantity($orderNumber,$productNumber,$newQuantity,$price,$shoppingCartNumber)
    {
        Detenir::where('numCommande' , $orderNumber)->where('numProduit' , $productNumber)->update(['qteCommande' => $newQuantity]);
        Commande::where('numCommande' , $orderNumber)->update(['prixCommande' => $newQuantity*$price]);
        $sum = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['prixPanier' => $sum->total]);
        return back();
    }

    public function deleteQuantity($orderNumber,$productNumber,$shoppingCartNumber){
        Commande::where('numCommande', $orderNumber)->delete();
        Detenir::where('numCommande' , $orderNumber)->where('numProduit' , $productNumber)->delete();
        $sum = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();
        if($sum->total == null){
            Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['prixPanier' => 0 ]);
        }else{
            Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['prixPanier' => $sum->total]);
        }
        return back();
    }
}
