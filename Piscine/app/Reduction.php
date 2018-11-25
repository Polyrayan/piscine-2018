<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Reduction extends Model
{

    protected $fillable = ['numReduction','pointsReduction','dateDebutReduction','dateFinReduction','mailClient'];

    public $timestamps = false;
    protected $primaryKey = 'numReservation';

    //variables

    protected $minimumToGetReductionPoints = 10;
    protected $daysBeforeDestroyReductionPoints = 14;

    //functions

    public function getMinimumToGetReduction(){
        return $this->minimumToGetReductionPoints;
    }

    public function setMinimumToGetReduction($value){
        $this->minimumToGetReductionPoints = $value;
    }

    public function getDaysBeforeDestroyReductionPoints(){
        return $this->daysBeforeDestroyReductionPoints;
    }

    public function setDaysBeforeDestroyReductionPoints($value){
        $this->daysBeforeDestroyReductionPoints = $value;
    }

    /*
     * @param : take a Date with the format Y-m-d*
     * @return: return the Date by adding it daysBeforeDestroyReductionPoints
     */
    public function calculateDateToDestroyReductionPoints($date){
        $newdate = $date->add($this->getDaysBeforeDestroyReductionPoints().' days');
        return $newdate->format('Y-m-d');
        /*
         * Example :
         * $reduction = new Reduction();
         * $date = Date::now();
         * return $reduction->calculateDateToDestroyReductionPoints($date);
         *
         */
    }
}

