<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{

    protected $fillable = ['numCommande','dateCommande','prixCommande','prixReduitCommande','numSiretCommerce','numPanier'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey ='numCommande';
}
