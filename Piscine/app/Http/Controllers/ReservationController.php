<?php

namespace App\Http\Controllers;

use App\Contenir;
use App\Produit;
use App\Reservation;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;


class ReservationController extends Controller
{

    public function show($id)
    {
        $client = Client::select('mailClient')->where('idClient',$id)->firstOrFail();
        $reservations = Reservation::where('mailClient',$client->mailClient)->join('contenir', 'contenir.numReservation', '=', 'reservations.numReservation')
                                                                            ->join('produits', 'contenir.numProduit', '=' , 'produits.numProduit')->get();
        if($reservations->isEmpty()){
            return view('myReservations');
        }
        return view('myReservations')->with(['reservations' => $reservations]);
    }
}
