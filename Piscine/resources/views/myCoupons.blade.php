@extends('navbars.navbarSeller')

@section('content')
    <br>
    <h1> Les coupons du magasin {{$nomCommerce}} </h1>
    @if(!@isset($coupons))
        <br>
        <div class="alert alert-info text-center" role="alert">
            <strong> Aucun coupon pour le moment, réessayez plus tard. </strong>
        </div>
    @endisset
    @isset($coupons)

        <div class="container">
            <table style="width:100%;" id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:15%;">Code Coupon</th>
                    <th style="width:30%;">Description</th>
                    <th style="width:20%;">Pour quels produit(s)?</th>
                    <th style="width:10%;" >Valeur</th>
                    <th style="width:15%;" >Date limite</th>
                    <th style="width:10%;" >Quantite maximale</th>
                </tr>
                </thead>
                <tbody>
                @foreach($coupons as $coupon)
                    <form class ="input-group" method="POST">
                        {{  csrf_field()  }}

                        <tr>

                            <td data-th="Code Coupon">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h5 class="nomargin"><b>{{$coupon->codeCoupon}} </b></h5>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Description">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h5 class="nomargin"><b>{{$coupon->description}} </b></h5>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Pour quels produit(s)?">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <?php
                                        if($coupon->numProduit) {
                                            $produit = $coupon->numProduit;
                                        }
                                        else {
                                            $produit = $coupon->nomTypeProduit;
                                        }
                                        ?>
                                        <h5 class="nomargin"><b>{{$produit}} </b></h5>
                                    </div>
                                </div>
                            </td>

                            <td data-th="Valeur">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <?php
                                        if($coupon->valeur) {
                                            $valeur = $coupon->valeur;
                                        }
                                        else {
                                            $valeur = $coupon->valeurPourcentage . "%";
                                        }
                                        ?>
                                        <h5 class=text-center"><b>{{$valeur}} </b></h5>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Date limite">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h5 class="nomargin"><b>{{$coupon->dateLimite}} </b></h5>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Quantite maximale">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h5 class="nomargin"><b>{{$coupon->quantiteMax}} </b></h5>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </form>
                </tbody>
                @endforeach
                <tfoot>
                </tfoot>
            </table>
        </div>
    @endisset
@endsection