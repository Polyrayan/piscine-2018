<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    public $timestamps = false;
    protected $fillable = ['numAvis','commentaireAvis','noteAvis','dateAvis','numProduit','mailClient'];
    protected $table = 'avis';
    protected $primaryKey = 'numAvis';

}