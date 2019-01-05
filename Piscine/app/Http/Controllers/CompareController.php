<?php

namespace App\Http\Controllers;

use App\Produit;
use App\Client;
use Illuminate\Http\Request;
use Geocoder;

class CompareController extends Controller
{
    public function show()
    {
        $mailClient = Client::getMailClient();
        $id = Client::getIdClient();
        $coordinatesOfClient = Geocoder::getCoordinatesForAddress(Client::getMyAddress());

        if(!Client::product1isEmpty()){
            $numProduct1 = Client::getFirstProductToCompare();
            $product1 = Produit::productWithId($numProduct1);
            $product1->addDistance($coordinatesOfClient);
        }else{
            $product1 = null;
        }
        if(!Client::product2isEmpty()){
            $numProduct2 = Client::getSecondProductToCompare();
            $product2 = Produit::productWithId($numProduct2);
            $product2->addDistance($coordinatesOfClient);
        }else{
            $product2 = null;
        }
        $nbCompare = Client::calculNumberOfProductToCompare();





        return view('compare')->with(['product1' => $product1, 'product2' => $product2, 'mailClient' => $mailClient, 'id' => $id,'nbCompare' => $nbCompare]);
    }
    public function delete(){
        if (request('product')== 1){
            Client::deleteProduct1();
            return back();
        }
        else{
            Client::deleteProduct2();
            return back();
        }
    }

}
