@extends('navbars.navbarClient')

@section('content')

    <h1> Mes réservations : </h1>
    @if(!@isset($reservations))
        <div class="alert alert-info text-center" role="alert">
            <strong> Vous n'avez aucune réservation ! </strong> Cliquez <a href="./../../" class="alert-link">ici</a> pour commencer à réserver des produits.
        </div>
    @endisset
    @isset($reservations)

            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:55%">Produit</th>
                            <th style="width:5%">Prix</th>
                            <th style="width:5%">Quantité</th>
                            <th style="width:15%" class="text-center">Temps restant</th>
                            <th style="width:12%" class="text-center">Sous total</th>
                            <th style="width:20% "class="text-center">Points gagnés</th>
                            <th style="width:4%"></th>
                        </tr>
                    </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            <form class ="input-group" method="POST">
                                {{  csrf_field()  }}
                                <input name="productNumber" type="hidden" value="{{ $reservation->numProduit }}">
                                <input name="reservationNumber" type="hidden" value="{{ $reservation->numReservation }}">

                                <tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                        <div class="col-sm-10">
                                    <h4 class="nomargin"><b>{{$reservation->nomProduit}} </b></h4>
                                    <p>{{$reservation->libelleProduit}}</p>
                            </div>
                                </div>
                            </td>
                                <td data-th="Price"><b>{{$reservation->prixProduit}}€</b></td>
                                <td data-th="Quantity">
                                 <input type="number" class="form-control text-center " name="quantity" value={{$reservation->qteReservation}}>
                                </td>
                                <td data-th="Time" class="text-center alert"><font color="red"><b> 2h </b> </font> </td>
                                <td data-th="Subtotal" class="text-center"><b>{{$reservation->prixProduit*$reservation->qteReservation}}€</b></td>
                                <td data-th="points" class="text-center"><b> livraison :  <font color="#DF3A01"> {{number_format($reservation->prixProduit*$reservation->qteReservation*0.10,1)}} </font>
                                        <br> magasin: <font color="green"> {{number_format($reservation->prixProduit*$reservation->qteReservation*0.15,1)}} </font> </b> </td>
                                <td class="actions form-inline" data-th="">

                            <button class="btn btn-info btn-sm" name="update"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-danger btn-sm" name="delete"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            </form>
                        </tbody>
                    @endforeach
                <tfoot>
                <tr class="visible-xs">
                    <td class="text-center"><strong>Total {{ $total }}€</strong></td>
                </tr>
                <tr>
                    <td><a href="./../../" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                    <td colspan="4  " class="hidden-xs"></td>
                    <td class="hidden-xs text-center"><strong> Total {{ $total }}€ </strong></td>

                    <td><a href="./panier" class="btn btn-info btn-block"> mon panier <i class="fa fa-angle-right"></i></a><a href="#" class="btn btn-success btn-block"> finaliser votre réservation  <i class="fa fa-angle-right"></i></a></td>
                </tr>
                </tfoot>
            </table>
        </div>

    @endisset
@endsection