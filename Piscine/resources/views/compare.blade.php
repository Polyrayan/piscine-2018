@extends('navbars.navbarClient')

@section('content')
    <br>
    <div class="container-fluid">
        <h1> Comparaison des produits : </h1>
        <br>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                @if (!empty($product1))
                    <form method="POST">
                        {{  csrf_field()  }}
                        <h3 class="text-center">Produit n°1 : <a class="nomargin" href="./produits/{{$product1->numProduit}}">{{$product1->nomProduit}}</a></h3>
                        <table  class="table  table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:30%"></th>
                                    <th style="width:70%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <b> Description  : </b> </td>
                                    <td class="text-center"> {{$product1->libelleProduit}}</td>
                                </tr>
                                <tr>
                                    <td> <b> Categorie </b> </td>
                                    <td class="text-center"> {{$product1->nomTypeProduit}} </td>
                                </tr>
                                <tr>
                                    <td> <b> Couleur </b></td>
                                    <td class="text-center">
                                        @if (empty($product1->couleurProduit))
                                            -
                                        @else
                                            {{$product1->couleurProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Taille </b> </td>
                                    <td class="text-center">
                                        @if (empty($product1->tailleProduit))
                                            -
                                        @else
                                            {{$product1->tailleProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Marque </b> </td>
                                    <td class="text-center">
                                        @if (empty($product1->marqueProduit))
                                            -
                                        @else
                                            {{$product1->marqueProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Prix </b> </td>
                                    <td class="text-center">
                                        @if (!empty($product2))
                                            @if ($product1->prixProduit < $product2->prixProduit)
                                                <font color="#228b22"> {{$product1->prixProduit}} € </font>
                                            @elseif($product1->prixProduit > $product2->prixProduit)
                                                <font color="#8b0000">{{$product1->prixProduit}} €</font>
                                            @else
                                                {{$product1->prixProduit}} €
                                            @endif
                                        @else
                                            {{$product1->prixProduit}} €
                                            @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Distance </b> </td>
                                    <td class="text-center"> {{$product1->distance}} km </td>
                                </tr>
                                <tr>
                                    <td> <b> livraison </b> </td>
                                    <td class="text-center">
                                        @if (!empty($product2))
                                            @if ($product1->livraisonProduit == 0 and $product2->livraisonProduit == 1 )
                                                <font color="#228b22"> oui </font>
                                            @elseif($product1->livraisonProduit == 0 and $product2->livraisonProduit == 0 )
                                                oui
                                            @elseif($product1->livraisonProduit == 1 and $product2->livraisonProduit == 1 )
                                                non
                                            @elseif($product1->livraisonProduit == 1 and $product2->livraisonProduit == 0 )
                                                <font color="red">non</font>
                                            @endif
                                        @else
                                            @if ($product1->livraisonProduit == 0)
                                                oui
                                            @else
                                                non
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td></td>
                                <input name="product" type="hidden" value="1">
                                <td><button class="btn btn-danger" name="delete"> Supprimer </button> </td>
                            </tfoot>
                        </table>
                    </form>

                @else
                    <h3 class="text-center">Produit n°1 : </h3>
                    <div class="alert alert-info text-center" role="alert">
                        <strong> Vous n'avez pas de produit n°1 </strong> Cliquez <a href="./" class="alert-link">ici</a> pour chercher un produit à comparer avec le produit n°2.
                    </div>
                @endif

            </div>
            <div class="col-lg-4">
                @if (!empty($product2))
                    <form method="POST">
                        {{  csrf_field()  }}
                        <h3 class="text-center">Produit n°2: <a class="nomargin" href="./produits/{{$product2->numProduit}}">{{$product2->nomProduit}}</a></h3>
                        <table  class="table  table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:30%"></th>
                                    <th style="width:70%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <b> Description  : </b> </td>
                                    <td class="text-center"> {{$product2->libelleProduit}}</td>
                                </tr>
                                <tr>
                                    <td> <b> Categorie </b> </td>
                                    <td class="text-center"> {{$product2->nomTypeProduit}} </td>
                                </tr>
                                <tr>
                                    <td> <b> Couleur </b></td>
                                    <td class="text-center">
                                        @if (empty($product2->couleurProduit))
                                            -
                                        @else
                                            {{$product2->couleurProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Taille </b> </td>
                                    <td class="text-center">
                                        @if (empty($product2->tailleProduit))
                                            -
                                        @else
                                            {{$product2->tailleProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Marque </b> </td>
                                    <td class="text-center">
                                        @if (empty($product2->marqueProduit))
                                            -
                                        @else
                                            {{$product2->marqueProduit}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Prix </b> </td>
                                    <td class="text-center">
                                        @if (!empty($product1))
                                            @if ($product2->prixProduit < $product1->prixProduit)
                                                <font color="#228b22"> {{$product2->prixProduit}} € </font>
                                            @elseif($product2->prixProduit > $product1->prixProduit)
                                                <font color="red">{{$product2->prixProduit}} €</font>
                                            @else
                                                {{$product2->prixProduit}} €
                                            @endif
                                        @else
                                            {{$product2->prixProduit}} €
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Distance </b> </td>
                                    <td class="text-center">
                                        @if (!empty($product1))
                                            @if ($product2->distance < $product1->distance)
                                                <font color="#228b22"> {{$product2->distance}} km </font>
                                            @elseif($product2->distance > $product1->distance)
                                                <font color="red">{{$product2->distance}} km</font>
                                            @else
                                                {{$product2->distance}} km
                                            @endif

                                        @else
                                            {{$product2->distance}} km
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> livraison </b> </td>
                                    <td class="text-center">
                                        @if (!empty($product1))
                                            @if ($product2->livraisonProduit == 0 and $product1->livraisonProduit == 1 )
                                                <font color="#228b22"> oui </font>
                                            @elseif($product2->livraisonProduit == 0 and $product1->livraisonProduit == 0 )
                                                oui
                                            @elseif($product2->livraisonProduit == 1 and $product1->livraisonProduit == 1 )
                                                non
                                            @elseif($product2->livraisonProduit == 1 and $product1->livraisonProduit == 0 )
                                                <font color="red">non</font>
                                            @endif
                                        @else
                                            @if ($product2->livraisonProduit == 0)
                                                oui
                                            @else
                                                non
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td></td>
                                <input name="product" type="hidden" value="2">
                                <td><button class="btn btn-danger" name="delete"> Supprimer </button> </td>
                            </tfoot>
                        </table>
                    </form>
                @else
                    <h3 class="text-center">Produit n°2 : </h3>
                    <div class="alert alert-info text-center" role="alert">
                        <strong> Vous n'avez pas de produit n°2 </strong> Cliquez <a href="./" class="alert-link">ici</a> pour chercher un produit à comparer avec le produit n°1.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
