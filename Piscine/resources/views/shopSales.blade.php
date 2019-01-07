@extends('navbars.navbarSeller')

@section('content')
    <br>
    <h1><u> Commandes en traitement du commerce {{ $shop->nomCommerce }} </u></h1>
    <div class="container-fluid">
        @if($ordersToTreat->count() <= 0 )
            <div class="container-fluid">
                <h4> Aucune commande à traiter pour le moment </h4>
            </div>
        @endif
    </div>
    @foreach($ordersToTreat as $orderToTreat)
        <div class="container-fluid">


            <div class="row">
        @if($ordersToDeliver->where('numCommande', $orderToTreat->numCommande)->count()>0)
                <div class="col-lg-5">
                  <h4> Produits à livrer : </h4>
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:5%"> n°</th>
                                <th style="width:10%">Produit</th>
                                <th class="text-center"  style="width:5%">Prix</th>
                                <th class="text-center"  style="width:5%">Quantité</th>
                                <th class="text-center"  style="width:30%">Adresse</th>
                                <th class="text-center"  style="width:30%">Réglé le </th>
                                <th class="text-center"  style="width:15%"> Etat  </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersToDeliver->where('numCommande', $orderToTreat->numCommande) as $order)
                                <tr>
                                    <td data-th="NumProduct"> {{ $order->numProduit}}</td>
                                    <td data-th="Product"> {{ $order->nomProduit}}</td>
                                    <td data-th="Price" class="text-center" ><b>{{$order->prixProduit}}€</b></td>
                                    <td data-th="Quantity" class="text-center"><b>{{$order->qteCommande}}</b></td>
                                    <td data-th="Address" class="text-center"><b>{{$order->adresseClient}} à {{$order->villeClient}}</b></td>
                                    <td data-th="Date" class="text-center"><b>{{ $orderToTreat->dateCommande }}</b></td>
                                    <td data-th="Date" class="text-center"><b><font color="#DF7401">En cours</font></b></td>

                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        @endif

        @if($onSiteOrders->where('numCommande', $orderToTreat->numCommande)->count()>0)
                        <div class="col-lg-5">
                            <h4> Produits qui seront récupérés :</h4>
                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                  <th style="width:5%"> n°</th>
                                  <th style="width:10%">Produit</th>
                                  <th class="text-center"  style="width:20%">Prix</th>
                                  <th class="text-center"  style="width:20%">Quantité</th>
                                  <th class="text-center"  style="width:20%">Réglé le </th>
                                  <th class="text-center"  style="width:30%">Etat</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($onSiteOrders->where('numCommande', $orderToTreat->numCommande) as $order)
                                        <tr>
                                          <td data-th="NumProduct"> {{ $order->numProduit}}</td>
                                          <td data-th="Product"> {{ $order->nomProduit}}</td>
                                          <td data-th="Price" class="text-center" ><b>{{$order->prixProduit}}€</b></td>
                                          <td data-th="Quantity" class="text-center"><b>{{$order->qteCommande}}</b></td>
                                          <td data-th="Date" class="text-center"><b>{{ $orderToTreat->dateCommande }}</b></td>
                                          <td data-th="Date" class="text-center"><b><font color="#DF7401">En cours</font></b></td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
        @endif
                <div class="col-lg-1">


                    @if($onSiteOrders->where('numCommande', $orderToTreat->numCommande)->count() >0 or $ordersToDeliver->where('numCommande', $orderToTreat->numCommande)->count()>0)
                    <br/><br/><br/><br/><br/>
                        <form class ="input-group" method="POST">
                            {{  csrf_field()  }}
                            <input name="orderNumber" type="hidden" value="{{ $order->numCommande }}">
                            <button type="submit" class="btn btn-info" name="finish"> Clôturer </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
        <br/>
        <h1><u> Commandes terminées du commerce {{ $shop->nomCommerce }} </u></h1>
        <div class="container-fluid">
            @foreach($completedOrders as $order)
                <h4> Commande n°{{$order->numCommande }} réglée le {{ $order->dateCommande }} (<font color="#04B404">Terminée</font>)</h4>
            @endforeach
            </div>
    <div class="container-fluid">
        @if($completedOrders->count() <= 0 )
            <div class="container-fluid">
                <h4> Aucune commande terminée pour le moment </h4>
            </div>
        @endif
    </div>

@endsection
