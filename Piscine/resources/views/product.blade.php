@extends('navbars.navbarClient')

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
                        <p class="price">Prix unitaire : {{$product->prixProduit}} €</p>

                        <form action="" method="post" >
                          {{  csrf_field()  }}
                          @if(!empty($product->couleurProduit))
                            <div class="form-group">
                                <label for="colors">Color</label>
                                <select name="color" class="custom-select" id="colors">
                                    <option value="rien" selected>Choisissez une couleur</option>
                                    @foreach($product->colors as $color)
                                        <option value="{{$color}}"> {{$color}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if ($errors->has('color'))
                              <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('color') }} </div>  </small>
                            @endif
                            <div class="form-group">
                                <label>Quantity :</label>
                                <div class="input-group mb-3">

                                    <input type="text" class="form-control"  id="quantity" name="quantity" min="1" max="100" value="{{ old('quantity') }}">

                                </div>
                                @if ($errors->has('qte'))
                                  <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('qte') }} </div>  </small>
                                @endif
                            <input type="hidden" name="mailClient" value="{{$mailClient}}">
                            <input type="hidden" name="productPrice" value="{{$product->prixProduit}}">
                            <input type="hidden" name="productNumber" value="{{$product->numProduit}}">
                            <input name="numSiret" type="hidden" value="{{ $product->numSiretCommerce }}">


                            </div>
                            <button name="add" class="btn btn-success btn-lg btn-block text-uppercase">
                                <i class="fa fa-shopping-cart"></i> Ajouter au panier
                            </button>
                            <a class="pull-right" href="..\client\{{$id}}\panier">Voir mon panier</a>

                        </form>
                        <div class="product_rassurance">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-truck fa-2x"></i><br/>Livraison rapide</li>
                                <li class="list-inline-item"><i class="fa fa-credit-card fa-2x"></i><br/>Paiement sécurisé</li>
                                <li class="list-inline-item"><i class="fa fa-phone fa-2x"></i><br/><a class="nomargin" href="">{{$commerce->telCommerce}}</a></li>
                            </ul>
                        </div>
                        <div class="reviews_product p-3 mb-2 ">
                            @if($noteMoy >= 2)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($noteMoy>=4)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($noteMoy>=6)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($noteMoy>=8)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($noteMoy == 10)
                                <i class="fa fa-star"></i>
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

            <!-- Reviews -->
            <div class="col-12" id="reviews">
                <div class="card border-light mb-3">
                    <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-comment"></i> AVIS</div>
                    <div class="card-body">
                        @foreach($avis as $_avis)
                        <div class="review">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            <meta itemprop="datePublished" content="01-01-2016"> le {{$_avis->dateAvis}}

                            @if($_avis->noteAvis >= 2)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($_avis->noteAvis>=4)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($_avis->noteAvis>=6)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($_avis->noteAvis>=8)
                                <i class="fa fa-star"></i>
                            @endif
                            @if($_avis->noteAvis == 10)
                                <i class="fa fa-star"></i>
                            @endif
                            note : {{$_avis->noteAvis}}/10
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
