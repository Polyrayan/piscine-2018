<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ouvrir extends Model
{

    protected $fillable = ['numOuvrir','numSiretCommerce','nomJour','debut','fin'];

    protected $table ='ouvrir';
    public $timestamps = false;
    protected $primaryKey = 'numOuvrir';
    protected $keyType = 'string';

    public static function schedulesOfThisShop($siret){
        return self::where('numSiretCommerce',$siret)->get();
    }
}
