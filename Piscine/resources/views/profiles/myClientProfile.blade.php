@extends('navbars.navbarClient')

@section('content')

    <br>

    <div class="container-fluid">
        <h1> Modification Client: </h1>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-3">
                <form action="" method="post">
                {{  csrf_field()  }}

                <!-- mail -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Email :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-form-label">
                            <p>{{ $client->mailClient  }}</p>
                        </div>
                    </div>

                    <!-- name -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Nom :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="name" placeholder="nom" value="{{ $client->nomClient }}">
                            @if ($errors->has('name'))
                                <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('name') }} </div> </small>
                            @endif
                        </div>
                    </div>

                    <!-- firstname -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Prénom :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="firstName" placeholder="prénom" value="{{ $client->prenomClient }}">
                            @if ($errors->has('firstName'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('firstName') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- phone number -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Téléphone :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="tel" class="form-control"  name="phone" placeholder="telephone" value="{{ $client->telClient }}">
                            @if ($errors->has('phone'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- address -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Adresse :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="address"placeholder="15 rue Exemple" value="{{ $client->adresseClient }}">
                            @if ($errors->has('address'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('address') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- city -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Ville :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="city" placeholder="Ville" value="{{ $client->villeClient }}">
                            @if ($errors->has('city'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('city') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- postal code -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Code postal :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="number" class="form-control" name="zipCode" placeholder="code postal" value="{{ $client->codePostalClient }}">
                            @if ($errors->has('postalCode'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('postalCode') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- button to validate the register form -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>
                        <input type="hidden" name="mail" value="{{$client->mailClient}}">
                        <button type="submit" class="btn btn-primary" name="editClient">Modifier </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-6">
                @if($dateFinaleSet)
                    <h3> Pour depenser votre <b>{{ $points }}</b> points restants, vous avez encore : </h3>
                    <div class="text-center"  id = "timeLeft">
                            <script> makeCounter2("timeLeft", "{{ $start }}" , "{{ $time }}" ) </script>
                    </div>
                @else
                    <h3> Aucun point disponible. </h3>
                @endif
            </div>
        </div>
    </div>
    <br>
    <div id="orders">
    <div class = "container-fluid">
        <h3> Votre historique d'achats :</h3>
    </div>
    <br>
    @if($processingOrders->count() != 0)
        <div class = "container-fluid">
            <h3>  Commande en cours : </h3>
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:5%">n° Commande</th>
                    <th class="text-center"  style="width:10%">Prix</th>
                    <th class="text-center"  style="width:10%">Magasin</th>
                    <th class="text-center"  style="width:40%">Produits</th>
                    <th class="text-center"  style="width:10%">Date achat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($processingOrders as $completed)
                    <tr>
                        <td data-th="Id" class="text-center" > {{$completed->numCommande}}</td>
                        <td data-th="Price" class="text-center" ><b>{{$completed->prixCommande}}€</b></td>
                        <td data-th="Store" class="text-center" ><a class="nomargin" href="/Piscine/public/commerces/{{$completed->numSiretCommerce}}"><b>{{$completed->store}} </b></a></td>
                        <td>
                        <div class = "container">
                            <table id="produits" class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th style="width:20%"class="text-center">Nom produit</th>
                                        <th style="width:10%"class="text-center">Quantite</th>
                                        <th style="width:20%"class="text-center">Couleur</th>
                                        <th style="width:20%"class="text-center">Taille</th>
                                        <th style="width:30%"class="text-center">Informations </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($completed->produits as $produit)
                                    <tr><td data-th="Nom produit" class="text-center" ><b>{{$produit[0]}}</b></td>
                                        <td data-th="Quantite" class="text-center" ><b>{{$produit[1]}}</b></td>
                                        <td data-th="Couleur" class="text-center"><b>{{$produit[2]}}</b></td>
                                        <td data-th="Size" class="text-center"><b>{{$produit[3]}}</b></td>
                                        <td data-th="method" class="text-center">
                                            @if($produit[4] == 1)
                                                <b><font color="red"> Produit à récupérer en magasin</font></b>
                                            @else
                                                <b> En livraison </b>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <td colspan="5" class="hidden-xs"></td>
                                </tfoot>
                            </table>
                        </div>
                        </td>
                        <td data-th="Purchase date" class="text-center"><b>{{$completed->dateCommande}}</b></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <td colspan="5" class="hidden-xs"></td>
                </tfoot>
            </table>
        </div>
    @endif
    <br>

    @if($completedOrders->count() <= 0 and $processingOrders->count() <=0)
        <div class = "container-fluid">
            <h4 class="text-center"> Votre historique d'achat est vide </h4>
        </div>
        <br>
        <br>

    @endif
    @if($completedOrders->count() != 0)<div class="container-fluid">
        <h3>  Commandes Terminées : </h3>
    </div>
    <br>
        <div class = "container-fluid">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:5%">N° Commande</th>
                    <th class="text-center"  style="width:10%">Prix</th>
                    <th class="text-center"  style="width:10%">Magasin</th>
                    <th class="text-center"  style="width:40%">Produits</th>
                    <th class="text-center"  style="width:10%">Date achat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($completedOrders as $completed)
                    <tr>
                        <td data-th="Id" class="text-center" > {{$completed->numCommande}}</td>
                        <td data-th="Price" class="text-center" ><b>{{$completed->prixCommande}}€</b></td>
                        <td data-th="Store" class="text-center" ><a class="nomargin" href="/Piscine/public/commerces/{{$completed->numSiretCommerce}}"><b>{{$completed->store}} </b></a></td>
                        <td>
                            <div class = "container">
                                <table id="produits" class="table table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th style="width:20%"class="text-center">Nom produit</th>
                                        <th style="width:10%"class="text-center">Quantité</th>
                                        <th style="width:20%"class="text-center">Couleur</th>
                                        <th style="width:20%"class="text-center">Taille</th>
                                        <th style="width:30%"class="text-center">Informations </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($completed->produits as $produit)
                                        <tr><td data-th="Nom produit" class="text-center" ><b>{{$produit[0]}}</b></td>
                                            <td data-th="Quantite" class="text-center" ><b>{{$produit[1]}}</b></td>
                                            <td data-th="Couleur" class="text-center"><b>{{$produit[2]}}</b></td>
                                            <td data-th="Size" class="text-center"><b>{{$produit[3]}}</b></td>
                                            <td data-th="method" class="text-center">
                                                @if($produit[4] == 1)
                                                    <b><font color="green">Produit Récupéré </font></b>
                                                @else
                                                    <b><font color="green"> En livraison </font></b>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <td colspan="4" class="hidden-xs"></td>
                                    </tfoot>
                                </table>
                            </div>
                        </td>
                        <td data-th="Purchase date" class="text-center"><b>{{$completed->dateCommande}}</b></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <td colspan="5" class="hidden-xs"></td>
                </tfoot>
            </table>
        </div>
    @endif
    </div>

@endsection
