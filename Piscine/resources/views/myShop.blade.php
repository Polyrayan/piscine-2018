@extends('navbars.navbarSeller')

@section('content')
    <div class = "container-fluid">
        <h1> Commerce : {{ $shopName->nomCommerce }} </h1> <br>
        <h5> liste des commerçants : </h5>
        <ul>
            @foreach($sellers as $seller)
                <li> {{$seller->nomVendeur}}  <a  href="\Piscine\public\vendeur\{{$seller->mailVendeur}}"> infos </a></li>
                @endforeach
        </ul>

        <h5> liste des produits : </h5> <br>

        @foreach($products as $product)
            <ul>
                <li>
                    {{$product->nomProduit}} , stock : {{ $product->qteStockProduit }}
                    <span class="input-group-btn"> <input type="submit" class="btn btn-success btn-group" name="show" value="informations"> </span>
                    <span class="input-group-btn"> <input type="submit" class="btn btn-warning btn-group" name="edit" value="éditer"> </span>
                    <span class="input-group-btn"> <input type="submit" class="btn btn-danger btn-group" name="delete" value="Supprimer"> </span>
                </li>
            </ul>

        @endforeach

        <h5> Ajouter un produit : </h5> <br>

            <form action="" method="post">
                {{  csrf_field()  }}

                <div class="form-group ">

                    <!-- numSiret -->
                    <input name="numSiretCommerce" type="hidden" value="{{$numShop}}">

                    <!-- nomProduit -->
                    <label class="col-sm-2 col-form-label"> nom :</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="productName" placeholder="nom du produit *" value="{{ old('productName') }}">
                        @if ($errors->has('productName'))
                            <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('productName') }} </div> </small>
                        @endif
                    </div>

                    <!-- libelle produit -->
                    <label class="col-sm-2 col-form-label">libellé :</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="description" rows="3" placeholder="description du produit *" value="{{ old('description') }}"></textarea>
                        @if ($errors->has('description'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div>  </small>
                        @endif
                    </div>

                    <!-- stock -->
                    <label class="col-sm-2 col-form-label">quantité en stock :</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="stock" placeholder="quantité en stock *" value="{{ old('stock') }}">
                        @if ($errors->has('stock'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('stock') }} </div>  </small>
                        @endif
                    </div>

                    <!-- delivery -->
                    <label class="col-sm-2 col-form-label"> livraison du produit :</label>
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
                    <label class="col-sm-10 col-form-label">prix unitaire :</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="price" placeholder="prix du produit *" value="{{ old('price') }}">
                        @if ($errors->has('price'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('price') }} </div>  </small>
                        @endif
                    </div> <br>

                    <!-- button to add the product -->
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-primary" name="add"> Ajouter </button>
                    </div>
                </div>
            </form>
    </div>




@endsection