@extends('navbars.navbar')

@section('content')



    <h1> Commerce : {{ $shop->nomCommerce }} </h1>
    <div class = "text-right col-lg-11 ">
        <h4> commerçants : </h4>
    @foreach($sellers as $seller)
            <li> {{$seller->nomVendeur}} <a href="\Piscine\public\vendeur\{{$seller->idVendeur}}"> infos </a> </li>
        @endforeach
    </div>


        <div class="container">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:45%">Produit</th>
                        <th style="width:10%">Prix</th>
                        <th style="width:8%"> Quantité </th>
                        <th style="width:17%" class="text-center">Sous-total</th>
                        <th style="width:20%"></th>
                    </tr>
                </thead>
                @foreach($products as $product)
                <tbody>
                    <tr>
                        <form class ="input-group" style="display: inline-block" method="POST">
                            {{  csrf_field()  }}
                            <input name="product" type="hidden" value="{{ $product->numProduit }}">
                            <input name="mailClient" type="hidden" value="{{ $mailClient }}">
                            <input name="numSiret" type="hidden" value="{{ $numSiret }}">
                            <input name="productPrice" type="hidden" value="{{ $product->prixProduit }}">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                    <div class="col-sm-10">
                                        <h4 class="nomargin"> <b>{{$product->nomProduit}} </b> </h4>
                                        <p>  {{$product->libelleProduit}}</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">{{$product->prixProduit}}</td>
                            <td data-th="Quantity">
                                <input type="number" name="quantity" class="form-control text-center" value="1">
                            </td>
                            <td data-th="Subtotal" class="text-center"> {{$product->prixProduit*1}} </td>
                            <td class="actions" data-th="">
                                <button class="btn btn-success btn-group" name="book"> réserver </button>
                                <button class="btn btn-warning btn-group" name="addShoppingCart"> ajouter au panier </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
                @endforeach
                <tfoot>
                <tr class="visible-xs">
                    <td class="text-center"><strong></strong></td>
                </tr>
                <tr>
                    <td><a href="#" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="hidden-xs text-center"><strong></strong></td>
                    <td><a href="./../client/{{$idClient}}/reservations" class="btn btn-success btn-block">mes réservations <i class="fa fa-angle-right"></i></a></td>
                </tr>
                </tfoot>
            </table>
    </div>

@endsection