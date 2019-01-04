<?php
namespace App\Http\Controllers;

use App\Commerce;
use App\Admin;
use App\Ouvrir;
use App\Vendeur;
use App\Coupon;
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
            return view('myCoupons')->with(['nomCommerce' => $nomCommerce, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);
        }
        return view('myCoupons')->with(['coupons' => $coupons , 'nomCommerce' => $nomCommerce, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);

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