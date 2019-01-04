@extends('navbars.navbarClient')

@section('content')
    <div class="container-fluid">
        <br>

        <h1> Page d'accueil </h1>

        <h3> ce qu'il manque : </h3>
        <ul>
            <li> faire le edit dans shopProductsController</li>
            <li> ajouter un footer dans toutes les views pour faire plus PRO , vous amusez pas a faire un footer dans chaque view utiliser blade c'est comme l'extension de la navbar mais inversé </li>
            <li> Par conte quand on est connecté en tant que client on a accès aux réservations des autres clients pour l’instant ...</li>
            <li> formulaire produit : ajouter une image </li>
            <li> formulaire commerce : ajouter une image </li>
            <li> un admin peut supprimer des avis </li>
            <li> ajouter profil dans les navbar client vendeur</li>
            <li> refered et js</li>
            <li> refaire la navbar </li>
            <li> trier par categorie </li>
            <li> toutes les views admin </li>
            <li> faire le tunnel d'achat  </li>
            <li> régler les boutons non fonctionnels </li>
            <li> pouvoir utiliser des points de reductions</li>
            <li> faire la fonction d'ajout de produits via un .csv </li>
            <li> pouvoir créer un code de reduction dans un commerce</li>
            <li> pouvoir appliquer un code de reduction en tant que client </li>
            <li> ajouter dans les formulaires d'un nouveau produit(myshop) + variante(editVariantesShop) la possibilité de donner une ou plusieurs images ( si plusieurs rajouter une table images dans la bd...) </li>
            <li> OPTION :put delete </li>
            <li> OPTION :héberger le site </li>
            <li> OPTION : rajouter une template </li>
            <li> OPTION : supprimer variante quand on supprime le groupe de produit pour eviter "la fuite memoire" </li>
        </ul>
    </div>

    <div class="container-fluid">

        <!--Carousel Wrapper-->
        <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
            <!--Indicators-->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-2" data-slide-to="1"></li>
                <li data-target="#carousel-example-2" data-slide-to="2"></li>
            </ol>
            <!--/.Indicators-->
            <!--Slides-->
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(68).jpg" alt="First slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Light mask</h3>
                        <p>First text</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(6).jpg" alt="Second slide">
                        <div class="mask rgba-black-strong"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Strong mask</h3>
                        <p>Secondary text</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(9).jpg" alt="Third slide">
                        <div class="mask rgba-black-slight"></div>
                    </div>
                    <div class="carousel-caption">
                        <h3 class="h3-responsive">Slight mask</h3>
                        <p>Third text</p>
                    </div>
                </div>
            </div>
            <!--/.Slides-->
            <!--Controls-->
            <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <!--/.Controls-->
        </div>
        <!--/.Carousel Wrapper-->
    </div>

    <!-- search -->
    </br>
   <div class="container-fluid">
       <h2> Produits </h2>
       <div class="row">
           <div class="col-lg-2"></div>
           <div class="col-lg-10">
               <div class="row">
                   <div class="col-lg-6">
                       <!-- first line-->
                       <input class="form-control" type="text" name="search" placeholder="Que recherchez-vous ?">
                   </div>
                   <div class="col-lg-2">
                       <select name="category" class="form-control">
                           <option> toutes catégories </option>
                       </select>
                   </div>
                   <div class="col-lg-4"></div>
                   <!-- second line-->
                   <div class="col-lg-2">
                       <input class="form-control" type="number" name="minSearch" placeholder="Prix min">
                   </div>
                   <div class="col-lg-2">
                       <input class="form-control" type="number" name="maxSearch" placeholder="Prix max">
                   </div>
                   <div class="col-lg-2">
                       <select name="region" class="form-control">
                           <option> Languedoc-Roussillon </option>
                           <option> Aude </option>
                           <option> Gard </option>
                           <option> Hérault </option>
                           <option> Lozère </option>
                           <option> Pyrénées-Orientales </option>
                       </select>
                   </div>
                   <div class="col-lg-2">
                       <input class="form-control" type="text" name="citySearch" placeholder="Ville">
                   </div>
               </div>
           </div>
       </div>
   </div>
    </br>
    <div class="container-fluid">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:30%">Produit</th>
                <th style="width:5%" class="text-center">couleur</th>
                <th style="width:8%" class="text-center">taille</th>
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
                                    <h4 class="nomargin"><b>{{$product->nomProduit}} </b></h4>
                                    <p>{{$product->libelleProduit}}</p>
                                </div>
                            </div>
                        </td>
                        <td  class="text-center">
                            @if(!empty($product->colors))
                                <select name="color" class="form-control form-control-sm col-sm-12">
                                    @foreach($product->colors as $color)
                                        <option value="{{$color}}"> {{$color}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td  class="text-center">
                            @if(!empty($product->sizes))
                                <select name="size" class="form-control form-control-sm col-sm-12">
                                    @foreach($product->sizes as $size)
                                        <option value="{{$size}}"> {{$size}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td data-th="Quantity"  class="text-center">
                            <input type="number" name="quantity" class="form-control text-center" value= "1" >
                            <input name="product" type="hidden" value="{{ $product->numProduit }}">
                            <input name="productPrice" type="hidden" value="{{ $product->prixProduit }}">
                            <input name="numSiret" type="hidden" value="{{ $product->numSiretCommerce }}">
                        </td>
                        <td data-th="Price" class="text-center">{{$product->prixProduit}}€</td>
                        <td data-th="Distance"  class="text-center"> {{ $product->distance }} km </td>
                        <td data-th="City"  class="text-center"> {{$product->city}}</td>
                        <td data-th="Actions">
                            <a href="./commerces/{{$product->numSiretCommerce}}" class="btn btn-info" role="button"> <i class="fas fa-home"></i> </a>
                            <button class="btn btn-warning btn-group" name="addShoppingCart"> <i class="fas fa-cart-arrow-down"></i> </button>
                            <button class="btn btn-success btn-group" name="book"> <i class="far fa-clock"></i> </button>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
