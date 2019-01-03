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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

        $client = Client::getClientWithId($id);
        $reservations = Reservation::bookingsOfThisMailClient($client->mailClient);
        foreach ($reservations as $reservation) {
            $numProduit = Contenir::getNumeroProduit($reservation->numReservation);
            $nomTypeProduit = Produit::getTypeProduit($numProduit);
            $timeLeft = TypeProduit::getReservationTime($nomTypeProduit);
            $reservation['timeLeft'] = $timeLeft;     
        }

        $sum = Reservation::where('mailClient', $client->mailClient)
            ->join('contenir', 'contenir.numReservation', '=', 'reservations.numReservation')
            ->join('produits', 'contenir.numProduit', '=', 'produits.numProduit')
            ->select(DB::raw('sum(produits.prixProduit * contenir.qteReservation) as total'))->first();

        if ($reservations->isEmpty()) {
            return view('myReservations');
        }
        else {
            $total = $sum->total;
            return view('myReservations')->with(['reservations' => $reservations, 'total' => $total, 'timeLeft' => $timeLeft]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectForm(Request $request)
    {
        // view sellerShops

        if ($request->has('update')) {
            return $this->updateQuantity(request('reservationNumber'),request('productNumber'),request('quantity'));

        } elseif ($request->has('delete')) {
            return $this->deleteQuantity(request('reservationNumber'),request('productNumber'));
        }
    }

    /**
     * @param $reservationNumber
     * @param $productNumber
     * @param $newQuantity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuantity($reservationNumber, $productNumber, $newQuantity)
    {
        $contenir = Contenir::getContenirWithReservationNumber($reservationNumber);
        $oldQuantity = $contenir->qteReservation;
        $produit = Produit::productWithId($productNumber);
        if ($newQuantity > $oldQuantity){ // we are losing more products
            $produit->qteStockDispoProduit -= ($newQuantity - $oldQuantity);
        }else{ // we recover products
            $produit->qteStockDispoProduit +=  $oldQuantity - $newQuantity;
        }
        $produit->save();
        Contenir::updateQuantityContenir($reservationNumber,$newQuantity);
        return back();
    }

    /**
     * @param $reservationNumber
     * @param $productNumber
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteQuantity($reservationNumber, $productNumber){
        $contenir = Contenir::getContenirWithReservationNumber($reservationNumber);
        $oldQuantity = $contenir->qteReservation;
        Produit::where('numProduit', $productNumber)->increment('qteStockDispoProduit', $oldQuantity);
        $contenir->delete();
        return back();
    }
}