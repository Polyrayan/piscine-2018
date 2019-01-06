<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    protected $fillable = ['numSiretCommerce','nomCommerce','libelleCommerce','adresseCommerce',
                            'villeCommerce','codePostalCommerce','telCommerce',
                            'codeReduction','codeRecrutementVendeur','regionCommerce'];
    public $timestamps = false;
    protected $primaryKey ='numSiretCommerce';
    protected $keyType = 'string';


    public function vendeurs()
    {
        return $this->belongsToMany(Vendeur::class);
    }


    public static function validateFormShop(){
        request()->validate([
            'numSiret' => ['bail','required','min:14','max:14'],
            'recruitmentCode' => ['bail','required','min:6'],
            'name' => ['bail','required','string'],
            'description' => ['bail','required','string'],
            'phone' => ['bail','required','numeric'],
            'address' => ['bail','required','string'],
            'city' => ['bail','required','string'],
            'zipCode' => ['bail','required','numeric'],
            //
            //
            // todo : add the cssfile here and create a function to create products in this file
            //
        ]);
    }
    public static function createShop(){
        return self::create([
            'numSiretCommerce' => request('numSiret'),
            'nomCommerce' => (request('name')),
            'libelleCommerce' => request('description'),
            'adresseCommerce' => request('address'),
            'villeCommerce' => request('city'),
            'telCommerce' => request('phone'),
            'codePostaCommercel' => request('zipCode'),
            'codeRecrutement' => request('recruitmentCode'),
        ]);
    }

    public static function shopWithSiret($siret){
        return self::where('numSiretCommerce', $siret)->firstOrFail();
    }

    public static function nameOfThisShop($siret){
        $shop =  self::where('numSiretCommerce', $siret)->firstOrFail();
        return $shop->nomCommerce;
    }

    public static function matchSiretAndCode($siret,$code){
        self::where('numSiretCommerce',$siret)->where('codeRecrutement',$code)->first();
    }

    public static function getShopAddress($siret){
        $shop = self::where('numSiretCommerce',$siret)->firstOrFail();
        return "$shop->adresseCommerce , $shop->villeCommerce ";
    }

    public static function getCity($siret){
        $shop = self::where('numSiretCommerce',$siret)->firstOrFail();
        return $shop->villeCommerce;
    }
}