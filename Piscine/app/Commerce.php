<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    public $timestamps = false;
    protected $fillable = ['numSiretCommerce','nomCommerce','libelleCommerce','adresseCommerce',
                            'villeCommerce','codePostalCommerce','telCommerce',
                            'codeReduction','codeRecrutementVendeur'];

    public function vendeurs()
    {
        return $this->belongsToMany(Vendeur::class);
    }


}