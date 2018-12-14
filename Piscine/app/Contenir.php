<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenir extends Model
{

    protected $fillable = ['numReservation','numProduit','qteReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='contenir';
    protected $primaryKey ='numReservation';
    protected $keyType = 'string';


    public static function createContenir($reservation,$numProduct,$quantity){
        return Self::create([
            'numReservation' => $reservation->numReservation,
            'numProduit' => $numProduct,
            'qteReservation' => $quantity
        ]);
    }

    public static function updateQuantityContenir($reservationNumber,$newQuantity){
        return self::where('numReservation', $reservationNumber)->update(['qteReservation' => $newQuantity]);
    }

    public static function getContenirWithReservationNumber($reservationNumber){
        return self::where('numReservation', $reservationNumber)->firstOrFail();
    }
}
