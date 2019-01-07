<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    protected $fillable = ['numSiretCommerce','nomCommerce','libelleCommerce','adresseCommerce',
                            'villeCommerce','codePostalCommerce','telCommerce',
                            'codeReduction','codeRecrutement','regionCommerce', 'mailProprietaire'];
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
            'region' => ['bail','required']
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
            'regionCommerce' => request('region'),
            'mailProprietaire' => request('sellerMail')
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

    public static function validateEditCommerce(){
        request()->validate([
            'code' => ['bail','required','min:6'],
            'name' => ['bail','required','string'],
            'libelle' => ['bail','required','string'],
            'numTel' => ['bail','required','numeric'],
            'adresse' => ['bail','required','string'],
            'ville' => ['bail','required','string'],
            'codePostal' => ['bail','required','numeric'],
            'region' => ['bail','required']
        ]);
      }

    public static function editCommerce(){
        self::where('numSiretCommerce',request('siret'))
            ->update(['nomCommerce'=> request('name') ,
                'libelleCommerce'=> request('libelle'),
                'adresseCommerce' => request('adresse'),
                'villeCommerce' => request('ville'),
                'codePostalCommerce' => request('codePostal'),
                'regionCommerce' => request('region'),
                'telCommerce' => request('numTel'),
                'codeRecrutement' => request('code'),
            ]);
    }

    public static function changeProp($new){
        self::where('numSiretCommerce',request('siret'))
            ->update(['mailProprietaire'=> $new,
            ]);
    }
}
