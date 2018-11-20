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
                         'adresseClient','codePostalClient','villeClient','idClient'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='mailClient';
    protected $keyType ='varchar';
    protected $table ='clients';
    public $incrementing = false;

    /**
     * Get the password for the seller.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdpClient;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->mailClient;
    }


    public function getMailClient(){
        return "r@g.com";
    }

    public function getIdClient(){
        return "2";
    }

}
