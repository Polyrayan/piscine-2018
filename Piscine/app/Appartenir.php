<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Appartenir extends Model
{

    protected $fillable = ['numSiretCommerce','mailVendeur'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='appartenir';
    protected $primaryKey ='numSiretCommerce';
    protected $keyType = 'string';

    public static function validateFormAppartenir(){
        request()->validate([
            'numSiret' => ['bail','required','min:14','max:14'],
            'joinCode' => ['bail','required','min:6'],
        ]);
    }

    public static function validateAppartenir(){
        request()->validate([
            'email' => ['bail','required'],
        ]);
    }

    public static function createAppartenir($siret,$mail){
        return self::create([
            'numSiretCommerce' => $siret,
            'mailVendeur' => $mail
        ]);
    }
    public static function deleteAppartenir($siret,$mail){
        $sup = self::select('mailVendeur','numSiretCommerce')
                      ->where('numSiretCommerce', $siret)
                      ->where('mailVendeur' , $mail)
                      ->firstOrFail();
        $sup->delete();
    }

    public static function sellerAppartient($mail,$numSiret){
      $count = self::where('mailVendeur', $mail)->where('numSiretCommerce',$numSiret)->count();
      if($count >0){
        return true;
      }
      else{
        return false;
      }
    }

    public static function shopsOfThisSeller($mailSeller){
        return self::select('appartenir.numSiretCommerce','commerces.nomCommerce' , 'appartenir.mailVendeur' , 'commerces.mailProprietaire' ,DB::raw(" count(etatCommande) as count"))
            ->where('mailVendeur', $mailSeller)
            ->leftjoin('commerces', 'commerces.numSiretCommerce', '=', 'appartenir.numSiretCommerce')
            ->leftjoin('commandes','commandes.numSiretCommerce','=','commerces.numSiretCommerce')
            ->groupBy('commerces.nomCommerce')
            ->get();
    }

    public static function sellersOfThisShop($siret){
        return self::join('vendeurs', 'appartenir.mailVendeur', '=', 'vendeurs.mailVendeur')
            ->where('numSiretCommerce', $siret)
            ->get();
    }

}
