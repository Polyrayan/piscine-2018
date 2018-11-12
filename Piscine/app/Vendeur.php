<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;

class Vendeur extends Model implements Authenticatable
{

    use BasicAuthenticatable; // use 6 functions in this namespace

    protected $fillable = ['mailVendeur','nomVendeur','prenomVendeur','telVendeur',
                         'mdpVendeur'];



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
}


