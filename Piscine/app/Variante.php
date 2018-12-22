<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    public $timestamps = false;
    protected $fillable = ['numGroupeVariante'];
    protected $primaryKey = 'numGroupeVariante';
    protected $keyType = 'string';

    public static function createVariant(){
        return self::create();
    }
}