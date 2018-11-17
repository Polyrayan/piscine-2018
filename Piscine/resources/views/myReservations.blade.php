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
                            <th style="width:40%">Produit</th>
                            <th style="width:10%">Prix</th>
                            <th style="width:8%">Quantité</th>
                            <th style="width:15%"class="text-center">Temps restant</th>
                            <th style="width:22%" class="text-center">Sous total</th>
                            <th style="width:15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $reservation)
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
                    <td data-th="Price">{{$reservation->prixProduit}}€</td>
                    <td data-th="Quantity">
                        <input type="number" class="form-control text-center" value={{$reservation->qteReservation}}>
                    </td>
                    <td data-th="Time" class="text-center"> 2h </td>
                    <td data-th="Subtotal" class="text-center">{{$reservation->prixProduit*$reservation->qteReservation}}€</td>
                    <td class="actions form-inline" data-th="">
                        <button class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
                </tbody>
                @endforeach
                <tfoot>
                <tr class="visible-xs">
                    <td class="text-center"><strong>Total 1.99</strong></td>
                </tr>
                <tr>
                    <td><a href="./../../" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="hidden-xs text-center"><strong>Total $1.99</strong></td>
                    <td><a href="#" class="btn btn-success btn-block">finaliser votre réservation  <i class="fa fa-angle-right"></i></a></td>
                </tr>
                </tfoot>
            </table>
        </div>

    @endisset
@endsection