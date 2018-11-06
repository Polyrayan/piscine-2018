<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as BasicAuthenticatable;

class Client extends Model implements Authenticatable
{

    use BasicAuthenticatable; // use 6 functions in this namespace


    protected $fillable = ['mailClient','nomClient','prenomClient','telClient',
                         'mdpClient','sexeClient','dateNaissanceClient',
                         'adresseClient','codePostalClient','villeClient'];

    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpClient;
    }

}
