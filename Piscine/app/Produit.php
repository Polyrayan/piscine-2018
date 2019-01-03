<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Geocoder;
class Produit extends Model
{
    protected $fillable = ['numProduit','nomProduit','libelleProduit','qteStockProduit',
        'qteStockDispoProduit','livraisonProduit','prixProduit',
        'numSiretCommerce','nomTypeProduit','couleurProduit','tailleProduit',
        'marqueProduit','numGroupeVariante'];

    public $timestamps = false; // pour ne pas avoir de colonne supplementaire (updated_at)
    protected $primaryKey = 'numProduit';
    protected $keyType = 'string';
    private $colors = array();
    private $sizes = array();


    public static function validateProduct(){
        request()->validate([
            'productName' => ['bail', 'required'],
            'description' => ['bail', 'required'],
            'stock' => ['bail', 'required', 'int'],
            'delivery' => ['bail', 'required'],
            'price' => ['bail', 'required', 'numeric'],
            //'color' => ['string'],
            //'brand' => ['string'],
        ]);
    }

    public static function createProduct($numGroupVariant){
        return self::create([
            'nomTypeProduit' => request('nomType'),
            'nomProduit' => request('productName'),
            'libelleProduit' => request('description'),
            'qteStockProduit' => request('stock'),
            'qteStockDispoProduit' => request('stock'),
            'livraisonProduit' => request('delivery'),
            'prixProduit' => request('price'),
            'numSiretCommerce' => request('numSiretCommerce'),
            'couleurProduit' => request('color'),
            'tailleProduit' => request('size'),
            'marqueProduit' => request('brand'),
            'numGroupeVariante' => $numGroupVariant,
        ]);
    }

    public static function updateProduct(){                     // todo a tester
        self::where('numProduit',request('productNumber'))
            ->update(['nomProduit'=> request('productName') ,
                'libelleProduit'=> request('description'),
                'qteStockProduit' => request('stock'),
                'qteStockDispoProduit' => request('stock'),
                'livraisonProduit' => request('delivery'),
                'prixProduit' => request('price'),
                'numSiretCommerce' => request('numSiretCommerce'),
                'couleurProduit' => request('color'),
                'tailleProduit' => request('size'),
                'marqueProduit' => request('brand')
            ]);
    }

    public function addDistance($position1){
        $productAddress = Commerce::getShopAddress($this->numSiretCommerce);
        $productsCoordinates = Geocoder::getCoordinatesForAddress($productAddress);
        $this->distance = Geocoder::getDistanceBetween($position1, $productsCoordinates);
    }

    public function addColors($allProducts){
        $array = array();
        foreach ($allProducts->where('numGroupeVariante', $this->numGroupeVariante ) as $singleProduct){
            if (!empty($singleProduct->couleurProduit) and !in_array($singleProduct->couleurProduit, $array)) {
                array_push($array, $singleProduct->couleurProduit);
            }
        }
        return $array;
    }

    public function addSizes($allProducts){
        $array = array();
        foreach ($allProducts->where('numGroupeVariante', $this->numGroupeVariante ) as $singleProduct) {
            if (!empty($singleProduct->tailleProduit) and !in_array($singleProduct->tailleProduit, $array)) {
                array_push($array, $singleProduct->tailleProduit);
            }
        }
        return $array;
    }

    public function addCity(){
        $this->city = Commerce::getCity($this->numSiretCommerce);
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

    public static function category($number)
    {
        $product = self::where('numGroupeVariante',$number)->firstOrFail();
        return $product->nomTypeProduit;
    }

    public static function productsOfThisGroup($number)
    {
        return self::where('numGroupeVariante',$number)->get();
    }

    public static function firstProductOfThisGroup($number)
    {
        return self::where('numGroupeVariante',$number)->firstOrFail();
    }

    public static function productsOfThisShopGroupedByVariant($siret){
        return self::where('numSiretCommerce', $siret)
            ->groupBy('numGroupeVariante')
            ->get();
    }

    public static function productsGroupedByVariant(){
        return self::groupBy('numGroupeVariante')->get();
    }

    public static function allVariants($siret)
    {
        return self::where('numSiretCommerce', $siret)
            ->get(['couleurProduit','tailleProduit']);
    }

    public static function getTypeProduit($numProduit){
        $product = self::where('numProduit',$numProduit)->firstOrFail();
        return $product->nomTypeProduit;
    }
}

