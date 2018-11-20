<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{

    protected $fillable = ['numPanier','datePanier','prixPanier','prixReduitPanier','qtePointsAcquis','mailClient'];
    protected $nullable = ['datePanier'];
    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='numPanier';


}
