<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detenir extends Model
{

    protected $fillable = ['numCommande','numProduit','qteCommande','livrer'];

    public $timestamps = false;
    public $incrementing = false;
    protected $table ='detenir';
    protected $primaryKey = 'numCommande';
    protected $keyType = 'string';


    public static function firstOrNewDetenir($commande,$numProduct){
        return self::firstOrNew(['numCommande' => $commande->numCommande, 'numProduit'=> $numProduct]);
    }

    public static function storeQuantity($detenir,$quantity){
        if(is_null($detenir->qteCommande)){
            $detenir->qteCommande = $quantity;
        }else{
            $detenir->qteCommande += $quantity;
        }
        $detenir->save();
    }
}
