<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Vendeur extends Authenticatable
{
    use Notifiable;

    protected $guard = 'seller';

    protected $fillable = ['mailVendeur','nomVendeur','prenomVendeur','telVendeur', 'mdpVendeur','idVendeur'];
    protected $hidden = ['mdpVendeur', 'remember_token'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ="mailVendeur";
    protected $keyType ="string";

    public function commerces()
    {
        return $this->belongsToMany(Commerce::class);
    }

    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpVendeur;
    }

    public static function validateFormSeller(){
        request()->validate([
            'mailSeller' => ['bail','required','email'],
            'passwordSeller' => ['bail','required','min:6','required_with:password_confirmationSeller','same:password_confirmationSeller'],
            'password_confirmationSeller' => ['required'],
            'nameSeller' => ['bail','required','string'],
            'firstNameSeller' => ['bail','required','string'],
            'phoneSeller' => ['bail','required','numeric'],
        ]);
    }

    public static function createSeller(){
        return self::create([
            'mailVendeur' => request('mailSeller'),
            'mdpVendeur' => bcrypt(request('passwordSeller')),
            'nomVendeur' => request('nameSeller'),
            'prenomVendeur' => request('firstNameSeller'),
            'telVendeur' => request('phoneSeller'),
        ]);
    }

    public static function sellerWithThisMail($mail){
        return self::where('mailVendeur',$mail)->firstOrFail();
    }

    public static function sellerWithThisId($id){
        return self::where('idVendeur',$id)->firstOrFail();
    }

    public static function getSellerMail(){
        if(Auth::guard('seller')->check()){
            return Auth::guard('seller')->user()->mailVendeur;
        }
        if(Auth::guard('admin')->check()){
            return Auth::guard('admin')->user()->mailVendeur;
        }
    }
}


