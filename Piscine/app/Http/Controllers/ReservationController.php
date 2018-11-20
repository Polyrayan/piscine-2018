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
        $client = Client::select('mailClient')->where('idClient', $id)->firstOrFail();
        $reservations = Reservation::where('mailClient', $client->mailClient)->join('contenir', 'contenir.numReservation', '=', 'reservations.numReservation')
            ->join('produits', 'contenir.numProduit', '=', 'produits.numProduit')->get();

        $sum = Reservation::where('mailClient', $client->mailClient)
            ->join('contenir', 'contenir.numReservation', '=', 'reservations.numReservation')
            ->join('produits', 'contenir.numProduit', '=', 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * contenir.qteReservation) as total'))->first();

        if ($reservations->isEmpty()) {
            return view('myReservations');
        }
        $total = $sum->total;

        return view('myReservations')->with(['reservations' => $reservations, 'total' => $total]);
    }

    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('update')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('delete')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));
        }
    }

    public function updateQuantity($reservationNumber,$productNumber,$newQuantity)
    {
        $contenir = Contenir::where('numReservation', $reservationNumber)->firstOrFail();
        $oldQuantity = $contenir->qteReservation;
        $produit = Produit::where('numProduit', $productNumber)->firstOrFail();
        if ($newQuantity > $oldQuantity){
            $produit->qteStockDispoProduit -= ($newQuantity - $oldQuantity);
        }else{
            $produit->qteStockDispoProduit +=  $oldQuantity - $newQuantity;
        }
        $produit->save();
        Contenir::where('numReservation', $reservationNumber)->update(['qteReservation' => $newQuantity]);
        return back();
    }

    public function deleteQuantity($reservationNumber,$productNumber){
        $contenir = Contenir::where('numReservation', $reservationNumber)->firstOrFail();
        $oldQuantity = $contenir->qteReservation;
        $produit = Produit::where('numProduit', $productNumber)->increment('qteStockDispoProduit', $oldQuantity);
        $contenir->delete();
        return back();
    }
}