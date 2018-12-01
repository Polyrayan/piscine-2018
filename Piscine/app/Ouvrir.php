<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ouvrir extends Model
{

    protected $fillable = ['numOuvrir','numSiretCommerce','nomJour','debut','fin'];

    protected $table ='ouvrir';
    public $timestamps = false;
    protected $primaryKey = 'numOuvrir';

}
