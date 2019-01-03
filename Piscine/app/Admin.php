<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = ['mailAdmin','mdpAdmin'];
    protected $hidden = ['mdpAdmin'];

    public $timestamps = false;
    protected $primaryKey ="mailAdmin";
    protected $keyType ="string";


    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpAdmin;
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

    public static function validateMail(){
        return $count = Vendeur::where('mailVendeur',request('mailSeller'))->count();
    }
    public static function updateSellerFollowed(){
        self::where('mailAdmin', Auth::guard('admin')->user()->mailAdmin)
            ->update(['mailVendeur'=> request('mailSeller')
            ]);
    }

}


