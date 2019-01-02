<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    protected $fillable = ['nomTypeProduit','tempsReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $table ='typeProduits';
    protected $primaryKey = 'nomTypeProduit';
    protected $keyType = 'string';

    public static function createCategorie(){
        return self::create([
            'nomTypeProduit' => request('Nom'),
            'tempsReservation' => request('temps'),
        ]);
    }
    public static function changeCategorie(){
        TypeProduit::where('nomTypeProduit',request('Nom'))
            ->update(['tempsReservation'=> request('temps')
            ]);
    }
    public static function deleteCategorie(){
        $product = self::where('nomTypeProduit', request('Nom'));
        $product->delete();
    }
}
