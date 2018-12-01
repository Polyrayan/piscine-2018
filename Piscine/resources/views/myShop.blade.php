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


        <div  class = " text-left col-lg-2" >
            <h3> liste des produits : </h3> <br>
        </div>


        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:35%">Produit</th>
                <th style="width:10%">Stock</th>
                <th style="width:15%">Stock réservé </th>
                <th style="width:8%"> Quantité </th>
                <th style="width:42%"></th>
            </tr>
            </thead>
            @foreach($products as $product)
                <tbody>
                <tr>
                    <form class ="input-group" style="display: inline-block" method="POST">
                        {{  csrf_field()  }}
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                <div class="col-sm-10">
                                    <h4 class="nomargin"> <b>{{$product->nomProduit}} </b> </h4>
                                    <p>  {{$product->libelleProduit}}</p>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{$product->qteStockProduit}}</td>
                        <td data-th="Quantity booked"> {{($product->qteStockProduit)-($product->qteStockDispoProduit)}} </td>
                        </td>
                        <td></td>

                        <td class="actions" data-th="">

                            <input name="product" type="hidden" value="{{ $product->numProduit }}">

                            <button class="btn btn-success btn-group"   name="show"> informations </button>
                            <button class="btn btn-warning btn-group" name="edit"> éditer </button>
                            <button class="btn btn-danger btn-group" name="delete"> supprimer </button>
                        </td>
                    </form>
                </tr>
                </tbody>
                @endforeach
        </table>


    <div class="form">
    <h3> Ajouter un produit : </h3> <br>

    <form action="" method="post">
        {{  csrf_field()  }}

        <div class="form text-left">


            <!-- type of product -->
            <label class="col-sm-2 col-form-label"> catégorie :</label>
            <div class="col-sm-10">
                <select name="numType" class="form-control form-control-sm col-sm-3">
                    @foreach ($types as $type)
                        <option value="{{$type->numTypeProduit}}"> {{$type->nomTypeProduit}}</option>
                    @endforeach
                </select>
            </div>

            <!-- numSiret -->
            <input name="numSiretCommerce" type="hidden" value="{{$numShop}}">

            <!-- nomProduit -->
            <label class="col-sm-2 col-form-label"> nom :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="productName" placeholder="nom du produit *" value="{{ old('productName') }}">
            @if ($errors->has('productName'))
                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('productName') }} </div> </small>
                @endif
            </div>

            <!-- libelle produit -->
            <label class="col-sm-2 col-form-label">libellé :</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description" rows="3" placeholder="description du produit *" value="{{ old('description') }}"></textarea>
            @if ($errors->has('description'))
                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div>  </small>
                @endif
            </div>

            <!-- stock -->
            <label class="col-sm-2 col-form-label"> quantité en stock :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="stock" placeholder="quantité en stock *" value="{{ old('stock') }}">
                @if ($errors->has('stock'))
                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('stock') }} </div>  </small>
                @endif
            </div>

            <!-- delivery -->
            <label class="col-sm-2 col-form-label"> livraison du produit :</label>
            <div class="col-sm-10 col-form-label ">
                <input class="form-horizontal" type="radio" name="delivery" id="Y" value="0">
                <label class="form-check-label" for="M"> oui </label>
                <input class="form-horizontal" type="radio" name="delivery" id="N" value="1">
                <label class="form-check-label" for="F"> non </label>
                @if ($errors->has('delivery'))
                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('delivery') }} </div> </small>
                @endif
            </div>

            <!-- price -->
            <label class="col-sm-2 col-form-label">prix unitaire :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" placeholder="prix du produit *" value="{{ old('price') }}">
                @if ($errors->has('price'))
                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('price') }} </div>  </small>
                @endif
            </div>

            <!-- button to add the product -->
            <div class="col-sm-8">
                <button type="submit" class="btn btn-primary" name="add"> Ajouter </button>
            </div>
        </div>
    </form>
    </div>
    </div>
@endsection