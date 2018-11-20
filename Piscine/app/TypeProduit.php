<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    protected $fillable = ['numTypeProduit','nomTypeProduit','couleur','taille','marque','tempsReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='typeProduits';
}
