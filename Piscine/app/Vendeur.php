<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
  public $timestamps = false;
  protected $fillable = ['mailVendeur','nomVendeur','prenomVendeur','telVendeur',
                         'mdpVendeur'];



    public function commerces()
    {
        return $this->belongsToMany(Commerce::class);
    }
}


