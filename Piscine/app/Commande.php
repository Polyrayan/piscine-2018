<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Commande extends Model
{

    protected $fillable = ['numCommande','dateCommande','prixCommande','prixReduitCommande','numSiretCommerce','numPanier','etatCommande'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='numCommande';

    public static function OrdersToTreat(){
        return self::select(DB::raw("count(etatCommande) as nb"),'numCommande','numSiretCommerce')
            ->where('etatCommande','traitement')
            ->groupBy('numCommande')
            ->get();
    }

    public static function newCommande($panier,$numSiret){
        return self::create (['numPanier' => $panier->numPanier ,
            'numSiretCommerce' => $numSiret , 'dateCommande' => null]);
    }
    public static function firstOrNewCommande($panier,$numSiret){
        return self::firstOrNew(['numPanier' => $panier->numPanier ,
            'numSiretCommerce' => $numSiret , 'dateCommande' => null]);
    }

    public static function  addPriceToThisOrder($commande,$productPrice,$quantity){
        if(is_null($commande->prixCommande)){
            $commande->prixCommande = $productPrice*$quantity;
        }else{
            $commande->prixCommande += $productPrice*$quantity;
        }
        $commande->save();
    }
}
