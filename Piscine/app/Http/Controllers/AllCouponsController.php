<?php
namespace App\Http\Controllers;

use App\Commerce;
use App\Admin;
use App\Ouvrir;
use App\Produit;
use App\TypeProduit;
use App\Vendeur;
use App\Coupon;
use Illuminate\Http\Request;
class AllCouponsController extends Controller
{
    /*
     * @param : id
     * @return : view to show all coupons possible
     */
    public function show($id)
    {
        $coupons = Coupon::all();
        $adminConnected = Admin::isConnected();

//        // parsing information to be given to the view
//        $couponsView = array();
//
        foreach($coupons as $coupon) {
            if($coupon->numProduit) {
                $coupon["nomProduit"] = Produit::productWithId($coupon->numProduit)->nomProduit;
                unset($coupon->{"numProduit"});
            }

            if(!$coupon->numProduit) {
                unset($coupon->{"numProduit"});
            }

            if(!$coupon->nomTypeProduit) {
                unset($coupon->{"nomTypeProduit"});
            }

            if(!$coupon->valeur) {
                unset($coupon->{"valeur"});
            }

            if(!$coupon->valeurPourcentage) {
                unset($coupon->{"valeurPourcentage"});
            }

            $dateB = date_create($coupon->dateLimite);
            $coupon->dateLimite = date_format($dateB, "d M Y");
            $coupon['commerce'] = Commerce::nameOfThisShop($coupon->numSiretCommerce);
            unset($coupon->numSiretCommerce);
//            $aux['codeCoupon'] = $coupon->codeCoupon;
//            $aux['commerce'] = Commerce::nameOfThisShop($coupon->numSiretCommerce);
//            if($coupon->numProduit) {
//                $aux['target'] = ['produit' , Produit::productWithId($coupon->numProduit)->nomProduit];
//            }
//            else {
//                $aux['target'] = ['categorie' , $coupon->nomTypeProduit];
//            }
//            if($coupon->valeur) {
//                $aux['valeur'] = ['absolue' , $coupon->valeur];
//            }
//            else {
//                $aux['valeur'] = ['pourcentage' , $coupon->valeurPourcentage];
//            }
//            $aux['quantiteMax'] = $coupon->quantiteMax;
//            $aux['description'] = $coupon->description;
//            array_push($couponsView, $aux);
        }


//        return $coupons;

        if ($coupons->isEmpty()){
            return view('allCoupons')->with(['id'=>$id, 'nbCompare' => 0,'adminConnected'=> $adminConnected]);
        }
        return view('allCoupons')->with(['id'=>$id, 'nbCompare' => 0, 'coupons' => $coupons, 'adminConnected'=> $adminConnected]);

    }
    public function selectForm(Request $request)
    {
        if ($request->has('add')) {
            return $this->addCoupon(request('day'),request('siretNumber'),request('start'),request('end'));
        }
        elseif ($request->has('edit')) {
            return $this->updateCoupon(request('id'),request('start'), request('end'));
        }
        elseif ($request->has('delete')) {
            return $this->destroyCoupon(request('id'));
        }
    }
    public function updateSchedule($id,$start,$end){
        request()->validate([
            'start' => ['required','date_format:H:i'],
            'end' => ['required','date_format:H:i','after:start']
        ]);
        Ouvrir::where('numOuvrir',$id)->update(['debut' => $start , 'fin' => $end]);
        return back();
    }
    public function addSchedule($day,$siretNumber,$start,$end)
    {
        request()->validate([
            'day' => ['required','string'],
            'siretNumber' => ['required'],
            'start' => ['required','date_format:H:i'],
            'end' => ['required','date_format:H:i','after:start']
        ]);
        Coupon::Create([
            'nomJour' => $day,
            'numSiretCommerce' => $siretNumber,
            'debut' => $start,
            'fin' => $end
        ]);
        return back();
    }
    public function destroySchedule($codeCoupon){
        $schedule = Ouvrir::where('codeCoupon', $codeCoupon)->firstOrFail();
        $schedule->delete();
        return back();
    }
}