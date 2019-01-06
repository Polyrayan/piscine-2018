@extends('navbars.navbarClient')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class = "col-lg-9 ">
                <h1> Commerce : {{ $shop->nomCommerce }} </h1>
                <h6> <b>Description : </b> {{$shop->libelleCommerce}}</h6>
                <h6> <b>Adresse :</b> {{$shop->adresseCommerce}} , {{$shop->codePostalCommerce}} , {{$shop->villeCommerce}} </h6>
                <h6> <b>Numéro de téléphone : </b><a href=""> {{$shop->telCommerce}} </a></h6>
                <h6> <b>Numéro de SIRET :</b> <a href=""> {{$shop->numSiretCommerce}} </a></h6>
            </div>
            <div class="col-lg-3">
                <h4> commerçants : </h4>
                @foreach($sellers as $seller)
                    <li> {{$seller->nomVendeur}} <a href="\Piscine\public\vendeur\{{$seller->idVendeur}}"> infos </a> </li>
                @endforeach

                <br>
                <div class="form-inline">
                    <h4> Horaires : </h4> <a href="{{url()->current()}}/horaires"> (éditer) </a> <br/>
                </div>
                @foreach($days as $day)
                    <li>
                        <strong>{{$day->nomJour}}</strong>
                        @if(($schedulesOfWork->where('nomJour', $day->nomJour))->count() > 0)
                            ouvert @foreach($schedulesOfWork->where('nomJour', $day->nomJour) as $scheduleOfWork)
                                de {{$scheduleOfWork->debut}} à {{$scheduleOfWork->fin}}
                            @endforeach
                        @else
                            fermé
                        @endif
                    </li>
                @endforeach
            </div>
        </div>
        <br>
    </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:45%">Produit</th>
                                <th style="width:10%"class="text-center">Couleur</th>
                                <th style="width:10%"class="text-center">Taille</th>
                                <th style="width:10%"class="text-center">Prix</th>
                                <th style="width:5%" class="text-center"> Quantité </th>
                                <th style="width:30%"></th>
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
                                            <div class="col-lg-3 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                            <div class="col-lg-9">
                                                <h4 class="nomargin"> <b>{{$product->nomProduit}} </b> </h4>
                                                <p>  {{$product->libelleProduit}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Color" class="text-center">{{$product->couleurProduit}}</td>
                                    <td data-th="Size"class="text-center">{{$product->tailleProduit}}</td>
                                    <td data-th="Price"class="text-center">{{$product->prixProduit}}€</td>
                                    <td data-th="Quantity"class="text-center">
                                        <input type="number" name="quantity" class="form-control text-center" value="1">
                                    </td>
                                    <td class="actions" data-th="">
                                        <button class="btn btn-success btn-group" name="book"> <i class="far fa-clock"></i> </button>
                                        <button class="btn btn-warning btn-group" name="addShoppingCart"> <i class="fas fa-cart-arrow-down"></i> </button>
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
                            <td><a href="#" class="btn btn-info"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <td></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="...">
                                        <a href="./../client/{{$id}}/reservations" class="btn btn-success"> <i class="fa fa-angle-left"></i> mes réservations </a>
                                        <a href="./../client/{{$id}}/panier" class="btn btn-warning"> mon panier <i class="fa fa-angle-right"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
    </div>

@endsection