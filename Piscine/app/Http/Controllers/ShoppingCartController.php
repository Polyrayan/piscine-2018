<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Client;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ShoppingCartController extends Controller
{

    public function show($id)
    {
        $client = Client::select('mailClient')->where('idClient',$id)->firstOrFail();
        $products = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier','=',null)
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
        } elseif ($request->has('buy')) {
            return $this->buyShoppingCart(request('shoppingCartNumber'));
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

    public function buyShoppingCart($shoppingCartNumber)
    {
        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->join('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->join('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            ->join('produits','detenir.numProduit' , '=' , 'detenir.numProduit')
            ->get();
        $date = Date::now()->format('Y-m-d H:i:s');
        foreach ($commandes as $commande){
            $this->updateStocks($commande->numProduit,$commande->qteCommande);
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
        Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date]);
        return 'success';
    }

    public function updateStocks($productNumber,$quantity){
        Produit::where('numProduit',$productNumber)->decrement('qteStockDispoProduit', $quantity );
        Produit::where('numProduit',$productNumber)->decrement('qteStockProduit', $quantity );
    }
}
