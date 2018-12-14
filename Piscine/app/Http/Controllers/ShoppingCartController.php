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
            ->where('datePanier',null)
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
        }
        elseif ($request->has('delete')) {
            return $this->deleteQuantity(request('orderNumber'),request('productNumber'),request('shoppingCartNumber'));
        }
        elseif ($request->has('buy')) {
            return redirect(url()->current().'/confirmation');
        }

        // view confirmShoppingCart
        elseif ($request->has('deliverAll')){
            return $this->buyAndDeliverAll(request('shoppingCartNumber'),request('total'));
        }
        elseif($request->has('noDelivery')){
            return $this->buyAndDeliverNone(request('shoppingCartNumber'),request('total'));
        }
        elseif($request->has('selectedDelivery')){
            return $this->buyWithSelectedDelivery(request('shoppingCartNumber'),request('total'),request('subTotal'),request('productToDeliver'));
        }
        elseif ($request->has('deliveryMax')) {
            return 'todo';
        }
    }

    public function showConfirmation($id)
    {
        $client = Client::select('mailClient')->where('idClient',$id)->firstOrFail();

        $deliverablesProducts = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier','=',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->where('produits.livraisonProduit',0)
            ->get();

        $undeliverablesProducts = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier','=',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->where('produits.livraisonProduit',1)
            ->get();

        $sum = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();
        $total = $sum->total;

        // case 1 : [se faire livrer le maximum] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        if (!($deliverablesProducts->isEmpty()) and !($undeliverablesProducts->isEmpty())) {
            return view('confirmShoppingCart')->with(['deliverablesProducts' => $deliverablesProducts, 'undeliverablesProducts' => $undeliverablesProducts,'total' => $total]);
        }
        // case  2 all deliverables : [tout se faire livrer] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        elseif (!($deliverablesProducts->isEmpty()) and $undeliverablesProducts->isEmpty()) {
            return view('confirmShoppingCart')->with(['productCase2' => $deliverablesProducts, 'total' => $total]);

        }
        // case 3 all undeliverables : [tout récupérer chez les vendeurs]
        elseif ($deliverablesProducts->isEmpty() and !($undeliverablesProducts->isEmpty())){
            return view('confirmShoppingCart')->with(['productCase3' => $undeliverablesProducts,'total' => $total]);
        }
        else{
            return "Error unknown case";
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

    public function deleteQuantity($orderNumber,$productNumber,$shoppingCartNumber)
    {
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

    public function buyAndDeliverNone($shoppingCartNumber,$total)
    {
        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->leftjoin('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->leftjoin('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            //->join('produits','detenir.numProduit' , '=' , 'detenir.numProduit')
            ->get();
        $date = Date::now()->format('Y-m-d H:i:s');
        foreach ($commandes as $commande){
            $this->substractStocks($commande->numProduit,$commande->qteCommande);
            Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 1]);
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['qtePointsAcquis' => number_format($total*0.10,1)]);
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
        Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date ,'etatCommande' => "traitement"]);
        return 'success';
    }

    public function buyAndDeliverAll($shoppingCartNumber,$total)
    {
        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->leftjoin('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->leftjoin('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            //->join('produits','detenir.numProduit' , '=' , 'detenir.numProduit')
            ->get();
        $date = Date::now()->format('Y-m-d H:i:s');
        foreach ($commandes as $commande){
            $this->substractStocks($commande->numProduit,$commande->qteCommande);
            Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 0]);
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['qtePointsAcquis' => number_format($total*0.10,1)]);
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
        Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date ,'etatCommande' => "traitement"]);
        return 'success';
    }

    public function buyWithSelectedDelivery($shoppingCartNumber,$total,$arrayOfSubtotals,$arrayOfProductsToDeliver)
    {
        if (empty($arrayOfProductsToDeliver)) {
            return $this->buyAndDeliverNone($shoppingCartNumber, $total);
        }

        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->leftjoin('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->leftjoin('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            ->get();

        $date = Date::now()->format('Y-m-d H:i:s');
        $nb = 0;
        $points = 0;
        foreach ($commandes as $commande){
            if(in_array($commande->numProduit, $arrayOfProductsToDeliver)){
                Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 0]);
                $points += $arrayOfSubtotals[$nb]*0.10;
            }else{
                Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 1]);
                $points += $arrayOfSubtotals[$nb]*0.15;
            }
            $this->substractStocks($commande->numProduit,$commande->qteCommande);
            $nb++;
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['qtePointsAcquis' => number_format($points,1)]);
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
        Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date ,'etatCommande' => "traitement"]);
        return "success";
    }

    /*
     * @param : take the product's number and a quantity to subtract it from the stock
     * @no return
     */
    public function substractStocks($productNumber,$quantity){
        Produit::where('numProduit',$productNumber)->decrement('qteStockDispoProduit', $quantity );
        Produit::where('numProduit',$productNumber)->decrement('qteStockProduit', $quantity );
    }
}
