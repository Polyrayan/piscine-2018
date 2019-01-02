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
    protected $hidden = ['mdpAdmin', 'remember_token'];

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

    public static function validateMail(){
        return $count = Vendeur::where('mailVendeur',request('mailSeller'))->count();
    }
    public static function updateSellerFollowed(){
        self::where('mailAdmin', Auth::guard('admin')->user()->mailAdmin)
            ->update(['mailVendeur'=> request('mailSeller')
            ]);
    }

}


