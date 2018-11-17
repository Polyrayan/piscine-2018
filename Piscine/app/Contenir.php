<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenir extends Model
{

    protected $fillable = ['numreservation','numProduit','qteReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='contenir';

}
