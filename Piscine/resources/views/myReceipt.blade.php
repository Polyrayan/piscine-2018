@extends('navbars.navbarClient')

@section('content')
    <br>
    <h1> Récapitulatif de la Commande : </h1>
    @isset($products)

            <br>
            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:20%">Produit</th>
                            <th style="width:10%" class="text-center">Couleur</th>
                            <th style="width:10%" class="text-center">Taille</th>
                            <th style="width:5%" class="text-center">Prix</th>
                            <th style="width:5%" class="text-center">Quantité</th>
                            <th style="width:15%" class="text-center">Sous total</th>
                            <th style="width:15%" class="text-center">Points gagnés</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                      <tr>
                          <td data-th="Product"><h5><b>{{$product->nomProduit}} </b></h5></td>
                          <td data-th="Color" class="text-center"><b>{{$product->couleurProduit}}</b></td>
                          <td data-th="Size" class="text-center"><b>{{$product->tailleProduit}}</b></td>
                          <td data-th="Price" class="text-center"><b>{{$product->prixProduit}}€</b></td>
                          <td data-th="Quantity" class="text-center"><b>{{$product->qteCommande}}</b></td>
                          <td data-th="Subtotal" class="text-center"><b>{{$product->prixProduit*$product->qteCommande}}€</b></td>
                          <td data-th="points" class="text-center">
                            @if($product->livrer == 1)
                            <b> magasin: <font color="green"> {{number_format($product->prixProduit*$product->qteCommande*0.15,1)}} </font> </b>
                            @else
                            <b> livraison : <font color="#DF3A01"> {{number_format($product->prixProduit*$product->qteCommande*0.10,1)}} </font>
                            @endif
                            </td>
                      </tr>
                    @endforeach
                    </tbody>

                <tfoot>
                      <tr>
                          <td colspan="5  " class="hidden-xs"></td>
                          <td class="hidden-xs text-center"><strong>Total {{ $total }}€ </strong></td>
                          <td class="hidden-xs text-center"><strong>Points Fidélité : {{ number_format($points,1) }}<strong></td>
                      </tr>
                      <tr>
                        <td colspan="7" class="hidden-xs"></td>
                      </tr>
                </tfoot>
            </table>
          <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-2">
              <form class ="input-group" method="POST">
                {{  csrf_field()  }}
                <td>
                  <input type="hidden" name="shoppingCartNumber" value="{{$numPanier}}">
                  <button class="btn btn-success" name="paid">Terminer et régler la commande</button>
                </td>
              </form>
            </div>
          </div>
        </div>

    @endisset
@endsection
