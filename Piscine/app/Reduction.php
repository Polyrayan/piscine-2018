<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Reduction extends Model
{

    protected $fillable = ['numReduction','pointsReduction','dateDebutReduction','dateFinReduction','mailClient'];

    public $timestamps = false;
    protected $primaryKey = 'numReservation';
    protected $keyType = 'string';

    //variables

    private static $minimumToGetReductionPoints = 10;
    private static $daysBeforeDestroyReductionPoints = 14;

    //functions

    public static function setMinimumToGetReduction($value){
        self::$minimumToGetReductionPoints = $value;
    }

    public static function setDaysBeforeDestroyReductionPoints($value){
        self::$daysBeforeDestroyReductionPoints = $value;
    }

    /*
     * @param : take a Date with the format Y-m-d*
     * @return: return the Date by adding it daysBeforeDestroyReductionPoints
     */
    public static function calculateDateToDestroyReductionPoints($date){
        $newdate = $date->add(self::$daysBeforeDestroyReductionPoints.' days');
        return $newdate->format('Y-m-d');
        /*
         * Example :
         * $reduction = new Reduction();
         * $date = Date::now();
         * return $reduction->calculateDateToDestroyReductionPoints($date);
         *
         */
    }

    public static function createClientReduction($mail){
        $date = Date::now();
        $finalDate = self::calculateDateToDestroyReductionPoints($date);
        return self::create([
            'mailClient' => $mail,
            'pointsReduction' => 0,
            'dateDebutReduction' => $date,
            'dateFinReduction' => $finalDate,
        ]);
    }

    public static function getReductionPoints($mail){
        $paniers = Panier::where('mailClient',$mail)->get();
        $nb = 0;
        foreach ($paniers as $panier){
            $date = new Date($panier->datePanier);
            if (Date::now() <= self::calculateDateToDestroyReductionPoints($date)) {
                $nb += $panier->qtePointsAcquis;
            }
        }
        return $nb;
    }
}

