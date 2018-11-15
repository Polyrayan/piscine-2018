<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['numProduit','nomProduit','libelleProduit','qteStockProduit',
        'qteStockDispoProduit','livraisonProduit','prixProduit',
        'qte1','qte2','numSiretCommerce','numTypeProduit','numCommande', 'numReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey = 'numProduit';

}

