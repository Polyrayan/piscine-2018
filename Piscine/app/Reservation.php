<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
class Reservation extends Model
{

    protected $fillable = ['numReservation','dateReservation','mailClient'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey = 'numReservation';
    protected $keyType = 'string';

    public static function createReservation($mail){
        return Self::create([
            'dateReservation' => Date::now()->format('Y-m-d H:i:s'),
            'mailClient' => $mail
        ]);
    }

    public static function bookingsOfThisMailClient($mail){
        return self::where('mailClient', $mail)
            ->join('contenir', 'contenir.numReservation', '=', 'reservations.numReservation')
            ->join('produits', 'contenir.numProduit', '=', 'produits.numProduit')
            ->get();
    }
}

