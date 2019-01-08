<?php
namespace App\Http\Controllers;

use App\Commerce;
use App\Admin;
use App\Ouvrir;
use App\Produit;
use App\Vendeur;
use App\Coupon;
use App\TypeProduit;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class ShopCouponsController extends Controller
{
    /*
     * @param : numSiret
     * @return : view to show all coupons of a store
     */
    public function show($siretNumber)
    {
        $coupons = Coupon::where('numSiretCommerce' , $siretNumber)->get();
        foreach($coupons as $coupon) {
            if ($coupon->numProduit) {
                $coupon["nomProduit"] = Produit::productWithId($coupon->numProduit)->nomProduit;
                unset($coupon->{"numProduit"});
            }

            if(!$coupon->nomTypeProduit) {
                unset($coupon->{"nomTypeProduit"});
            }
        }
        $nomCommerce = Commerce::nameOfThisShop($siretNumber);
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $adminConnected = Admin::isConnected();
        $produits = Produit::productsOfThisShop($siretNumber);

        $nomsProduits = array();
        $types = array();
        foreach($produits as $produit) {
            array_push($nomsProduits, $produit->nomProduit);
            array_push($types, $produit->nomTypeProduit);
        }
        $nomsProduits = array_unique($nomsProduits);
        $types = array_unique($types);

        if ($coupons->isEmpty()){
            return view('myCoupons')->with(['nomsProduits' => $nomsProduits, 'types' => $types, 'numCommerce' => $siretNumber, 'nomCommerce' => $nomCommerce, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);
        }
        return view('myCoupons')->with(['coupons' => $coupons ,'nomsProduits' => $nomsProduits, 'types' => $types, 'numCommerce' => $siretNumber, 'nomCommerce' => $nomCommerce, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);

    }
    public function selectForm(Request $request)
    {
        if ($request->has('add')) {
            return $this->addCoupon(request('codeCoupon'),request('numSiretCommerce'),
                request('nomTypeProduit'),request('nomProduit'),request('valeur')
                ,request('valeurPourcentage'),request('description'),request('dateLimite')
                ,request('qteMax'));
        }
        elseif ($request->has('update')) {
            return $this->updateCoupon(request('codeCoupon'),request('produit'),request('valeur')
                ,request('description'),request('dateLimite2')
                ,request('qteMax'));
        }
        elseif ($request->has('delete')) {
            return $this->destroyCoupon(request('codeCoupon'));
        }
    }
    public function updateCoupon($codeCoupon,$produit, $valeur, $description,
                              $dateLimite, $qteMax){

        $coupon = Coupon::couponWithCode($codeCoupon);
        if(!$coupon){
            return back()->withErrors([
                'codeCoupon' => 'Ce coupon n\'existe pas',
            ]);
        }

        $c = $valeur[-1];
        $valeurAbsolue = Null;
        $valeurPourcentage = Null;

        if ($c == '%') {
            $valeurPourcentage = floatval(substr($valeur, 0,strlen($valeur) -1));
            if($valeurPourcentage <= 0){
                return back()->withErrors([
                    'valeurIn' => 'Valeur doit etre positive.',
                ]);
            }
            if($valeurPourcentage > 100){
                return back()->withErrors([
                    'valeurIn' => 'Une valeur procentuale est au plus 100.',
                ]);
            }
        }

        else {
            $valeurAbsolue = floatval(substr($valeur, 0,strlen($valeur) -1));
            if($valeurAbsolue <= 0){
                return back()->withErrors([
                    'valeurIn' => 'Valeur doit etre positive.',
                ]);
            }

        }



        $produitDeNomProduit = Produit::where('nomProduit',$produit)->first();
        $numProduit = Null;
        $nomTypeProduit = Null;
        if($produitDeNomProduit){
            $numProduit = $produitDeNomProduit->numProduit;
        }else{
            $nomTypeProduit = $produit;
        }



        $coupon->update([
            'codeCoupon' => $codeCoupon,
            'nomTypeProduit'=> $nomTypeProduit,
            'numProduit'=> $numProduit,
            'valeur' => $valeurAbsolue,
            'valeurPourcentage'=> $valeurPourcentage,
            'dateLimite'=> $dateLimite,
            'quantiteMax'=> $qteMax,
            'description'=> $description
        ]);

        return back();
    }

    public function addCoupon($codeCoupon,$numSiretCommerce,$nomTypeProduit,
                              $nomProduit, $valeur, $valeurPourcentage, $description,
                              $dateLimite, $qteMax)
    {
        request()->validate([
            'codeCoupon' => ['required'],
            'numSiretCommerce' => ['required'],
        ]);

        if(($nomProduit && $nomTypeProduit) || (!$nomProduit && !$nomTypeProduit)){
            return back()->withErrors([
                'nomProduit' => 'Vous devez choisir entre une categorie ou un produit.',
                'nomTypeProduit' => 'Vous devez choisir entre une categorie ou un produit.',
            ]);
        }

        $dateNew = date("Y/m/d h:i:s" , strtotime($dateLimite));
        $dateNow = date_create('now');

//        if ($dateNow > $dateNew) {
//            return back()->withErrors([
//                'dateLimite' => 'La date limite doit etre apres la date courante.',
//            ]);
//        }
        $numProduit = Produit::where('nomProduit', $nomProduit)->first();
        if($numProduit){
          Coupon::Create([
              'codeCoupon' => $codeCoupon,
              'numSiretCommerce' => $numSiretCommerce,
              'nomTypeProduit' => $nomTypeProduit,
              'numProduit' => $numProduit->numProduit,
              'valeur' => $valeur,
              'valeurPourcentage' => $valeurPourcentage,
              'description' => $description,
              'dateLimite' => $dateNew,
              'quantiteMax' => $qteMax
          ]);
        }
        else{
          Coupon::Create([
              'codeCoupon' => $codeCoupon,
              'numSiretCommerce' => $numSiretCommerce,
              'nomTypeProduit' => $nomTypeProduit,
              'numProduit' => $numProduit,
              'valeur' => $valeur,
              'valeurPourcentage' => $valeurPourcentage,
              'description' => $description,
              'dateLimite' => $dateNew,
              'quantiteMax' => $qteMax
          ]);
        }

        return back();
    }
    public function destroyCoupon($codeCoupon){
        $coupon = Coupon::where('codeCoupon', $codeCoupon)->first();
        $coupon->delete();
        return back();
    }
}
