<?php

namespace App;

use App\Client;
use Faker\Provider\DateTime;
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
        return self::where('paniers.mailClient',$mail)->whereNotNull('paniers.datePanier')
            ->join('commandes', 'paniers.numPanier','=','commandes.numPanier')
            ->join('detenir','detenir.numCommande','=','commandes.numCommande')
            ->join('produits','produits.numProduit', '=','detenir.numProduit')
            ->join('avis','avis.numProduit','=','produits.numProduit')
            ->whereNull('noteAvis')
            ->groupBy('produits.numGroupeVariante')
            ->get();
    }

    public static function getReviewsOfThisMailClient($mail){
        return self::where('paniers.mailClient',$mail)->whereNotNull('paniers.datePanier')
            ->join('commandes', 'paniers.numPanier','=','commandes.numPanier')
            ->join('detenir','detenir.numCommande','=','commandes.numCommande')
            ->join('produits','produits.numProduit', '=','detenir.numProduit')
            ->join('avis','avis.numProduit','=','produits.numProduit')
            ->whereNotNull('noteAvis')
            ->groupBy('produits.numGroupeVariante')
            ->get();
    }

    public static function getPanierClient($mail){
        return self::where('mailClient',$mail)
            ->where('datePanier','=',null)
            ->join('commandes', 'commandes.numPanier', '=', 'paniers.numPanier')
            ->join('detenir', 'detenir.numCommande', '=', 'commandes.numCommande')
            ->join('produits', 'detenir.numProduit', '=' , 'produits.numProduit')
            ->get();
    }

    public static function calculPoints($deliver,$price,$quantity){
        if ($deliver==1) {
          return $quantity*$price*0.15;
        }
        else {
          return $quantity*$price*0.10;
        }
    }

    public static function getShoppingCartNumber(){
      $panier = self::where('mailClient', Client::getMailClient())
      ->where('datePanier','=',null)->first();
      return $panier->numPanier;
    }

}
