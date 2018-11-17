<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appartenir extends Model
{

    protected $fillable = ['numSiretCommerce','mailVendeur'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='appartenir';




}
