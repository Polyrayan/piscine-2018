<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commerce;
use App\Produit;
use App\TypeProduit;
use Illuminate\Http\Request;

class ShopSalesController extends Controller
{
    /*
     * @param : numSiret
     * @return : view to show all orders in progress and all completed orders
     */
    public function mySales($numSiretCommerce)
    {
        // todo : middleware pour vérifier que le vendeur est connecté et appartient aux vendeurs
        $shop = Commerce::where('numSiretCommerce', $numSiretCommerce)->firstOrFail();

        $ordersToTreat = Commande::where('commandes.numSiretCommerce',$numSiretCommerce)
            ->where('etatCommande','traitement')
            ->orderBy('dateCommande','asc')
            ->get();

        $ordersToDeliver = Commande::where('commandes.numSiretCommerce',$numSiretCommerce)
            ->where('etatCommande','traitement')
            ->leftjoin('detenir','commandes.numCommande','=','detenir.numCommande')
            ->where('detenir.livrer',0)
            ->leftjoin('produits','produits.numProduit','=','detenir.numProduit')
            ->get();

        $onSiteOrders = Commande::where('commandes.numSiretCommerce',$numSiretCommerce)
            ->where('etatCommande','traitement')
            ->join('detenir','commandes.numCommande','=','detenir.numCommande')
            ->where('detenir.livrer',1)
            ->leftjoin('produits','produits.numProduit','=','detenir.numProduit')
            ->get();

        $completedOrders = Commande::where('etatCommande',"terminee")
            ->where('numSiretCommerce',$numSiretCommerce)
            ->orderBy('dateCommande','desc')
            ->get();

        return view('shopSales', [ 'numShop' => $numSiretCommerce, 'shop' => $shop , 'ordersToDeliver' => $ordersToDeliver , 'onSiteOrders' => $onSiteOrders , 'completedOrders' => $completedOrders , 'ordersToTreat'=> $ordersToTreat]);
    }

    public function selectForm(Request $request)
    {
        if ($request->has('finish')) {
            return $this->updateOrderToFinish(request('orderNumber'));
        }
    }

    public function updateOrderToFinish($orderNumber){
        Commande::where('numCommande',$orderNumber)->update(['etatCommande' => 'terminee']);
        return back();
    }

}