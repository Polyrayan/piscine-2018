<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['numProduit','nomProduit','libelleProduit','qteStockProduit',
        'qteStockDispoProduit','livraisonProduit','prixProduit',
        'qte1','qte2','numSiretCommerce','numTypeProduit','numCommande', 'numReservation'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey = 'numProduit';
    protected $keyType = 'string';


    public static function validateProduct(){
        request()->validate([
            'productName' => ['bail', 'required'],
            'description' => ['bail', 'required'],
            'stock' => ['bail', 'required', 'int'],
            'delivery' => ['bail', 'required'],
            'price' => ['bail', 'required', 'numeric'],
        ]);
    }

    public static function createProduct(){
        return self::create([
            'numTypeProduit' => request('numType'),
            'nomProduit' => request('productName'),
            'libelleProduit' => request('description'),
            'qteStockProduit' => request('stock'),
            'qteStockDispoProduit' => request('stock'),
            'livraisonProduit' => request('delivery'),
            'prixProduit' => request('price'),
            'numSiretCommerce' => request('numSiretCommerce')
        ]);
    }

    public static function deleteProduct($productNumber){
        $product = self::where('numProduit', $productNumber)->firstOrFail();
        $product->delete();
    }

    public static function productsOfThisShop($siret){
        return self::where('numSiretCommerce', $siret)->get();
    }

    public static function decrementProduct($numProduct,$quantity){
        return self::where('numProduit' , $numProduct)->decrement('qteStockDispoProduit', $quantity );
    }

    public static function productWithId($id){
        return self::where('numProduit',$id)->firstOrFail();
    }
}

