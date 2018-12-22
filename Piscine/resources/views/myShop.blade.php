@extends('navbars.navbarSeller')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class = "col-lg-3 ">
                <h1> Commerce : {{ $shop->nomCommerce }} </h1>

            </div>
            <div class="col-lg-6">
                <div class="form-inline">
                <h4> Horaires : </h4> <a href="{{url()->current()}}/horaires"> (éditer) </a> <br/>
                </div>
                @foreach($days as $day)
                    <li>
                        <strong>{{$day->nomJour}}</strong>
                        @if(($schedulesOfWork->where('nomJour', $day->nomJour))->count() > 0)
                            ouvert @foreach($schedulesOfWork->where('nomJour', $day->nomJour) as $scheduleOfWork)
                                        de {{$scheduleOfWork->debut}} à {{$scheduleOfWork->fin}}
                                    @endforeach
                        @else
                            fermé
                        @endif
                    </li>
                @endforeach
            </div>
            <div class="col-lg-3">
                <h4> commerçants : </h4>
                @foreach($sellers as $seller)
                    <li> {{$seller->nomVendeur}} <a href="\Piscine\public\vendeur\{{$seller->idVendeur}}"> infos </a> </li>
                @endforeach
            </div>
        </div>
    </div>

    <div class= "col-lg-2" >
         <br>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class = "col-lg-8 ">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><h3> Liste des produits </h3></th>
                        </tr>
                        <tr>
                            <th style="width:35%">Produit</th>
                            <th style="width:5%"  class="text-center">Stock</th>
                            <th style="width:15%" class="text-center">Stock réservé </th>
                            <th style="width:10%"  class="text-center"> variantes </th>
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
                                            <p>  {{ str_limit($product->libelleProduit, $limit = 30, $end = '...') }} </p>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">{{$product->qteStockProduit}}</td>
                                <td data-th="Quantity booked"  class="text-center"> {{($product->qteStockProduit)-($product->qteStockDispoProduit)}} </td>
                                </td>
                                <td  class="text-center">
                                    <select name="variant" class="form-control form-control-sm col-sm-12">
                                        @foreach($groups as $group)
                                            @if ($group->couleurProduit != null)
                                                <option value="{{$group->couleurProduit}}"> {{$group->couleurProduit}}</option>
                                            @endif
                                        @endforeach
                                        @foreach($groups as $group)
                                            @if ($group->tailleProduit != null)
                                                <option value="{{$group->tailleProduit}}"> {{$group->tailleProduit}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>

                                <td class="actions" data-th=""  class="text-center">

                                    <input name="product" type="hidden" value="{{ $product->numProduit }}">

                                    <button class="btn btn-success btn-group" name="show">   <i class="fas fa-info"></i> </button>
                                    <button class="btn btn-warning btn-group" name="edit">   <i class="fas fa-edit"></i> </button>
                                    <button class="btn btn-danger btn-group"  name="delete"> <i class="fas fa-times-circle"></i> </button>
                                    <button class="btn btn-info btn-group"    name="variant"><i class="fas fa-copy"></i> </button>
                                </td>
                            </form>
                        </tr>
                        </tbody>
                        @endforeach
                </table>
            </div>

            <div class="form col-lg-4">
                <h3> Ajouter un produit : </h3> <br>

                <form action="" method="post">
                    {{  csrf_field()  }}
                    <div class="form">
                        <!-- type of product -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label"> catégorie :</label>
                            <div class="col-sm-8">
                                <select name="nomType" class="form-control form-control-sm col-sm-12">
                                    @foreach ($types as $type)
                                        <option value="{{$type->nomTypeProduit}}"> {{$type->nomTypeProduit}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- numSiret -->
                            <input name="numSiretCommerce" type="hidden" value="{{$numShop}}">

                            <!-- name -->
                            <label class="col-sm-4 col-form-label"> Nom :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="productName" placeholder="nom du produit *" value="{{ old('productName') }}">
                            @if ($errors->has('productName'))
                                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('productName') }} </div> </small>
                                @endif
                            </div>

                            <!-- description -->
                            <label class="col-sm-4 col-form-label">Libellé :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" rows="2" placeholder="description du produit *" value="{{ old('description') }}"></textarea>
                            @if ($errors->has('description'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div>  </small>
                                @endif
                            </div>

                            <!-- stock -->
                            <label class="col-sm-4 col-form-label"> quantité en stock :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="stock" placeholder="quantité en stock *" value="{{ old('stock') }}">
                                @if ($errors->has('stock'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('stock') }} </div>  </small>
                                @endif
                            </div>

                            <!-- delivery -->
                            <label class="col-sm-4 col-form-label"> livraison du produit :</label>
                            <div class="col-sm-8 col-form-label ">
                                <input class="form-horizontal" type="radio" name="delivery" id="Y" value="0">
                                <label class="form-check-label" for="M"> oui </label>
                                <input class="form-horizontal" type="radio" name="delivery" id="N" value="1">
                                <label class="form-check-label" for="F"> non </label>
                                @if ($errors->has('delivery'))
                                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('delivery') }} </div> </small>
                                @endif
                            </div>

                            <!-- price -->
                            <label class="col-sm-4 col-form-label">prix unitaire :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="price" placeholder="prix du produit *" value="{{ old('price') }}">
                                @if ($errors->has('price'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('price') }} </div>  </small>
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

                            <!-- brand -->
                            <label class="col-sm-4 col-form-label">Marque :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="brand" placeholder="marque (option)" value="{{ old('brand') }}">
                                @if ($errors->has('brand'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('brand') }} </div>  </small>
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