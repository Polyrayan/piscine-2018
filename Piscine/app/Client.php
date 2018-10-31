<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  public $timestamps = false;
  protected $fillable = ['mailClient','nomClient','prenomClient','telClient',
                         'mdpClient','sexeClient','dateNaissanceClient',
                         'adresseClient','codePostalClient','villeClient'];


}
