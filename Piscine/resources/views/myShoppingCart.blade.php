@extends('navbars.navbarClient')

@section('content')
    <br>
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

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:40%">Produit</th>
                                    <th style="width:5%" class="text-center">Couleur</th>
                                    <th style="width:10%" class="text-center">Taille</th>
                                    <th style="width:5%" class="text-center">Prix</th>
                                    <th style="width:5%" class="text-center">Quantité</th>
                                    <th style="width:15%" class="text-center">Sous total</th>
                                    <th style="width:15% "class="text-center">Points gagnés</th>
                                    <th style="width:15%"></th>
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
                                    <div class="col-sm-4 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                    <div class="col-sm-8">
                                        <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                        <p>{{$product->libelleProduit}}</p>
                                    </div>
                                </div>
                                    </td>
                                    <td data-th="Color" class="text-center"> {{ $product->couleurProduit }} </td>
                                    <td data-th="Size" class="text-center"> {{ $product->tailleProduit }}</td>
                                    <td data-th="Price" class="text-center" ><b>{{$product->prixProduit}}€</b></td>
                                    <td data-th="Quantity">
                                        <input type="number" class="form-control text-center" name="quantity" value={{$product->qteCommande}}>
                                    </td>
                                    <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                                    <td data-th="points" class="text-center"><b> Livraison :  <font color="#DF3A01"> {{number_format($product->prixProduit*$product->qteCommande*0.10,1)}} </font>
                                            <br> Magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b> </td>
                                    <td class="actions" data-th="">
                                        <button type="submit" class="btn btn-info btn-sm" name="update"><i class="fas fa-redo-alt"></i></button>
                                        <button type="submit" class="btn btn-danger btn-sm" name="delete"><i class="fas fa-times-circle"></i></button>
                                    </td>
                                </tr>
                                </form>
                            @endforeach
                            </tbody>

                            <tfoot>
                                <form class ="input-group" method="POST">
                                        {{  csrf_field()  }}
                                    <input name="shoppingCartNumber" type="hidden" value="{{ $product->numPanier }}">
                                    <tr>
                                        <td><a href="./../../" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continuer vos achats</a></td>
                                        <td colspan="2  " class="hidden-xs"></td>
                                        <td class=" text-center"><strong> Total {{ $total }}€ </strong></td>
                                        <td></td>
                                        <td></td>
                                        <td> <button class="btn btn-success btn-sm" name="buy">Régler votre panier </button></td>
                                        <td></td>
                                    </tr>
                                </form>
                            </tfoot>
                        </table>
                    </div>
                </div>
        </div>

    @endisset
@endsection
