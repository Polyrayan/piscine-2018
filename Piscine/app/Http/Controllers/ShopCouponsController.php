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
class ShopCouponsController extends Controller
{
    /*
     * @param : numSiret
     * @return : view to show all coupons of a store
     */
    public function show($siretNumber)
    {
        $coupons = Coupon::where('numSiretCommerce' , $siretNumber)->get();
        $nomCommerce = Commerce::nameOfThisShop($siretNumber);
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $adminConnected = Admin::isConnected();
        $types = TypeProduit::all(); // TO DO : TYPESOFASHOP
        $produits = Produit::productsOfThisShop($siretNumber);
        $nomsProduits = array();

        foreach($produits as $produit) {
            array_push($nomsProduits, $produit->nomProduit);
        }
        $nomsProduits = array_unique($nomsProduits);
//        return $types;
//        foreach ($coupons as $coupon) {
//            if(!$coupon->nomTypeProduit) {
//                unset($o->{"property_name"}
//            }
//
//            else {
//
//            }
//        }
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
        elseif ($request->has('edit')) {
            return $this->updateCoupon(request('id'),request('start'), request('end'));
        }
        elseif ($request->has('delete')) {
            return $this->destroyCoupon(request('id'));
        }
    }
//    public function updateSchedule($id,$start,$end){
//        request()->validate([
//            'start' => ['required','date_format:H:i'],
//            'end' => ['required','date_format:H:i','after:start']
//        ]);
//        Ouvrir::where('numOuvrir',$id)->update(['debut' => $start , 'fin' => $end]);
//        return back();
//    }

    public function addCoupon($codeCoupon,$numSiretCommerce,$nomTypeProduit,
                              $nomProduit, $valeur, $valeurPourcentage, $description,
                              $dateLimite, $qteMax)
    {
        request()->validate([
            'codeCoupon' => ['required','string'],
            'siretNumber' => ['required'],
            'nomTypeProduit' => ['string'],
            'nomProduit' => ['string'],
            'valeur' => ['numeric'],
            'valeurPourcentage' => ['numeric'],
            'qteMax' => ['numeric'],
        ]);

        if(($nomProduit && $nomTypeProduit) || (!$nomProduit && !$nomTypeProduit)){
            return back()->withErrors([
                'nomProduit' => 'Vous devez choisir entre une categorie ou un produit.',
                'nomTypeProduit' => 'Vous devez choisir entre une categorie ou un produit.',
            ]);
        }


        $dateNew = date("Y/m/d h:i:s" , strtotime($dateLimite));

        if ($dateNew > date_create('now')) {
            return back()->withErrors([
                'dateLimite' => 'La date limite doit etre apres la date courante.',
            ]);
        }

        Coupon::Create([
            'codeCoupon' => $codeCoupon,
            'numSiretCommerce' => $numSiretCommerce,
            'nomTypeProduit' => $nomTypeProduit,
            'nomProduit' => $nomProduit,
            'valeur' => $valeur,
            'valeurPourcentage' => $valeurPourcentage,
            'description' => $description,
            'dateLimite' => $dateNew,
            'qteMax' => $qteMax
        ]);
        return back();
    }
    public function destroySchedule($codeCoupon){
        $schedule = Coupon::where('codeCoupon', $codeCoupon)->firstOrFail();
        $schedule->delete();
        return back();
    }
}