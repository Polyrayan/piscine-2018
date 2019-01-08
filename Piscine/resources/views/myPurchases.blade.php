@extends('navbars.navbarClient')

@section('content')
    <br>
    <h1> Ajouter un avis sur un des produit acheté </h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                <table  class="table  table-condensed">
                    <thead>
                    <tr>
                        <th style="width:30%">Produit</th>
                        <th style="width:5%" class="text-center">Couleur</th>
                        <th style="width:10%" class="text-center">Taille</th>
                        <th style="width:5%" class="text-center">Prix</th>
                        <th style="width:15%"class="text-center">Note attribué </th>
                        <th style="width:40%" class="text-center">Votre commentaire</th>
                        <th style="width:25%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($commandes as $commande)
                        <form class ="input-group" method="POST">
                            {{  csrf_field()  }}
                            <input name="productNumber" type="hidden" value="{{ $commande->numProduit }}">
                            <input name="mailClient" type="hidden" value="{{ $client->mailClient }}">

                            <tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-8 col-sm-6 col-xs-8 ">
                                            @if(empty($commande->imageProduit))
                                                <a class="nomargin" href="./produits/{{$commande->numProduit}}"><img class="d-block w-100" src="http://placehold.it/100x100" alt="Les meilleurs avis"></a>A
                                            @else
                                                <a class="nomargin" href="./produits/{{$commande->numProduit}}"><img class="d-block w-100" src="{{$commande->imageProduit}}" alt="Les meilleurs avis"></a>
                                            @endif
                                        </div>
                                        <div class="col-lg-7 col-md-8 col-sm-6 col-xs-8">
                                            <h4 class="nomargin"><b>{{$commande->nomProduit}} </b></h4>
                                            <p>{{$commande->libelleProduit}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Color" class="text-center"> {{ $commande->couleurProduit }} </td>
                                <td data-th="Size" class="text-center"> {{ $commande->tailleProduit }}</td>
                                <td data-th="Price" class="text-center"><b>{{$commande->prixProduit}}€</b></td>
                                <td data-th="">
                                    <input type="number" class="form-control" name="mark" value="{{old('mark')}}" placeholder=" note /10" >
                                </td>
                                <td data-th="Quantity" class="text-center">
                                    <textarea class="form-control animated" cols="40" id="new-review" name="comment" placeholder="Laisser un commentaire" rows="2"> {{old('comment')}}</textarea>
                                    @if ($errors->has('comment'))
                                        <small>  <div class="alert alert-danger"  role="alert"> {{ $errors->first('comment') }} </div>  </small>
                                    @endif
                                </td>
                                <td class="actions" data-th="">
                                    <button class="btn btn-success btn-group" name="rate" type="submit">Envoyer</button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="7" class="hidden-xs"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @if($reviews->count() > 0 )
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                    <table  class="table  table-condensed">
                        <thead>
                        <tr>
                            <th style="width:30%">Produit</th>
                            <th style="width:5%" class="text-center">Couleur</th>
                            <th style="width:10%" class="text-center">Taille</th>
                            <th style="width:5%" class="text-center">Prix</th>
                            <th style="width:15%"class="text-center">Note attribué </th>
                            <th style="width:40%" class="text-center">Le commentaire que vous avez posté</th>
                            <th style="width:25%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <form class ="input-group" method="POST">
                                {{  csrf_field()  }}
                                <input name="productNumber" type="hidden" value="{{ $review->numProduit }}">
                                <input name="mailClient" type="hidden" value="{{ $review->mailClient }}">

                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-8 col-sm-6 col-xs-8 ">
                                                @if(empty($review->imageProduit))
                                                    <a class="nomargin" href="./produits/{{$review->numProduit}}"><img class="d-block w-100" src="http://placehold.it/100x100" alt="Les meilleurs avis"></a>A
                                                @else
                                                    <a class="nomargin" href="./produits/{{$review->numProduit}}"><img class="d-block w-100" src="{{$review->imageProduit}}" alt="Les meilleurs avis"></a>
                                                @endif
                                            </div>
                                            <div class="col-lg-7 col-md-8 col-sm-6 col-xs-8">
                                                <h4 class="nomargin"><b>{{$review->nomProduit}} </b></h4>
                                                <p>{{$review->libelleProduit}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Color" class="text-center"> {{ $review->couleurProduit }} </td>
                                    <td data-th="Size" class="text-center"> {{ $review->tailleProduit }}</td>
                                    <td data-th="Price" class="text-center"><b>{{$review->prixProduit}}€</b></td>
                                    <td data-th="Note"  class="text-center">
                                        {{$review->noteAvis}}
                                    </td>
                                    <td data-th="Quantity" class="text-center">
                                        "{{$review->commentaireAvis}}" posté le {{$review->dateAvis}}
                                    </td>
                                    <td class="actions" data-th="">
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                        @endforeach
                        <tfoot>
                        <tr>
                            <td colspan="7" class="hidden-xs"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
