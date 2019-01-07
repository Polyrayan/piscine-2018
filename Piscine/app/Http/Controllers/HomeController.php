<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commerce;
use App\Contenir;
use App\Coupon;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Reservation;

use App\TypeProduit;
use function foo\func;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Geocoder;


class HomeController extends Controller
{
    public function show()
    {
        $mailClient = Client::getMailClient();
        $id = Client::getIdClient();
        $nbCompare = Client::calculNumberOfProductToCompare();
        $products = Produit::productsGroupedByVariantPaginate();
        $coordinatesOfClient = Geocoder::getCoordinatesForAddress(Client::getMyAddress());
        $allProducts = Produit::all();
        $categories = TypeProduit::orderBy('nomTypeProduit')->get();
        foreach ($products as $product) {
            //distance
            $product->addDistance($coordinatesOfClient);
            //city
            $product->addCity();
            //colors
            $product->colors = $product->addColors($allProducts);
            //sizes
            $product->sizes = $product->addSizes($allProducts);
        }

        // carousel
        $maxReview = Produit::bestProduct();
        $lastProduct = Produit::lastProduct();

        if(Coupon::all()->count()>0){
            $greatDiscount = Coupon::greatestDiscount();
            if($greatDiscount['value']->valeur == null && $greatDiscount['percent']->valeurPourcentage == null){
                $maxDiscount = [Produit::getRandom()];
                $typeDiscount='none';
                $discount=null;
            }

            elseif($greatDiscount['value']->valeur == null) {
                $maxDiscount = Produit::where('produits.numProduit',$greatDiscount['percent']->numProduit)
                    ->join('coupons','coupons.numProduit','=','produits.numProduit')->get();
                $typeDiscount='percent';
                $discount=$maxDiscount[0]->valeurPourcentage;

            }
            elseif($greatDiscount['percent']->valeurPourcentage == null){
                $maxDiscount = Produit::where('produits.numProduit',$greatDiscount['value']->numProduit)
                    ->join('coupons','coupons.numProduit','=','produits.numProduit')->get();
                $typeDiscount='value';
                $discount=$maxDiscount[0]->valeur;
            }
            else{
                $productDiscountValue = Produit::where('produits.numProduit',$greatDiscount['value']->numProduit)
                    ->join('coupons','coupons.numProduit','=','produits.numProduit')->get();
                $productDiscountPercent = Produit::where('produits.numProduit',$greatDiscount['percent']->numProduit)
                    ->join('coupons','coupons.numProduit','=','produits.numProduit')->get();

                $DiscountValue = $productDiscountValue[0]->valeur; // Remise
                $DiscountPercent = ($productDiscountPercent[0]->prixProduit)*($productDiscountPercent[0]->valeurPourcentage/100); // Prix * Reduction en %

                // Remise plus intéressant que % reduc
                if($DiscountValue>$DiscountPercent){
                    $maxDiscount=$productDiscountValue;
                    $typeDiscount='value';
                    $discount=$DiscountValue;
                }
                // % réduc plus intéressant que remise
                else{
                    $maxDiscount=$productDiscountPercent;
                    $typeDiscount='percent';
                    $discount=$productDiscountPercent[0]->valeurPourcentage;
                }
            }

            return view('welcome', ['products' => $products, 'allProducts' =>$allProducts, 'mailClient' => $mailClient, 'id' => $id, 'nbCompare' => $nbCompare, 'categories' => $categories, 'maxDiscount' => $maxDiscount[0], 'maxReview' => $maxReview, 'lastProduct' => $lastProduct, 'typeDiscount' => $typeDiscount, 'discount' => $discount]);


        }

        else {

            return view('welcome', ['products' => $products, 'allProducts' =>$allProducts, 'mailClient' => $mailClient, 'id' => $id, 'nbCompare' => $nbCompare, 'categories' => $categories, 'maxReview' => $maxReview, 'lastProduct' => $lastProduct]);

        }
    }

    public function selectForm(Request $request)
    {
        if ($request->has('book')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0' ,'max:99999']
            ]);
            $reservation = Reservation::createReservation(request('mailClient'));
            Contenir::createContenir($reservation,request('productNumber'),request('quantity'));
            Produit::decrementProduct(request('productNumber'),request('quantity'));
            flash("Nouvel ajout a la réservation ")->success();
            return back();

        } elseif ($request->has('addShoppingCart')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0']
            ]);

            $panier = Panier::firstOrNewPanier(request('mailClient'));
            Panier::addPriceToThisShoppingCart($panier,request('productPrice'),request('quantity'));

            $commande = Commande::firstOrNewCommande($panier,request('numSiret'));
            Commande::addPriceToThisOrder($commande,request('productPrice'),request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande,request('productNumber'));
            Detenir::storeQuantity($detenir,request('quantity'));

            flash("Nouvel ajout au panier ")->success();
            return back();
        } elseif ($request->has('compare')) {
            return $this->addToCompare();

        } elseif ($request->has('searchProducts')) {


            $search = request('search');
            $category = request('category');
            $min = request('minSearch');
            $max = request('maxSearch');
            $region = request('region');
            $city = request('citySearch');
            $results = Produit::join('commerces', 'commerces.numSiretCommerce', '=','produits.numSiretCommerce')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('nomProduit', 'like', '%' . $search . '%')->orWhere('couleurProduit', 'like', '%' . $search . '%')
                    ->orWhere('tailleProduit', 'like', '%' . $search . '%')
                    ->orWhere('libelleProduit', 'like', '%' . $search . '%')
                    ->orWhere('marqueProduit', 'like', '%' . $search . '%');
            })->when($category != "Toutes catégories", function ($query) use ($category){
                return $query->where('nomTypeProduit',$category);
            })->when(!empty($min) , function ($query) use($min) {
                return $query->where('prixProduit','>=',$min);
            })->when(!empty($max) , function ($query) use($max) {
                return $query->where('prixProduit', '<=', $max);
            })->when(!empty($city) , function ($query) use($city) {
                return $query->where('villeCommerce', $city);
            })->when(!empty($region) and $region != "Languedoc-Roussillon" , function ($query) use($region) {
                return $query->where('regionCommerce', $region);
            })->groupBy('numGroupeVariante')->paginate();

            //return $results;
            $categories = TypeProduit::orderBy('nomTypeProduit')->get();
            $mailClient = Client::getMailClient();
            $id = Client::getIdClient();
            $nbCompare = Client::calculNumberOfProductToCompare();
            $coordinatesOfClient = Geocoder::getCoordinatesForAddress(Client::getMyAddress());
            $allProducts = Produit::all();
            foreach ($results as $product) {
                //distance
                $product->addDistance($coordinatesOfClient);
                //city
                $product->addCity();
                //colors
                $product->colors = $product->addColors($allProducts);
                //sizes
                $product->sizes = $product->addSizes($allProducts);
            }
            return view('welcome', ['products' => $results , 'allProducts' =>$allProducts, 'mailClient' => $mailClient,
                'id' => $id, 'nbCompare' => $nbCompare , 'categories' => $categories, 'search' => $search, 'category' => $category,
                'min' => $min, 'max' => $max, 'region' => $region , 'city' => $city]);
        }
    }

    // bilan des  if
    //  1er if : 2 places dispos
    // 2eme if : 1 place dispo et meme categorie
    // 3eme if : 1 place dispo et pas la meme categorie
    // 4eme if : aucun de dispo et pas la meme categorie
    // 5eme if : aucun de dispo on remplace par le premier

    public function addToCompare()
    {
        $productToCompare = Produit::productWithId(request('productNumber'));
        if (Client::product1And2IsEmpty()) { // if n°1
            Client::addAsProduct1(request('productNumber'));
            flash("le produit est ajouté comme produit n°1 de la comparaison")->success();
            return back();
        } elseif (Client::product1Or2IsEmpty() and $productToCompare->nomTypeProduit == Client::categoryOfNotEmptyProduct()) { // if n°2
            if (Client::product1isEmpty()) {
                Client::addAsProduct1(request('productNumber'));
                flash("le produit est ajouté comme produit n°1 de la comparaison")->success();
                return back();
            } elseif (Client::product2isEmpty()) {
                Client::addAsProduct2(request('productNumber'));
                flash("le produit est ajouté comme produit n°2 de la comparaison")->success();
                return back();
            }

        } elseif (Client::product1Or2IsEmpty() and $productToCompare->nomTypeProduit != Client::categoryOfNotEmptyProduct()) { // if n°3
            if (!Client::product1isEmpty()) {
                Client::deleteProduct1();
            }
            if (!Client::product2IsEmpty()) {
                Client::deleteProduct2();
            }
            Client::addAsProduct1($productToCompare->numProduit);
            flash("catégorie différente ! Réinitialisation des produits comparés...le produit est ajouté comme produit n°1 de la comparaison")->warning();
            return back();

        } elseif (Client::NoneEmptyProducts1And2() and ($productToCompare->nomTypeProduit != Client::categoryOfProduct1() or $productToCompare->nomTypeProduit != Client::categoryOfProduct2())) { // if n°4
            if (!Client::product1IsEmpty() and $productToCompare->nomTypeProduit != Client::categoryOfProduct1()) {
                Client::deleteProduct1();
                if (!Client::product2IsEmpty()) {
                    Client::deleteProduct2();
                }
                Client::addAsProduct1($productToCompare->numProduit);
                flash("catégorie différente ! Réinitialisation des produits comparés...le produit est ajouté comme produit n°1 de la comparaison")->warning();
                return back();
            }
            if (!Client::product2IsEmpty() and $productToCompare->nomTypeProduit != Client::categoryOfProduct1()) {
                Client::deleteProduct2();
                if (!Client::product1IsEmpty()) {
                    Client::deleteProduct1();
                }
                Client::addAsProduct1($productToCompare->numProduit);
                flash("catégorie différente ! Réinitialisation des produits comparés...le produit est ajouté comme produit n°1 de la comparaison")->warning();
                return back();
            }
        }
        else { // if n°5 dans le if n°4
            Client::deleteProduct1();
            Client::addAsProduct1($productToCompare->numProduit);
            flash("ancien produit n°1 remplacé par celui-ci dans les produits à comparer")->warning();
            return back();
        }
    }
}
