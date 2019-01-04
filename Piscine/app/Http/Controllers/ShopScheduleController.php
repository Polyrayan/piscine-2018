<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Jour;
use App\Ouvrir;
use App\Vendeur;
use Illuminate\Http\Request;

class ShopScheduleController extends Controller
{
    /*
     * @param : numSiret
     * @return : view to show all orders in progress and all completed orders
     */
    public function show($siretNumber)
    {
        $days = Jour::all();
        $daysOfShop = Ouvrir::where('numSiretCommerce', $siretNumber)->get();
        $schedules = Ouvrir::where('numSiretCommerce', $siretNumber)
            ->leftjoin('jours', 'ouvrir.nomJour', '=', 'jours.nomJour')->groupBy('numJour')
            ->orderBy('numJour')->get();
        $favoriteShop = Vendeur::getMyFavoriteShop();
        $adminConnected = Admin::isConnected();
        if ($daysOfShop->isEmpty()){
            return view('editSchedule')->with(['days' => $days, 'siretNumber' => $siretNumber, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected]);
        }
        return view('editSchedule')->with(['days'=> $days , 'daysOfShop' =>$daysOfShop, 'siretNumber' => $siretNumber,
            'schedules' => $schedules, 'favoriteShop' => $favoriteShop, 'adminConnected'=> $adminConnected ]);
    }

    public function selectForm(Request $request)
    {
        if ($request->has('add')) {
            return $this->addSchedule(request('day'),request('siretNumber'),request('start'),request('end'));
        }
        elseif ($request->has('edit')) {
            return $this->updateSchedule(request('id'),request('start'), request('end'));
        }
        elseif ($request->has('delete')) {
            return $this->destroySchedule(request('id'));
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

        Ouvrir::Create([
            'nomJour' => $day,
            'numSiretCommerce' => $siretNumber,
            'debut' => $start,
            'fin' => $end
        ]);
        return back();
    }
    public function destroySchedule($id){
        $schedule = Ouvrir::where('numOuvrir', $id)->firstOrFail();
        $schedule->delete();
        return back();
    }
}