<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Coupon;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Client;
use App\Reduction;
use App\TypeProduit;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ShoppingCartController extends Controller
{

    public function show($id)
    {
        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $client = Client::getClientWithId($id);
        $products = Panier::getPanierClient($client->mailClient);
        if($products->isEmpty()){
            return view('myShoppingCart')->with(['id' => $id, 'nbCompare' => $nbCompare]);
        }

        $sum = Panier::where('mailClient',$client->mailClient)
            ->where('datePanier',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * detenir.qteCommande) as total'))->first();

        $total = $sum->total;

        return view('myShoppingCart')->with(['products' => $products,'total' => $total ,'id' => $id,'nbCompare' => $nbCompare]);
    }
    public function selectForm(Request $request)
    {
        // view sellerShops
        //return $request;
        //  return $request;

                // view confirmShoppingCart
                if ($request->has('deliverAll')){
                    return $this->buyAndDeliverAll(request('shoppingCartNumber'),request('total'));
                }
                elseif($request->has('noDelivery')){
                    return $this->buyAndDeliverNone(request('shoppingCartNumber'),request('total'));
                }
                elseif($request->has('selectedDelivery')){
                    return $this->buyWithSelectedDelivery(request('shoppingCartNumber'),request('total'),request('subTotal'),request('productToDeliver'));
                }
                elseif ($request->has('deliveryMax')) {
                  return $this->buyWithSelectedDelivery(request('shoppingCartNumber'),request('total'),request('subTotal'),request('productDeliverable'));
                }


        elseif ($request->has('update')) {
            return $this->updateQuantity(request('orderNumber'),request('productNumber'),request('quantity'),request('price'),request('shoppingCartNumber'));
        }
        elseif ($request->has('delete')) {
            return $this->deleteQuantity(request('orderNumber'),request('productNumber'),request('shoppingCartNumber'));
        }
        elseif ($request->has('buy')) {
            return redirect(url()->current().'/confirmation');
        }



        elseif ($request->has('finalPaid')) {

            $date = Date::now()->format('Y-m-d H:i:s');
            $shoppingCartNumber = request('shoppingCartNumber');
            Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['datePanier' => $date]);
            Commande::where('commandes.numPanier',$shoppingCartNumber)->update(['dateCommande'=> $date ,'etatCommande' => "traitement", 'paiementEnLigne' => 0]);

            // Actualiser le numero des points de reduction
            $client = Client::getClientWithId(request('id'));
            $reduction = Reduction::where('mailClient', $client->mailClient)->first();
            $newPoints = $reduction->pointsReduction + intval(request('points'));
            $dateFinale = Carbon::now();
            $dateFinale = $dateFinale->addDays(14)->format('Y-m-d h:i:s');
            Reduction::where('numReduction', $reduction->numReduction)->update(['pointsReduction' => $newPoints , 'dateFinReduction'=>$dateFinale]);
            flash("Félicitations, votre commande a été prise en compte.")->success();
            return redirect('/client/profil');
          }

        elseif ($request->has('points')){
          if(request('pointsReduction')){
            return $this->applyPoints(request('pointsReduction'), request('total'),request('appliedCoupon'));
          }
        }

        elseif ($request->has('code')){
          if(request('codeCoupon')){
            return $this->applyCoupon(request('codeCoupon'), request('productNumber'), request('quantity'),
                request('subTotal'), request('total'),request('appliedPoints')
                );
              }
        }

    }

    public function showConfirmation($id)
    {
        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $client = Client::getClientWithId($id);
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
            return view('confirmShoppingCart')->with(['id' => $id, 'deliverablesProducts' => $deliverablesProducts, 'undeliverablesProducts' => $undeliverablesProducts,'total' => $total,'nbCompare' => $nbCompare, 'appliedCoupon'=>False, 'appliedPoints'=>False]);
        }
        // case  2 all deliverables : [tout se faire livrer] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        elseif (!($deliverablesProducts->isEmpty()) and $undeliverablesProducts->isEmpty()) {
            return view('confirmShoppingCart')->with(['id' => $id, 'productCase2' => $deliverablesProducts, 'total' => $total,'nbCompare' => $nbCompare, 'appliedCoupon'=>False, 'appliedPoints'=>False]);

        }
        // case 3 all undeliverables : [tout récupérer chez les vendeurs]
        elseif ($deliverablesProducts->isEmpty() and !($undeliverablesProducts->isEmpty())){
            return view('confirmShoppingCart')->with(['id' => $id, 'productCase3' => $undeliverablesProducts,'total' => $total,'nbCompare' => $nbCompare, 'appliedCoupon'=>False, 'appliedPoints'=>False]);
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
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $products = Panier::getPanierClient($client->mailClient);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $numPanier = Panier::getShoppingCartNumber();

        $points = 0;
        foreach ($products as $product) {
            $points+=Panier::calculPoints($product->livrer, $product->prixProduit, $product->qteCommande);
        }

        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->leftjoin('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->leftjoin('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            ->where('numProduit','!=',null)
            ->get();
        foreach ($commandes as $commande){
            $this->substractStocks($commande->numProduit,$commande->qteCommande);
            Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 1]);
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['qtePointsAcquis' => number_format($total*0.15,1)]);

        return view('myReceipt')->with(['products' => $products,'total' => $total, 'points' => $points ,'id' => $id, 'nbCompare' => $nbCompare, 'numPanier' => $numPanier]);

    }

    public function buyAndDeliverAll($shoppingCartNumber,$total)
    {
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $products = Panier::getPanierClient($client->mailClient);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $numPanier = Panier::getShoppingCartNumber();

        $points = 0;
        foreach ($products as $product) {
            $points+=Panier::calculPoints($product->livrer, $product->prixProduit, $product->qteCommande);
        }

        $commandes = Panier::where('paniers.numPanier',$shoppingCartNumber)
            ->leftjoin('commandes','commandes.numPanier' , '=' , 'paniers.numPanier')
            ->leftjoin('detenir','detenir.numCommande' , '=' , 'commandes.numCommande')
            ->where('numProduit','!=',null)
            ->get();

        foreach ($commandes as $commande){
            $this->substractStocks($commande->numProduit,$commande->qteCommande);
            Detenir::where('numCommande',$commande->numCommande)->where('numProduit',$commande->numProduit)->update(['livrer' => 0]);
        }
        Panier::where('paniers.numPanier',$shoppingCartNumber)->update(['qtePointsAcquis' => number_format($total*0.10,1)]);
        return view('myReceipt')->with(['products' => $products,'total' => $total, 'points' => $points ,'id' => $id, 'nbCompare' => $nbCompare, 'numPanier' => $numPanier]);

    }

    public function buyWithSelectedDelivery($shoppingCartNumber,$total,$arrayOfSubtotals,$arrayOfProductsToDeliver)
    {
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $products = Panier::getPanierClient($client->mailClient);
        $nbCompare = Client::calculNumberOfProductToCompare();
        $numPanier = Panier::getShoppingCartNumber();

        $points = 0;
        foreach ($products as $product) {
            $points+=Panier::calculPoints($product->livrer, $product->prixProduit, $product->qteCommande);
        }

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
        return view('myReceipt')->with(['products' => $products,'total' => $total, 'points' => $points ,'id' => $id, 'nbCompare' => $nbCompare, 'numPanier' => $numPanier]);

    }

    /*
     * @param : take the product's number and a quantity to subtract it from the stock
     * @no return
     */
    public function substractStocks($productNumber,$quantity){
        Produit::where('numProduit',$productNumber)->decrement('qteStockDispoProduit', $quantity );
        Produit::where('numProduit',$productNumber)->decrement('qteStockProduit', $quantity );
    }

    public function applyCoupon($codeCoupon, $productNumber, $quantity, $subTotal, $total, $appliedPoints){

        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $client = Client::getClientWithId($id);
        $noCoup = Coupon::countCouponsWithCode($codeCoupon);
        if ($noCoup < 1) {
            return back()->withErrors([
                'codeCoupon' => 'Ce coupon n\'existe pas',
            ]);
        }
        $coupon = Coupon::couponWithCode($codeCoupon);
        $nbp = count($productNumber);

        for ($i = 0; $i <= $nbp - 1; $i++) {
            $numProduit = $productNumber[$i];
            $sommeInitiale = $subTotal[$i];

            if($coupon->numProduit){
                if($coupon->numProduit == $numProduit) {
                    if($coupon->valeur){
//                        return back()->with(['total' => $coupon->valeur * $quantity[$i]]);
//                        return $coupon->valeur * $quantity[$i];
                        $total = $total - $coupon->valeur * $quantity[$i];
                        break;
                    }
                    elseif($coupon->valeurPourcentage){
//                        return $coupon->valeurPourcentage;
                        $total = $total - ($coupon->valeurPourcentage/100) * $sommeInitiale;
                        break;
                    }
                }
            }
            elseif ($coupon->nomTypeProduit){
                if($coupon->nomTypeProduit == Produit::productWithId($numProduit)->nomTypeProduit){
                    if($coupon->valeur){
                        $total = $total - $coupon->valeur * $quantity[$i];
                        break;
                    }
                    elseif($coupon->valeurPourcentage){
                        $total = $total - ($coupon->valeurPourcentage/100) * $sommeInitiale;
                        break;
                    }
                }
            }
        }
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


        // case 1 : [se faire livrer le maximum] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        if (($deliverablesProducts) and ($undeliverablesProducts)) {
            return view('confirmShoppingCart')->with([
                'id' => $id, 'deliverablesProducts' => $deliverablesProducts,
                'undeliverablesProducts' => $undeliverablesProducts,'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedPoints' => $appliedPoints,
                'appliedCoupon' => True]);
        }
        // case  2 all deliverables : [tout se faire livrer] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        elseif (($deliverablesProducts) and !$undeliverablesProducts) {
            return view('confirmShoppingCart')->with([
                'id' => $id, 'productCase2' => $deliverablesProducts,
                'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedPoints' => $appliedPoints,
                'appliedCoupon' => True]);

        }
        // case 3 all undeliverables : [tout récupérer chez les vendeurs]
        elseif (!$deliverablesProducts and ($undeliverablesProducts)){
            return view('confirmShoppingCart')->with([
                'id' => $id,
                'productCase3' => $undeliverablesProducts,
                'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedPoints' => $appliedPoints,
                'appliedCoupon' => True]);
        }
        else{
            return "Error unknown case";
        }
    }

    public function applyPoints($pointsReduction, $total, $appliedCoupon){

        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $client = Client::getClientWithId($id);
        $reduction = Reduction::where('mailClient', $client->mailClient)->first();

        if ($pointsReduction > $reduction->pointsReduction) {
            return back()->withErrors([
                'points' => 'Vous n\'avez pas autant de points de reduction!',
            ]);
        }

        $total = $total - $pointsReduction * 0.5; // ici, coefficient de transformation du bd

        // actualiser le points dans le bd

        $newPoints = $reduction->pointsReduction - $pointsReduction;
        $dateFinale = Carbon::now();
        $dateFinale = $dateFinale->addDays(14)->format('Y-m-d h:i:s');
        Reduction::where('numReduction', $reduction->numReduction)->update(['pointsReduction' => $newPoints , 'dateFinReduction'=>$dateFinale]);

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


        // case 1 : [se faire livrer le maximum] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        if (($deliverablesProducts) and ($undeliverablesProducts)) {
            return view('confirmShoppingCart')->with([
                'id' => $id, 'deliverablesProducts' => $deliverablesProducts,
                'undeliverablesProducts' => $undeliverablesProducts,'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedCoupon' => $appliedCoupon,
                'appliedPoints' => True]);
        }
        // case  2 all deliverables : [tout se faire livrer] or [tout récupérer chez les vendeurs] or [se faire livrer les produits selectionnés]
        elseif (($deliverablesProducts) and !$undeliverablesProducts) {
            return view('confirmShoppingCart')->with([
                'id' => $id, 'productCase2' => $deliverablesProducts,
                'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedCoupon' => $appliedCoupon,
                'appliedPoints' => True]);

        }
        // case 3 all undeliverables : [tout récupérer chez les vendeurs]
        elseif (!$deliverablesProducts and ($undeliverablesProducts)){
            return view('confirmShoppingCart')->with([
                'id' => $id,
                'productCase3' => $undeliverablesProducts,
                'total' => $total,
                'nbCompare' => $nbCompare,
                'appliedCoupon' => $appliedCoupon,
                'appliedPoints' => True]);
        }
        else{
            return "Error unknown case";
        }
    }


}
