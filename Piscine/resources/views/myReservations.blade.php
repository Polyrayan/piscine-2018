@extends('navbars.navbarClient')

@section('content')
    <br>
    <h1> Mes réservations : </h1>
    @if(!@isset($reservations))
        <div class="alert alert-info text-center" role="alert">
            <strong> Vous n'avez aucune réservation ! </strong> Cliquez <a href="./../../" class="alert-link">ici</a> pour commencer à réserver des produits.
        </div>
    @endisset
    @isset($reservations)

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                        <table  class="table  table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:30%">Produit</th>
                                    <th style="width:5%" class="text-center">Couleur</th>
                                    <th style="width:10%" class="text-center">Taille</th>
                                    <th style="width:5%" class="text-center">Prix</th>
                                    <th style="width:5%" class="text-center">Quantité</th>
                                    <th style="width:10%" class="text-center">Temps restant</th>
                                    <th style="width:10%" class="text-center">Sous total</th>
                                    <th style="width:10% "class="text-center">Points gagnés</th>
                                    <th style="width:25%"></th>
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
                                                    <div class="col-lg-5 col-md-8 col-sm-6 col-xs-8 ">
                                                        @if(empty($reservation->imageProduit))
                                                            <a class="nomargin" href="./produits/{{$reservation->numProduit}}"><img class="d-block w-100" src="http://placehold.it/100x100" alt="Les meilleurs avis"></a>A
                                                        @else
                                                            <a class="nomargin" href="./produits/{{$reservation->numProduit}}"><img class="d-block w-100" src="{{$reservation->imageProduit}}" alt="Les meilleurs avis"></a>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-7 col-md-8 col-sm-6 col-xs-8">
                                                <h4 class="nomargin"><b>{{$reservation->nomProduit}} </b></h4>
                                                <p>{{$reservation->libelleProduit}}</p>
                                                </div>
                                            </div>
                                            </td>
                                            <td data-th="Color" class="text-center"> {{ $reservation->couleurProduit }} </td>
                                            <td data-th="Size" class="text-center"> {{ $reservation->tailleProduit }}</td>
                                            <td data-th="Price" class="text-center"><b>{{$reservation->prixProduit}}€</b></td>
                                            <td data-th="Quantity" class="text-center">
                                                <input type="number" class="form-control text-center " name="quantity" value={{$reservation->qteReservation}}>
                                            </td>
                                            <td class="text-center alert text-center" id=timery>

                                            <?php $rnd = rand();
                                            $strrnd = (string)$rnd;
                                            ?>
                                            <p id = {{$strrnd}}>
                                                <script> makeCounter("{{$rnd}}", "{{ $reservation->dateReservation }}" , "{{ $reservation->timeLeft }}" ) </script>
                                            </p>
                                            </td>
                                            <td data-th="Subtotal" class="text-center"><b>{{$reservation->prixProduit*$reservation->qteReservation}}€</b></td>
                                            <td data-th="points" class="text-center"><b> livraison :  <font color="#DF3A01"> {{number_format($reservation->prixProduit*$reservation->qteReservation*0.10,1)}} </font>
                                                    <br> magasin: <font color="green"> {{number_format($reservation->prixProduit*$reservation->qteReservation*0.15,1)}} </font> </b> </td>
                                            <td class="actions" data-th="">
                                                <button class="btn btn-info btn-sm" name="update" title="Actualiser la réservation"><i class="fas fa-redo-alt"></i></button>
                                                <button class="btn btn-danger btn-sm" name="delete" title="Supprimer cette réservation"><i class="fas fa-times-circle"></i></button>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td><a href="./../../" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                                    <td></td>
                                    <td></td>
                                    <td class=" text-center"><strong> Total {{ $total }}€ </strong></td>
                                    <td colspan="1  " class="hidden-xs"></td>
                                    <td></td>
                                    <td><a href="./panier" class="btn btn-info btn-block"> Mon panier </a></td>
                                    <td><a href="./reservationsConfirmed" class="btn btn-success btn-block"> Finaliser votre réservation  <i class="fa fa-angle-right"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
        </div>

    @endisset
@endsection
