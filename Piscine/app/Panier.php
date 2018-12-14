<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{

    protected $fillable = ['numPanier','datePanier','prixPanier','prixReduitPanier','qtePointsAcquis','mailClient'];
    protected $nullable = ['datePanier'];
    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='numPanier';
    protected $keyType = 'string';


    public static function firstOrNewPanier($mailClient){
        return self::firstOrNew(['mailClient' => $mailClient , 'datePanier' => null]);
    }

    public static function addPriceToThisShoppingCart($panier,$productPrice,$quantity){
        if(is_null($panier->prixPanier)){
            $panier->prixPanier = $productPrice*$quantity;
        }else{
            $panier->prixPanier += $productPrice*$quantity;
        }
        $panier->save();
    }

    public static function getPurchaseOfThisMailClient($mail){
        return self::where('mailClient',$mail)->whereNotNull('paniers.datePanier')
            ->join('commandes', 'paniers.numPanier','=','commandes.numPanier')
            ->join('detenir','detenir.numCommande','=','commandes.numCommande')
            ->join('produits','produits.numProduit', '=','detenir.numProduit')
            ->get();
    }
}
