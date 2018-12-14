@extends('navbars.navbar')

@section('content')
    <div class="container-fluid">


        <h1> Page d'accueil </h1>

        <h3> ce qu'il manque : </h3>
        <ul>
            <li> trier par categorie </li>
            <li> pagination </li>
            <li> créer les tags  </li>
            <li> régler la connexion  </li>
            <li> faire le tunnel d'achat  </li>
            <li> régler les boutons non fonctionnels </li>
        </ul>
        <h2> Produits </h2>
    </div>

    <div class="container">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:50%">Produit</th>
                <th style="width:5%">Prix</th>
                <th style="width:5%">Quantité</th>
                <th style="width:8%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <form class ="input-group" style="display: inline-block" method="POST">
                        {{  csrf_field()  }}
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                <div class="col-sm-10">
                                    <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                    <p>{{$product->libelleProduit}}</p>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{$product->prixProduit}}€</td>
                        <td data-th="Quantity">
                            <input type="number" class="form-control text-center" value= "1" >
                        </td>
                        <td class="actions form-inline" data-th="">
                            <a href="./commerces/{{$product->numSiretCommerce}}" class="btn btn-info" role="button"> voir le magasin </a>
                            <input name="productNumber" type="hidden" value="{{ $product->numProduit }}">
                            <button class="btn btn-warning btn-group" name="addShoppingCart"> ajouter au panier </button>
                            <button class="btn btn-success btn-group" name="book"> réserver </button>
                        </td>
                    </form>
                </tr>
            </tbody>
            @endforeach
        </table>

@endsection
