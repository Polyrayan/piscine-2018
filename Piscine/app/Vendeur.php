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

    protected $fillable = ['mailVendeur','nomVendeur','prenomVendeur','telVendeur', 'mdpVendeur','idVendeur','commerceFavori'];
    protected $hidden = ['mdpVendeur'];

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

    /**
     * on overwrite la fonction car on ne se sert pas des remember token
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
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

    public static function validateUpdate()
    {
        request()->validate([
            'name' => ['bail', 'required', 'string'],
            'firstName' => ['bail', 'required', 'string'],
            'phone' => ['bail', 'required', 'numeric'],
        ]);
    }

    public static function updateSeller()
    {
        self::where('mailVendeur', request('mail'))
            ->update(['nomVendeur' => request('name'),
                'prenomVendeur' => request('firstName'),
                'telVendeur' => request('phone'),
            ]);
    }

    public static function findSellerMail($mail){
        return self::where('mailVendeur',$mail)->count();
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

    public static function getIdSeller(){
        if(Auth::guard('seller')->check()) {
            return Auth::guard('seller')->user()->idVendeur;
        }
        if(Auth::guard('admin')->check()){
            $seller = self::where('mailVendeur',Auth::guard('admin')->user()->mailVendeur)->first();
            return $seller->idVendeur;
        }
    }

    public static function getMyFavoriteShop(){
        if(Auth::guard('seller')->check()) {
            return Auth::guard('seller')->user()->commerceFavori;
        }
        if(Auth::guard('admin')->check()){
            $seller = self::where('mailVendeur',Auth::guard('admin')->user()->mailVendeur)->first();
            return $seller->commerceFavori;
        }
    }

    public static function updateMyFavoriteShop(){

        if(Auth::guard('seller')->check()) {
            self::where('mailVendeur',Auth::guard('seller')->user()->mailVendeur)->update(['commerceFavori' => request('siretNumber')]);
        }
        if(Auth::guard('admin')->check()){
            self::where('mailVendeur',Auth::guard('admin')->user()->mailVendeur)->update(['commerceFavori' =>request('siretNumber')]);
        }
    }

        public static function isConnected(){
        if(Auth::guard('seller')->check()){
            return true;
        }
        else{
            return false;
        }
    }

}


