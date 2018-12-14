<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jour extends Model
{

    protected $fillable = ['numJour','nomJour'];

    protected $table ='jours';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'nomJour';
    protected $keyType = 'string';

}
