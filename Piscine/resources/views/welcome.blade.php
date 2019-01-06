@extends('navbars.navbarClient')

@section('content')
    <div class="container-fluid">
        <br>

        <h1> Page d'accueil </h1>

        <h3> ce qu'il manque : </h3>
        <ul>
            <li> Gerer les erreurs d'inscription client : si l'email est deja utilisé -> erreur Laravel, alors qu'on devrait signalé que cette email est impossible </li>
            <li> le refresh de la vue du /register/optionalForm est impossible </li>
            <li> ajouter un footer dans toutes les views pour faire plus PRO </li>
            <li> formulaire produit :  pouvoir ajouter une image </li>
            <li> un admin doit pouvoir  supprimer des avis </li>
            <li> pouvoir utiliser des points de reductions</li>
            <li> pouvoir appliquer un code de reduction en tant que client </li>
            <li> deliverMax </li>
            <li> faire des tests pour trouver des erreurs </li>
            <li> ajouter toutes les categorie (:TypeProduit) de LeBonCoin pour avoir une bonne base </li>
            <li> Proposer 3 produits de la meme categorie dans la view produit/{id} "vous pourriez peut etre intérressé par : "  </li>
        </ul>
    </div>

    <!-- search -->
    </br>
    <form method="POST">
        {{  csrf_field()  }}
       <div class="container-fluid">
           <h2> Produits </h2>
           <div class="row">
               <div class="col-lg-1"></div>
               <div class="col-lg-9">
                   <div class="row">
                       <div class="col-lg-4">
                           <!-- first line-->
                           @if(isset($search))
                                <input class="form-control" type="text" name="search" placeholder="Que recherchez-vous ?" value="{{$search}}">
                            @else
                               <input class="form-control" type="text" name="search" placeholder="Que recherchez-vous ?">
                           @endif
                   </div>
                       <div class="col-lg-2">
                           <select name="category" class="form-control">
                               <option> Toutes catégories </option>
                               @if(isset($category))
                                   @foreach($categories as $cat)
                                       @if ( $category == $cat->nomTypeProduit)
                                           <option selected > {{$cat->nomTypeProduit}} </option>
                                       @else
                                           <option> {{$cat->nomTypeProduit}} </option>
                                       @endif
                                   @endforeach
                               @else
                                   @foreach($categories as $cat)
                                           <option> {{$cat->nomTypeProduit}} </option>
                                   @endforeach
                               @endif
                           </select>
                       </div>
                       <div class="col-lg-6"> <button class="btn btn-success btn-group" name="searchProducts"> Rechercher </button></div>
                       <!-- second line-->
                       <div class="col-lg-2">
                           @if(isset($min))
                               <input class="form-control" type="number" name="minSearch" placeholder="Prix min" value="{{$min}}">
                           @else
                               <input class="form-control" type="number" name="minSearch" placeholder="Prix min">
                           @endif
                       </div>
                       <div class="col-lg-2">
                           @if(isset($max))
                               <input class="form-control" type="number" name="maxSearch" placeholder="Prix max" value="{{$max}}">
                           @else
                               <input class="form-control" type="number" name="maxSearch" placeholder="Prix max">
                           @endif
                       </div>
                       <div class="col-lg-2">
                           @if(isset($region))
                               <select name="region" class="form-control">
                                   @if ($region == "Languedoc-Roussillon" )
                                       <option selected> Languedoc-Roussillon </option>
                                   @else
                                       <option> Languedoc-Roussillon </option>
                                   @endif
                                   @if ($region == "Aude" )
                                       <option selected> Aude </option>
                                   @else
                                       <option> Aude </option>
                                   @endif
                                   @if ($region == "Gard" )
                                       <option selected> Gard </option>
                                   @else
                                       <option> Gard </option>
                                   @endif
                                   @if ($region == "Hérault" )
                                       <option selected> Hérault </option>
                                   @else
                                       <option> Hérault </option>
                                   @endif
                                   @if ($region == "Lozère" )
                                       <option selected> Lozère </option>
                                   @else
                                       <option> Lozère </option>
                                   @endif
                                   @if ($region == "Pyrénées-Orientales")
                                       <option selected> Pyrénées-Orientales </option>
                                   @else
                                       <option> Pyrénées-Orientales </option>
                                   @endif
                               </select>
                           @else
                               <select name="region" class="form-control">
                                   <option> Languedoc-Roussillon </option>
                                   <option> Aude </option>
                                   <option> Gard </option>
                                   <option> Hérault </option>
                                   <option> Lozère </option>
                                   <option> Pyrénées-Orientales </option>
                               </select>
                           @endif
                       </div>
                       <div class="col-lg-2">
                           @if(isset($city))
                               <input class="form-control" type="text" name="citySearch" placeholder="Ville" value="{{$city}}">
                           @else
                               <input class="form-control" type="text" name="citySearch" placeholder="Ville">
                           @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </form>

    <!-- table of products -->
    </br>
    <div class="container-fluid">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:30%">Produit</th>
                <th style="width:9%" class="text-center">couleur & taille </th>
                <th style="width:1%" class="text-center">Quantité</th>
                <th style="width:10%" class="text-center">Prix</th>
                <th style="width:10%" class="text-center">Distance</th>
                <th style="width:10%" class="text-center">Ville</th>
                <th style="width:10%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <form class ="input-group" method="POST">
                        <input type="hidden" name="mailClient" value="{{$mailClient}}">
                        {{  csrf_field()  }}
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-10 col-xs-8">
                                    @if(empty($product->imageProduit))
                                        <img src="http://placehold.it/100x100" style="width:100px; height: 100px;" alt="..." class=" img img-thumbnail"/>
                                    @else
                                        <img src="{{$product->imageProduit}}" style="width:  100px; height: 100px;" alt="..." class=" img-thumbnail"/>
                                    @endif
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-6">
                                    <a class="nomargin" href="./produits/{{$product->numProduit}}"><h3>{{$product->nomProduit}} </h3></a>
                                    <p>{{$product->libelleProduit}}</p>
                                </div>
                            </div>
                        </td>
                        <td  class="text-center">
                            @if(!empty($product->colors) or !empty($product->sizes))
                                <select name="productNumber" class="form-control form-control-sm col-sm-12">
                                    @foreach($allProducts->where('numGroupeVariante', $product->numGroupeVariante) as $oneProduct)
                                        <option value="{{$oneProduct->numProduit}}"> {{$oneProduct->couleurProduit}} {{$oneProduct->tailleProduit}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" name="productNumber" value="{{$product->numProduit}}">
                            @endif
                        </td>
                        <td data-th="Quantity"  class="text-center">
                            <input type="number" name="quantity" class="form-control text-center" value= "1" >
                            <input name="productPrice" type="hidden" value="{{ $product->prixProduit }}">
                            <input name="numSiret" type="hidden" value="{{ $product->numSiretCommerce }}">
                        </td>
                        <td data-th="Price" class="text-center">{{$product->prixProduit}}€</td>
                        <td data-th="Distance"  class="text-center">
                            @if ($product->distance < 1 )
                                <i class="fas fa-route"></i> {{$product->distance*1000}} m
                            @else
                                 {{ $product->distance }} km
                            @endif
                        </td>
                        <td data-th="City"  class="text-center"> {{$product->city}}</td>
                        <td data-th="Actions">
                            <a href="./commerces/{{$product->numSiretCommerce}}" class="btn btn-info" role="button"> <i class="fas fa-home"></i> </a>
                            <button class="btn btn-warning btn-group" name="addShoppingCart"> <i class="fas fa-cart-arrow-down"></i> </button>
                            <button class="btn btn-success btn-group" name="book"> <i class="far fa-clock"></i> </button>
                            <button class="btn bg-light btn-group" name="compare"> <i class="fas fa-yin-yang"></i> </button>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($products->count() <= 0)
            <div class="text-center">
                <br>
                <br>
                <h5> Aucun résultat pour votre recherche </h5>
            </div>
        @endif
        <div class="text-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
