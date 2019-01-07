<link href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<!-- Script provides the `snippet` object, see http://meta.stackexchange.com/a/242144/134069 -->
<script src="http://tjcrowder.github.io/simple-snippets-console/snippet.js"></script>

@extends('navbars.navbarSeller')

@section('content')
    <br>
    <h1> Les coupons du magasin {{$nomCommerce}} </h1>
    @if(!@isset($coupons))
        <br>
        <div class="alert alert-info text-center" role="alert">
            <strong> Aucun coupon pour le moment. </strong>
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
                    <form class ="action" method="POST">
                        {{  csrf_field()  }}
                        <tr>
                            <td data-th="Code Coupon" name="codeCoupon" id="codeCoupon">
                                <div class="row">
                                    <div class="col-sm-10 col-form-label">
                                        <input name="codeCoupon" type="hidden" value="{{ $coupon->codeCoupon}}">
                                        <h5 class="nomargin"><b>{{$coupon->codeCoupon}} </b></h5>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Description">
                                <div class="row">
                                    <div class="col-sm-10 col-form-label">
                                        <input  name="description" type="textarea" class="form-control" value="{{$coupon->description}}">
                                    </div>
                                </div>
                            </td>
                            <td data-th="Pour quels produit(s)?">
                                <div class="row">
                                    <div class="col-sm-10 col-form-label">
                                        <?php
                                        if($coupon->nomProduit) {
                                            $produit = $coupon->nomProduit;
                                        }
                                        else {
                                            $produit = $coupon->nomTypeProduit;
                                        }
                                        ?>

                                            <input type="text" class="form-control" name="produit" value="{{$produit}}">
                                    </div>
                                </div>
                            </td>

                            <td data-th="Valeur">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <?php
                                        if($coupon->valeur) {
                                            $valeur = $coupon->valeur . "€";
                                        }
                                        else {
                                            $valeur = $coupon->valeurPourcentage . "%";
                                        }
                                        ?>
                                            <input type="text" class="form-control" name="valeur" value="{{$valeur}}">
                                    </div>
                                </div>
                            </td>
                            <td data-th="Date limite">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <?php
                                        $idString = rand();
                                        ?>
                                        <input type="text" class="form-control" name="dateLimite2" id={{$idString}} value="{{$coupon->dateLimite}}">
                                        <script>
                                            $("#{{$idString}}").datepicker();
                                        </script>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Quantite maximale">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="qteMax" value="{{$coupon->quantiteMax}}">
                                    </div>
                                </div>
                            </td>
                            <td class="actions" data-th="">
                                <button type="submit" class="btn btn-info btn-sm" name="update"><i class="fas fa-redo-alt"></i></button>
                                <button type="submit" class="btn btn-danger btn-sm" name="delete"><i class="fas fa-times-circle"></i></button>
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

        <div class="form col-lg-4">
            <h3> Ajouter un coupon : </h3> <br>

            <form action="" method="post">
                {{  csrf_field()  }}
                <div class="form">
                    <!-- codeCoupon -->
                    <div class="row">
                        <label class="col-sm-4 col-form-label"> Code Coupon :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="codeCoupon" placeholder="Code Coupon *" value="{{ old('codeCoupon') }}">
                            @if ($errors->has('codeCoupon'))
                                <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('codeCoupon') }} </div> </small>
                            @endif
                        </div>


                        <!-- numSiret -->
                        <input name="numSiretCommerce" type="hidden" value="{{$numCommerce}}">

                        <!-- nomTypeProduit -->
                        <label class="col-sm-4 col-form-label"> Catégorie Produit :</label>
                        <div class="col-sm-8">

                            <select name="nomTypeProduit" class="form-control form-control-sm col-sm-12">
                                <option label=" "></option>
                                @foreach ($types as $type)
                                    <option value="{{$type}}"> {{$type}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('nomTypeProduit'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('nomTypeProduit') }} </div>  </small>
                            @endif

                        </div>

                        <!-- nomProduit -->
                        <label class="col-sm-4 col-form-label"> Nom Produit :</label>
                        <div class="col-sm-8">
                            <select type="text" class="form-control" name="nomProduit" >
                                <option label=" "></option>
                                @foreach ($nomsProduits as $nomProduit)
                                    <option value="{{$nomProduit}}"> {{$nomProduit}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- valeur -->
                        <label class="col-sm-4 col-form-label"> Valeur en euros :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="valeur" placeholder="valeur en euros *" value="{{ old('valeur') }}">
                            @if ($errors->has('valeur'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('valeur') }} </div>  </small>
                            @endif
                        </div>

                        <!-- valeurPourcentage -->
                        <label class="col-sm-4 col-form-label"> Valeur en pourcentage :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="valeurPourcentage" placeholder="valeur en % *" value="{{ old('valeurPorcentage') }}">
                            @if ($errors->has('valeur'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('valeurPourcentage') }} </div>  </small>
                            @endif
                        </div>

                        <!-- description-->
                        <label class="col-sm-4 col-form-label"> Description :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="description" rows="2" placeholder="description du coupon *" value="{{ old('description') }}"></textarea>
                            @if ($errors->has('description'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div>  </small>
                            @endif
                        </div>

                        <!-- dateLimite-->
                        <label class="col-sm-4 col-form-label"> Fin du periode du coupon :</label>
                        <div class="col-sm-8">

                            <input type="text" class="form-control" id = "dateLimite" name="dateLimite" placeholder="derniere jour de valabilite du coupon*">
                            <script>
                                $("#dateLimite").datepicker();
                            </script>
                            @if ($errors->has('dateLimite'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('dateLimite') }} </div>  </small>
                            @endif
                        </div>


                        <!-- quantiteMax-->
                        <label class="col-sm-4 col-form-label"> Quantite maximale des produits achetes avec un coupon :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="quantiteMax" rows="2" placeholder="quantite maximale *" value="{{ old('quantiteMax') }}"></textarea>
                            @if ($errors->has('quantiteMax'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('quantiteMax') }} </div>  </small>
                            @endif
                        </div>

                        <!-- button to add the coupon -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btnSubmit btn-primary" name="add"> Ajouter </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

@endsection