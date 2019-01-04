<?php

namespace App\Http\Controllers;

use App\Contenir;
use App\Commande;
use App\Detenir;
use App\TypeProduit;
use App\Produit;
use App\Panier;
use App\Reservation;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ReservationsConfirmedController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $id = Client::getIdClient();
        $client = Client::getClientWithId($id);
        $reservations = Reservation::bookingsOfThisMailClient($client->mailClient);

        foreach ($reservations as $reservation) {
            // Will do transformation here

            // getting the contenir instance
            $contenir = Contenir::getContenirWithReservationNumber($reservation->numReservation);

            // creating the commande
            //$panier = Panier::getPanierClient($client->mailClient);
            //if(!$panier){
            $panier = Panier::firstOrNewPanier($client->mailClient);
            $panier->save();
            //}
            //return $panier;
            $produit= Produit::productWithId($contenir->numProduit);
            //return $panier;
            if($panier[0]){
                $panier = $panier[0];
            }
            else {
                //return "Is not set";
            }
            //return $panier;
            $commande = Commande::newCommande($panier, $produit->numSiretCommerce);
            Commande::addPriceToThisOrder($commande, $produit->prixProduit, $contenir->qteReservation);
            $commande->save();

            // creating the detenir
            $detenir = Detenir::firstOrNewDetenir($commande, $produit->numProduit);
            $detenir->qteCommande = $contenir->qteReservation;
            $detenir->livrer = $produit->livraisonProduit;
            $detenir->save();


            // After this, I will have to delete the $contenir and its $reservation
            $contenir->delete();
            $reservation->delete();

        }

        return view('reservationsConfirmed')->with(['id' => $id]);

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