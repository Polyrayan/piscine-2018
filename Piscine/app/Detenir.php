<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detenir extends Model
{

    protected $fillable = ['numCommande','numProduit','qteCommande'];

    public $timestamps = false;
    protected $table ='detenir';
    public $incrementing = false;
    protected $primaryKey = 'numCommande';

}
