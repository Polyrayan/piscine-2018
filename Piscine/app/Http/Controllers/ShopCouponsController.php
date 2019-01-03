<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commerce;
use App\Jour;
use App\Ouvrir;
use App\Produit;
use App\Coupon;
use App\TypeProduit;
use Illuminate\Http\Request;
use function Symfony\Component\Console\Tests\Command\createClosure;

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
            return view('myCoupons');
        }
        else {
            return view('myCoupons')->with(['coupons' => $coupons , 'nomCommerce' => $nomCommerce]);
        }

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