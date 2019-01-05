<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commerce;
use App\Contenir;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Reservation;

use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;
use Geocoder;


class testController extends Controller
{
    public function show()
    {

        $mailClient = Client::getMailClient(); // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        return view('welcome2', [ 'mailClient' => $mailClient]);
    }

    public function selectForm(Request $request)
    {
        if ($request->has('book')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0' ,'max:99999']
            ]);
            $reservation = Reservation::createReservation(request('mailClient'));
            Contenir::createContenir($reservation,request('product'),request('quantity'));
            Produit::decrementProduct(request('product'),request('quantity'));
            return back();

        } elseif ($request->has('addShoppingCart')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0']
            ]);
            $panier = Panier::firstOrNewPanier(request('mailClient'));
            Panier::addPriceToThisShoppingCart($panier,request('productPrice'),request('quantity'));

            $commande = Commande::firstOrNewCommande($panier,request('numSiret'));
            Commande::addPriceToThisOrder($commande,request('productPrice'),request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande,request('product'));
            Detenir::storeQuantity($detenir,request('quantity'));

            return back();
        }
    }

    function action(Request $request)
    {

        $allProducts = Produit::all();
        $coordinatesOfClients = Geocoder::getCoordinatesForAddress(Client::getMyAddress());

        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                // todo tester $products->where().. et mettre la variable $products au debut
                // todo et en remplacant $data par $products dans le else
                $data = Produit::where('nomProduit', 'like', '%'.$query.'%')
                    ->orWhere('libelleProduit', 'like', '%'.$query.'%')
                    ->orWhere('couleurProduit', 'like', '%'.$query.'%')
                    ->orWhere('tailleProduit', 'like', '%'.$query.'%')
                    ->orWhere('marqueProduit', 'like', '%'.$query.'%')
                    ->groupBy('numGroupeVariante')
                    ->get();

            }
            else
            {
                $data = Produit::productsGroupedByVariant();
            }

            foreach ($data as $product) {
                //distance
                $product->addDistance($coordinatesOfClients);
                //city
                $product->addCity();
                //colors
                $product->colors = $product->addColors($allProducts);
                //sizes
                $product->sizes = $product->addSizes($allProducts);
            }

            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $product)
                {
                    $output .='       
         <tr>
                    <form class ="input-group" method="POST">
                        <input type="hidden" name="mailClient" value="{{$mailClient}}">
                        {{  csrf_field()  }}
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 col-lg-3 col-md-3 hidden-xs">
                                    <?php  if(empty($product->imageProduit)){ 
                                        <img src="http://placehold.it/100x100" style="width:100px; height: 100px;" alt="..." class=" img img-thumbnail"/>
                                    }
                                    else{
                                        <img src="'.$product->imageProduit.'" style="width:  100px; height: 100px;" alt="..." class=" img-thumbnail"/>
                                    }
                                </div>
                                <div class="col-sm-8">
                                    <h4 class="nomargin"><b>'.$product->nomProduit.' </b></h4>
                                    <p>'.$product->libelleProduit.'</p>
                                </div>
                            </div>
                        </td>
                        <td  class="text-center">
                            <?php if(!empty($product->colors)){
                                <select name="color" class="form-control form-control-sm col-sm-12">
                                    $.each($product->colors as $color){
                                        <option value="{{$color}}"> {{$color}}</option>
                                    }
                                </select>
                            } ?>
                        </td>
                        <td  class="text-center">
                            @if(!empty($product->sizes))
                                <select name="size" class="form-control form-control-sm col-sm-12">
                                    @foreach($product->sizes as $size)
                                        <option value="{{$size}}"> {{$size}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td data-th="Quantity"  class="text-center">
                            <input type="number" name="quantity" class="form-control text-center" value= "1" >
                            <input name="product" type="hidden" value="{{ $product->numProduit }}">
                            <input name="productPrice" type="hidden" value="{{ $product->prixProduit }}">
                            <input name="numSiret" type="hidden" value="{{ $product->numSiretCommerce }}">
                        </td>
                        <td data-th="Price" class="text-center">'.$product->prixProduit.'€</td>
                        <td data-th="Distance"  class="text-center"> '.$product->distance.' km </td>
                        <td data-th="City"  class="text-center"> '.$product->city.'</td>
                        <td data-th="Actions">
                            <a href="./commerces/{{$product->numSiretCommerce}}" class="btn btn-info" role="button"> <i class="fas fa-home"></i> </a>
                            <button class="btn btn-warning btn-group" name="addShoppingCart"> <i class="fas fa-cart-arrow-down"></i> </button>
                            <button class="btn btn-success btn-group" name="book"> <i class="far fa-clock"></i> </button>
                        </td>
                    </form>
                </tr>
              
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
