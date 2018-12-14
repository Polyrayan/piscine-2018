@extends('navbars.navbarClient')

@section('content')

    <h1> Mon Panier : </h1>
    @if(!@isset($products))
        <div class="alert alert-info text-center" role="alert">
            <strong> Vous n'avez aucun produit dans votre panier ! </strong> Cliquez <a href="./../../" class="alert-link">ici</a> pour ajouter de nouveaux produits.
        </div>
        <div class="alert alert-success text-center" role="alert">
            <strong> Historique des commandes : </strong> Cliquez <a href="./../../" class="alert-link">ici</a> pour suivre la progression de vos commandes déjà réglée.
        </div>
    @endisset
    @isset($products)

            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:50%">Produit</th>
                            <th style="width:5%">Prix</th>
                            <th style="width:5%">Quantité</th>
                            <th style="width:15%" class="text-center">Sous total</th>
                            <th style="width:24% "class="text-center">Points gagnés</th>
                            <th style="width:8%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <form class ="input-group" method="POST">
                            {{  csrf_field()  }}
                            <input name="productNumber" type="hidden" value="{{ $product->numProduit }}">
                            <input name="orderNumber" type="hidden" value="{{ $product->numCommande }}">
                            <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                            <input name="price" type="hidden" value="{{ $product->prixProduit }}">

                        <tr>
                            <td data-th="Product">
                                <div class="row">
                            <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                            <div class="col-sm-10">
                                <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                <p>{{$product->libelleProduit}}</p>
                            </div>
                        </div>
                            </td>
                            <td data-th="Price" ><b>{{$product->prixProduit}}€</b></td>
                            <td data-th="Quantity">
                                <input type="number" class="form-control text-center" name="quantity" value={{$product->qteCommande}}>
                            </td>
                            <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                            <td data-th="points" class="text-center"><b> livraison :  <font color="#DF3A01"> {{number_format($product->prixProduit*$product->qteCommande*0.10,1)}} </font>
                                    <br> magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>
                            <td class="actions form-inline" data-th="">
                                <button class="btn btn-info btn-sm" name="update"><i class="fas fa-redo-alt"></i></button>
                                <button class="btn btn-danger btn-sm" name="delete"><i class="fas fa-times-circle"></i></button>
                            </td>
                        </tr>
                    @endforeach
                        </form>
                    </tbody>

                <tfoot>
                    <form class ="input-group" method="POST">
                            {{  csrf_field()  }}
                        <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                        <tr class="visible-xs">
                            <td class="text-center"><strong>Total {{$total}}€</strong></td>
                        </tr>
                        <tr>
                            <td><a href="./../../" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                            <td colspan="2  " class="hidden-xs"></td>
                            <td class="hidden-xs text-center"><strong>Total {{ $total }}€ </strong></td>
                            <td></td>
                            <td> <button class="btn btn-success btn-sm" name="buy">Régler votre panier </button></td>
                        </tr>
                    </form>
                </tfoot>
            </table>
        </div>

    @endisset
@endsection