@extends('navbars.navbarSeller')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class = "col-lg-3 ">
                <h1> Variantes </h1>
            </div>
        </div>
    </div>
         <br>

    <div class="container-fluid">
        <div class="row">
            <div class = "col-lg-8 ">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><h3> Liste des produits </h3></th>
                        </tr>
                        <tr>
                            <th style="width:30%">Produit</th>
                            <th style="width:10%">Stock</th>
                            <th style="width:5%">Stock réservé </th>
                            <th style="width:10%">Prix </th>
                            <th style="width:5%">Couleur </th>
                            <th style="width:5%">Taille </th>
                            <th style="width:20%"></th>
                        </tr>
                    </thead>
                    @foreach($products as $product)
                        <tbody>
                        <tr>
                            <form class ="input-group" method="POST">
                                {{  csrf_field()  }}
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                        <div class="col-sm-8">
                                            <h4 class="nomargin"> <b>{{$product->nomProduit}} </b> </h4>
                                            <p>  {{$product->libelleProduit}}</p>
                                        </div>
                                    </div>
                                </td>

                                <td><input type="number" name="quantity" class="form-control text-center" value={{$product->qteStockProduit}} ></td>
                                <td> {{($product->qteStockProduit)-($product->qteStockDispoProduit)}} </td>
                                <td><input type="number" name="price" class="form-control text-center" value= {{$product->prixProduit}} ></td>
                                <td> {{$product->couleurProduit}} </td>
                                <td> {{$product->tailleProduit}} </td>

                                <td class="actions" data-th="">
                                    <input name="variant" type="hidden" value="{{ $product->numProduit }}">

                                    <button class="btn btn-warning btn-group" name="edit"> <i class="fas fa-edit"></i> </button>
                                    <button class="btn btn-danger btn-group" name="delete"> <i class="fas fa-times-circle"></i> </button>
                                </td>
                            </form>
                        </tr>
                        </tbody>
                        @endforeach
                </table>
            </div>

            <div class="form col-lg-4">
                <h3> Ajouter une variante : </h3> <br>

                <form action="" method="post">
                    {{  csrf_field()  }}
                    <div class="form">
                        <div class="row">
                            <!-- type of product -->
                            <label class="col-sm-4 col-form-label"> catégorie :</label>
                            <div class="col-sm-8">
                                {{$category}}
                            </div>

                            <!-- numSiret -->
                            <input name="nomType" type="hidden" value="{{$category}}">
                            <input name="productName" type="hidden" value="{{$exemple->nomProduit}}">
                            <input name="description" type="hidden" value="{{$exemple->libelleProduit}}">
                            <input name="numSiretCommerce" type="hidden" value="{{$exemple->numSiretCommerce}}">
                            <input name="delivery" type="hidden" value="{{$exemple->livraisonProduit}}">
                            <input name="price" type="hidden" value="{{$exemple->prixProduit}}">
                            <input name="brand" type="hidden" value="{{$exemple->marqueProduit}}">
                            <input name="variantNumber" type="hidden" value="{{$exemple->numGroupeVariante}}">

                            <!-- stock -->
                            <label class="col-sm-4 col-form-label"> quantité en stock :</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="stock" placeholder="quantité en stock *" value={{$exemple->qteStockProduit}}>
                                @if ($errors->has('stock'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('stock') }} </div>  </small>
                                @endif
                            </div>

                            <!-- color -->
                            <label class="col-sm-4 col-form-label">Couleur :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="color" placeholder="couleur principale du produit (option)" value="{{ old('color') }}">
                                @if ($errors->has('color'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('color') }} </div>  </small>
                                @endif
                            </div>

                            <!-- size -->
                            <label class="col-sm-4 col-form-label">Taille :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="size" placeholder="taille (option)" value="{{ old('size') }}">
                                @if ($errors->has('size'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('size') }} </div>  </small>
                                @endif
                            </div>

                            <!-- button to add the product -->
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <button type="submit" class="btnSubmit btn-primary" name="add"> Ajouter </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
