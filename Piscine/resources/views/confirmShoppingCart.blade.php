@extends('navbars.navbarClient')

@stack('confirmation.css')
@section('content')
    <!--case 1  -->

    @if(@isset($deliverablesProducts) and @isset($undeliverablesProducts))
        <br> <h2> Choisissez comment récupérer vos produits : </h2></br>
        <form id="final"  method="POST">
            {{  csrf_field()  }}
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th style="width:30%">Produitsssssssssss</th>
                            <th style="width:5%">Couleur</th>
                            <th style="width:5%">Taille</th>
                            <th style="width:5%">Prix</th>
                            <th style="width:5%">Quantité</th>
                            <th style="width:15%" class="text-center">Sous total</th>
                            <th style="width:20% "class="text-center">Points gagnés</th>
                            <th style="width:10%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deliverablesProducts as $product)
                                <input name="productNumber[]" type="hidden" value="{{ $product->numProduit }}">
                                <input name="orderNumber[]" type="hidden" value="{{ $product->numCommande }}">
                                <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                                <input name="price" type="hidden" value="{{ $product->prixProduit }}">
                                <input name="quantity[]" type="hidden" value="{{$product->qteCommande}}">
                                <input name="subTotal[]" type="hidden" value="{{$product->prixProduit*$product->qteCommande}}">

                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                            <div class="col-sm-8">
                                                <h4><b>{{$product->nomProduit}} </b></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Color" class="text-center"> <b>{{$product->couleurProduit}}</b> </td>
                                    <td data-th="Size" class="text-center"> <b>{{$product->tailleProduit}}</b> </td>
                                    <td data-th="Quantity" class="text-center"><b>{{$product->qteCommande}}</b></td>
                                    <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                                    <td data-th="points" class="text-center"><b> Livraison :  <font color="#DF3A01"> {{number_format($product->prixProduit*$product->qteCommande*0.10,1)}} </font>
                                            <br> Magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>
                                    <td  class="form-check">
                                            <input name="productToDeliver[]" type="checkbox" id="{{$product->numProduit}}" value="{{$product->numProduit}}">
                                            <label class="form-check-label" for="{{$product->numProduit}}" title="Se faire livrer">
                                                <i class="btn btn-success fa fa-shipping-fast"></i>
                                            </label>
                                    </td>
                                </tr>
                                @endforeach

                        @foreach($undeliverablesProducts as $product)
                                <input name="productNumber[]" type="hidden" value="{{ $product->numProduit }}">
                                <input name="orderNumber[]" type="hidden" value="{{ $product->numCommande }}">
                                <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                                <input name="price" type="hidden" value="{{ $product->prixProduit }}">
                                <input name="quantity[]" type="hidden" value="{{$product->qteCommande}}">
                                <input name="subTotal[]" type="hidden" value="{{$product->prixProduit*$product->qteCommande}}">
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                            <div class="col-sm-8">
                                                <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Color" class="text-center"> <b>{{$product->couleurProduit}}</b> </td>
                                    <td data-th="Size" class="text-center"> <b>{{$product->tailleProduit}}</b> </td>
                                    <td data-th="Price" class="text-center" ><b>{{$product->prixProduit}}€</b></td>
                                    <td data-th="Quantity" class="text-center"><b>{{$product->qteCommande}}</b></td>
                                    <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                                    <td data-th="points" class="text-center"><b> Magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>

                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                        <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                        <input name="total" type="hidden" value="{{ $total }}">

                        <div class="text-center">
                            <h3->Validez votre commande : </h3->
                        </div>
                        <div class="text-center">
                            <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">
                            <input name="undeliverablesProducts" type="hidden" value="{{ $undeliverablesProducts }}">
                            @if(!$appliedCoupon)
                                <input name="codeCoupon" class="text-center" placeholder="Codeee réduction">
                                <button  type="submit" class="btn btn-info btn-sm" name="code" >valider</button></div>
                    @if($errors->has('codeCoupon'))
                        <small><div class="alert alert-danger" role="alert"> {{$errors->first('codeCoupon')}}</div></small>
                    @endif
                    @endif
                        <div class="text-center">
                            </br>
                            <strong>Total {{ $total }}€ </strong>
                            <p> dont TVA :{{ $total*0.2 }}€ </p>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-info btn-sm"  name="noDelivery">Tout récupérer</button>
                            <button type="submit" class="btn btn-success btn-sm" name="selectedDelivery">Livrer ceux sélectionnés </button>
                            <button type="submit" class="btn btn-info btn-sm" name="deliveryMax">Se faire livrer le maximum</button>
                        </div>
                </div>
            </div>
        </div>
        </form>
        <!--case 2  -->
    @elseif(@isset($productCase2))
        <br> <h2> Choisissez comment récupérer vos produits :</h2>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th style="width:30%">Produit</th>
                            <th style="width:5%">Couleur</th>
                            <th style="width:5%">Taille</th>
                            <th style="width:5%">Prix</th>
                            <th style="width:5%">Quantité</th>
                            <th style="width:15%" class="text-center">Sous total</th>
                            <th style="width:20% "class="text-center">Points gagnés</th>
                            <th style="width:10%"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($productCase2 as $product)
                            <form class ="input-group" method="POST">
                                {{  csrf_field()  }}
                                <input name="productNumber" type="hidden" value="{{ $product->numProduit }}">
                                <input name="orderNumber" type="hidden" value="{{ $product->numCommande }}">
                                <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                                    <input name="price" type="hidden" value="{{ $product->prixProduit }}">
                                <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">
                                <input name="undeliverablesProducts" type="hidden" value="{{ $undeliverablesProducts }}">

                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                            <div class="col-sm-8">
                                                <h4><b>{{$product->nomProduit}} </b></h4>
                                                <p> {{$product->libelleProduit}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Color" class="text-center"> <b>{{$product->couleurProduit}}</b> </td>
                                    <td data-th="Size" class="text-center"> <b>{{$product->tailleProduit}}</b> </td>
                                    <td data-th="Price" class="text-center" ><b>{{$product->prixProduit}}€</b></td>
                                    <td data-th="Quantity" class="text-center"><b>{{$product->qteCommande}}</b></td>
                                    <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                                    <td data-th="points" class="text-center"><b> Livraison :  <font color="#DF3A01"> {{number_format($product->prixProduit*$product->qteCommande*0.10,1)}} </font>
                                            <br> Magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>
                                    <td>
                                        <input  type="checkbox" value="{{$product->numProduit}}" id="{{$product->numProduit}}">
                                        <label class="form-check-label" for="{{$product->numProduit}}">
                                            <i class="btn btn-success fa fa-shipping-fast"></i>
                                        </label>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                    <form method="POST">
                        {{  csrf_field()  }}
                        <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                        <input name="total" type="hidden" value="{{ $total }}">
                        <div class="text-center">
                            <h3>Validez votre commande : </h3>
                        </div>
                        <div class="text-center">
                            <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">
                            <input name="undeliverablesProducts" type="hidden" value="{{ $undeliverablesProducts }}">
                            @if(!$appliedCoupon)
                                <input name="codeCoupon" class="text-center" placeholder="Codeee réduction">
                                <button  type="submit" class="btn btn-info btn-sm" name="code" >valider</button></div>
                        @if($errors->has('codeCoupon'))
                            <small><div class="alert alert-danger" role="alert"> {{$errors->first('codeCoupon')}}</div></small>
                    @endif
                    @endif
                        </div>
                        <div class="text-center">
                            <strong>Total {{ $total }}€ </strong>
                            <p> dont TVA :{{ $total*0.2 }}€ </p>
                        </div>
                        <div class="btn-group">
                            <button  type="submit" class="btn btn-info btn-sm"  name="noDelivery">Tout récupérer</button>
                            <button type="submit" class="btn btn-success btn-sm" name="selectedDelivery">Livrer ceux sélectionnés </button>
                            <button type="submit" class="btn btn-info btn-sm" name="deliverAll">Tout se faire livrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--case 3  -->
    @elseif(@isset($productCase3))
            <br> <h2> Choisissez comment récupérer vos produits :</h2>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Produit</th>
                                <th style="width:5%">Couleur</th>
                                <th style="width:5%">Taille</th>
                                <th style="width:5%">Prix</th>
                                <th style="width:5%">Quantité</th>
                                <th style="width:15%" class="text-center">Sous total</th>
                                <th style="width:24% "class="text-center">Points gagnés</th>
                                <th style="width:20%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productCase3 as $product)
                                <form class ="input-group" method="POST">
                                    {{  csrf_field()  }}
                                    <input name="productNumber" type="hidden" value="{{ $product->numProduit }}">
                                    <input name="orderNumber" type="hidden" value="{{ $product->numCommande }}">
                                    <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                                    <input name="price" type="hidden" value="{{ $product->prixProduit }}">
                                    <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">
                                    <input name="undeliverablesProducts" type="hidden" value="{{ $undeliverablesProducts }}">

                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                                <div class="col-sm-8">
                                                    <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                                    <p>{{$product->libelleProduit}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Color" class="text-center"> <b>{{$product->couleurProduit}}</b> </td>
                                        <td data-th="Size" class="text-center"> <b>{{$product->tailleProduit}}</b> </td>
                                        <td data-th="Price" class="text-center" ><b>{{$product->prixProduit}}€</b></td>
                                        <td data-th="Quantity"class="text-center"><b>{{$product->qteCommande}}</b></td>
                                        <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                                        <td data-th="points" class="text-center"><b> Magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>

                                    </tr>
                                </form>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-3">
                        <form method="POST">


                            {{  csrf_field()  }}
                            <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                            <input name="total" type="hidden" value="{{ $total }}">
                            <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">

                            <div class="text-center">
                                <h3>Validez votre commande : </h3>
                            </div>
                            <div class="text-center">
                                <input name="deliverablesProducts" type="hidden" value="{{ $deliverablesProducts }}">
                                <input name="undeliverablesProducts" type="hidden" value="{{ $undeliverablesProducts }}">
                                @if(!$appliedCoupon)
                                    <input name="codeCoupon" class="text-center" placeholder="Codeee réduction">
                                    <button  type="submit" class="btn btn-info btn-sm" name="code" >valider</button></div>
                                    @if($errors->has('codeCoupon'))
                                    <small><div class="alert alert-danger" role="alert"> {{$errors->first('codeCoupon')}}</div></small>
                                    @endif
                                @endif
                            </div>
                            <div class="text-center">
                                <strong>Total {{ $total }}€ </strong>
                                <p> dont TVA :{{ $total*0.2 }}€ </p>
                            </div>
                                <div class="btn-group">
                                <button  type="button" class="btn btn-info btn-sm"  name="noDelivery">Tout récupérer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    @endif
@endsection
