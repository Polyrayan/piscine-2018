<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model
{
    protected $fillable = ['codeCoupon','numSiretCommerce','nomTypeProduit','numProduit',
        'valeur','valeurPourcentage','dateLimite',
        'description',
        'quantiteMax'];
    public $timestamps = false;
    protected $primaryKey ='codeCoupon';
    protected $keyType = 'string';
    /*
    public static function validateFormCoupon(){
        request()->validate([
            'codeCoupon' => ['bail','required','min:10','max:10'],
            'numSiretCommerce' => ['bail','min:14','max:14'],
            'nomTypeProduit' => ['bail','string'],
            'numProduit' => ['bail','string'],
            'description' => ['bail'],
            'valeur' => ['bail','numeric'],
            'valeurPourcentage' => ['bail','numeric'],
            'dateLimite' => ['bail'],
            'quantiteMax' => ['bail','numeric']
            //
            //
            // todo : add the cssfile here and create a function to create products in this file
            //
        ]);
    }
    */
    public static function createCoupon(){
        return self::create([
            'codeCoupon' => request('codeCoupon'),
            'numSiretCommerce' => (request('numSiretCommerce')),
            'nomTypeProduit' => request('nomTypeProduit'),
            'numProduit' => request('numProduit'),
            'valeur' => request('valeur'),
            'valeurPourcentage' => request('valeurPourcentage'),
            'dateLimite' => request('dateLimite'),
            'description' => request('description'),
            'quantiteMax' => request('quantiteMax'),
        ]);
    }
    public static function couponWithCode($code){
        return self::where('codeCoupon', $code)->firstOrFail();
    }

    public static function countCouponsWithCode($code){
        return self::where('codeCoupon', $code)->count();
    }
}