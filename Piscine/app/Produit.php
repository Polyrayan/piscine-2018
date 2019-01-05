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


    /**
     * calcule la distance entre la position du client en parametre et l'adresse du produit
     * @param $position1
     */
    public function addDistance($position1){
        $productAddress = Commerce::getShopAddress($this->numSiretCommerce);
        $productsCoordinates = Geocoder::getCoordinatesForAddress($productAddress);
        $this->distance = Geocoder::getDistanceBetween($position1, $productsCoordinates);
    }


    /**
     * ajoute toutes les variantes de couleurs d'un produit
     * @param $allProducts
     * @return array
     */
    public function addColors($allProducts){
        $array = array();
        foreach ($allProducts->where('numGroupeVariante', $this->numGroupeVariante ) as $singleProduct){
            if (!empty($singleProduct->couleurProduit) and !in_array($singleProduct->couleurProduit, $array)) {
                array_push($array, $singleProduct->couleurProduit);
            }
        }
        return $array;
    }


    /**
     * ajoute toutes les variantes de tailles d'un produit
     * @param $allProducts
     * @return array
     */
    public function addSizes($allProducts){
        $array = array();
        foreach ($allProducts->where('numGroupeVariante', $this->numGroupeVariante ) as $singleProduct) {
            if (!empty($singleProduct->tailleProduit) and !in_array($singleProduct->tailleProduit, $array)) {
                array_push($array, $singleProduct->tailleProduit);
            }
        }
        return $array;
    }


    /**
     * ajoute la ville sur ce produit
     */
    public function addCity(){
        $this->city = Commerce::getCity($this->numSiretCommerce);
    }


    /**
     * Supprime un produit grace a son numero de produit
     * @param $productNumber
     */
    public static function deleteProduct($productNumber){
        $product = self::where('numProduit', $productNumber)->firstOrFail();
        $product->delete();
    }


    /**
     * renvoie la liste des produits d'un commerce
     * @param $siret
     * @return mixed
     */
    public static function productsOfThisShop($siret){
        return self::where('numSiretCommerce', $siret)->get();
    }


    /**
     * deduit du stock du produit la quantité en parametre
     * @param $numProduct
     * @param $quantity
     * @return mixed
     */
    public static function decrementProduct($numProduct, $quantity){
        return self::where('numProduit' , $numProduct)->decrement('qteStockDispoProduit', $quantity );
    }


    /**
     * renvoie le produit dont le numero de produit équivaut a celui donné en parametre
     * @param $id
     * @return mixed
     */
    public static function productWithId($id){
        return self::where('numProduit',$id)->firstOrFail();
    }


    /**
     * renvoie le nom de la categorie du groupe de variante en parametre
     * @param $number
     * @return mixed
     */
    public static function category($number)
    {
        $product = self::where('numGroupeVariante',$number)->firstOrFail();
        return $product->nomTypeProduit;
    }

    /**
     * renvoie les produits qui ont le meme numGroupeVariante que celui donné en parametre
     * @param $number
     * @return mixed
     */
    public static function productsOfThisGroup($number)
    {
        return self::where('numGroupeVariante',$number)->get();
    }

    /**
     * renvoie le premier produit qui a le meme numGroupeVariante que celui donné en parametre
     * @param $number
     * @return mixed
     */
    public static function firstProductOfThisGroup($number)
    {
        return self::where('numGroupeVariante',$number)->firstOrFail();
    }


    /**
     * tri les produits du commerce groupé par variante
     * @param $siret
     * @return mixed
     */
    public static function productsOfThisShopGroupedByVariant($siret){
        return self::where('numSiretCommerce', $siret)
            ->groupBy('numGroupeVariante')
            ->get();
    }


    /**
     *
     * @return mixed
     */
    public static function productsGroupedByVariant(){
        return self::groupBy('numGroupeVariante')->get();
    }


    /**
     * recupere les tailles et les couleurs du commerce
     * @param $siret
     * @return mixed
     */
    public static function allVariants($siret)
    {
        return self::where('numSiretCommerce', $siret)
            ->get(['numProduit','numGroupeVariante','couleurProduit','tailleProduit']);
    }


    /**
     * recupere la categorie du produit
     * @param $numProduit
     * @return mixed
     */
    public static function getTypeProduit($numProduit){
        $product = self::where('numProduit',$numProduit)->firstOrFail();
        return $product->nomTypeProduit;
    }

    /**
     * renvoie la note moyenne des avis, renvoie "non noté" s'il n'y en a pas
     * @param $avis
     * @return float|int|string
     */
    public static function noteMoy($avis){
        $moy = 0;
        $nb = 0;
        foreach ($avis as $_avis) {
            $moy += $_avis->noteAvis;
            $nb += 1;
        }
        if ($nb != 0){
            $moy = $moy / $nb;
            return $moy;
        }
        else{
            return "Non noté";
        }
    }

    /**
     * retrouve le produit correspondant a cette couleur et cette la taille dans le groupe de variante du produit
     * @param request('size')
     * @param request('color')
     * @param request('productNumber')
     * @return array|\Illuminate\Http\Request|string
     */

    public static function whichProduct(){
        $product = self::productWithId(request('productNumber'));
        if(empty(request('color')) and empty(request('size'))){
            return request('productNumber');
        }
        if(!empty(request('color')) and  empty(request('size'))){  // s'il y a une couleur mais pas de taille
              $groupeVariante = $product->numGroupeVariante;
              $goodProduct = self::where("numGroupeVariante", $groupeVariante)->where("couleurProduit",request('color'))->first();
              return $goodProduct;
            }
          if(empty(request('color')) and  empty(request('size'))){  // s'il y a une taille mais pas de couleur
              $groupeVariante = $product->numGroupeVariante;
              $goodProduct = self::where("numGroupeVariante", $groupeVariante)->where("tailleProduit",request('size'))->first();
        return $goodProduct->numProduit;
        }
         if(!empty(request('color')) and  !empty(request('size'))){  // s'il y a une taille  et une  couleur
             $groupeVariante = $product->numGroupeVariante;
             $goodProduct = self::where("numGroupeVariante", $groupeVariante)->where("couleurProduit",request('color'))->where("tailleProduit",request('size'))->first();
             return $goodProduct->numProduit;
        }
    }

    public static function editProduct(){
        $delivery = request('delivery') - 1;
        self::where('numProduit',request('id'))
            ->update(['nomProduit'=> request('name') ,
                'libelleProduit'=> request('libelle'),
                'qteStockProduit' => request('qteStockProduit'),
                'livraisonProduit' => $delivery,
                'prixProduit' => request('prix'),
                'couleurProduit' => request('couleurProduit'),
                'tailleProduit' => request('tailleProduit'),
                'marqueProduit' => request('marqueProduit')
            ]);
    }
}
