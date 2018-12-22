<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    protected $fillable = ['nomTypeProduit','tempsReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='typeProduits';
    protected $primaryKey = 'numTypeProduit';
    protected $keyType = 'string';
}
