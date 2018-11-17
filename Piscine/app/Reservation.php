<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    protected $fillable = ['numReservation','dateReservation','mailClient'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)


}
