@extends('navbars.navbar' . $clientConnected)

@section('content')
    <br>

    <h1>Fiche du produit n°{{$product->numProduit}}</h1>
    <div class="container">
        <div class="row">
            <!-- Image -->
            <div class="col-12 col-lg-6">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <center>
                            <a href="" data-toggle="modal" data-target="#productModal">
                                @if(empty($product->imageProduit))
                                    <img src="http://placehold.it/100x100" style="width:410px; height: 410px;" alt="..." class=" img img-thumbnail"/>
                                @else
                                    <img class="img-fluid" src="{{$product->imageProduit}}" style="width:410px; height: 410px;"/>
                                @endif
                            </a>
                            <h3 class="nom" >{{$product->nomProduit}}</h3>
                        </center>
                    </div>
                </div>
            </div>

            <!-- Add to cart -->
            <div class="col-12 col-lg-6 add_to_cart_block">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <b>Prix unitaire : {{$product->prixProduit}} €</b>
                        <form action="" method="post" >
                            {{  csrf_field()  }}
                            <div class="form-group">
                                    @if($productsOfCategory->count() > 1)
                                    <label for="colors">Variantes : </label>
                                    <select name="variant" class="custom-select" id="colors">
                                        <option selected>Choisissez une variante</option>
                                        @foreach($productsOfCategory as $prod)
                                            <option value="{{$prod->numProduit}}"> {{$prod->couleurProduit}} {{$prod->tailleProduit}}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <input name="variant" type="hidden" value="{{ $product->numProduit }}">
                                    @endif
                            </div>
                            @if ($errors->has('variant'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('variant') }} </div>  </small>
                            @endif
                            <div class="form-group">
                                <label>Quantité :</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"  id="quantity" name="quantity" min="1" max="100" value="1">
                                </div>
                                @if ($errors->has('qte'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('qte') }} </div>  </small>
                                @endif

                            </div>
                            @if($clientConnected == "Client")
                            <div class="row">
                                <div class="col-lg-12 btn-group">
                                    <button name="add" class="btn btn-success btn-lg btn-block text-uppercase">
                                        <i class="fa fa-shopping-cart"></i> Ajouter au panier
                                    </button>
                                </div>
                            </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12 btn-group">
                                        <span class="btn btn-success btn-lg btn-block text-uppercase">
                                            <i class="fa fa-shopping-cart"></i> Ajouter au panier
                                        </span>
                                    </div>
                                </div>
                            @endif

                        </form>
                        <div class="product_rassurance">
                            <ul class="list-inline">
                                <div class="text-center">
                                    <li class="list-inline-item"><i class="fa fa-truck fa-2x"></i><br/>Livraison rapide</li>
                                    <li class="list-inline-item"><i class="fa fa-credit-card fa-2x"></i><br/>Paiement sécurisé</li>
                                    <li class="list-inline-item"><i class="fa fa-phone fa-2x"></i><br/><a class="nomargin" href=""> {{$commerce->telCommerce}} </a></li>
                                </div>

                            </ul>
                        </div>
                        <br>
                        <div class="" >
                                    @if($noteMoy >= 2)
                                        <i class="fa fa-star"></i>
                                    @elseif($noteMoy >= 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif

                                    @if($noteMoy >= 4)
                                        <i class="fa fa-star"></i>
                                    @elseif($noteMoy>=3)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif

                                    @if($noteMoy >= 6)
                                        <i class="fa fa-star"></i>
                                    @elseif($noteMoy>=5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif

                                    @if($noteMoy >= 8)
                                        <i class="fa fa-star"></i>
                                    @elseif($noteMoy>=7)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif

                                    @if($noteMoy == 10)
                                        <i class="fa fa-star"></i>
                                    @elseif($noteMoy>=9)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif


                            @if($noteMoy == "Non noté")
                                <a> {{$noteMoy}}</a>
                            @else
                                <a> {{$noteMoy}}/10</a>
                            @endif
                            <a class="pull-right" href="#reviews">Voir tous les avis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Description -->
            <div class="col-12">
                <div class="card border-light mb-3">
                    <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i> Description</div>
                    <div class="card-body">
                        <p class="card-text">
                            {{$product->libelleProduit}}
                        </p>
                    </div>
                </div>
            </div>
        @if($clientConnected == "Client")
            <!-- Suggestions -->
                <div class="col-12">
                    <div class="card border-light mb-3">
                        <div class="card-header bg-primary text-white text-uppercase"><i class="far fa-clone"></i> Produits pouvant vous intéresser </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <?php
                                    $i=0;
                                    while ($i<sizeof($suggestions) && $i<3) {
                                        echo '<td>';
                                        echo '  <center>';
                                        echo '    <a href="" data-toggle="modal" data-target="#productModal">';
                                        if(empty($suggestions[$i]->imageProduit)) {
                                            echo '      <img src="http://placehold.it/100x100" style="width:200px; height: 200px;" alt="..." class=" img img-thumbnail"/>';
                                        }
                                        else {
                                            echo '      <img class="img-fluid" src=',$suggestions[$i]->imageProduit,' style="width:200px; height: 200px;"/>';
                                        }
                                        echo '      <h3 class="nom" >',$suggestions[$i]->nomProduit,'</h3>';
                                        echo '   </a>';
                                        echo ' </center>';
                                        echo '</td>';
                                        $i+=1;
                                    }
                                    ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        @endif

            <!-- Reviews -->
            <div class="col-12" id="reviews">
                <div class="card border-light mb-3">
                    <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-comment"></i> AVIS</div>
                    <div class="card-body">
                        @foreach($avis as $_avis)
                            <div class="review">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                <meta itemprop="datePublished" content="01-01-2016"> le {{$_avis->dateAvis}}
                                <div class="row">
                                    <div class="col-lg-10 ">
                                        @if($noteMoy >= 2)
                                            <i class="fa fa-star"></i>
                                        @elseif($noteMoy >= 1)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @if($noteMoy >= 4)
                                            <i class="fa fa-star"></i>
                                        @elseif($noteMoy>=3)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @if($noteMoy >= 6)
                                            <i class="fa fa-star"></i>
                                        @elseif($noteMoy>=5)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @if($noteMoy >= 8)
                                            <i class="fa fa-star"></i>
                                        @elseif($noteMoy>=7)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @if($noteMoy == 10)
                                            <i class="fa fa-star"></i>
                                        @elseif($noteMoy>=9)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        note : {{$_avis->noteAvis}}/10
                                    </div>
                                    <div class="col-lg-2">
                                        @if(isset($adminConnected))
                                            @if($adminConnected)
                                                <form method="POST">
                                                    {{  csrf_field()  }}
                                                <input name="numberReview" type="hidden" value="{{ $_avis->numAvis }}">
                                                <button class="btn btn-warning btn-group" name="deleteReview"> supprimer </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <p class="blockquote">
                                <p class="mb-0"> {{$_avis->commentaireAvis}}</p>
                                </p>
                                <hr>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>

    </div>


    <!-- Modal image -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" src="https://dummyimage.com/1200x1200/55595c/fff" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
