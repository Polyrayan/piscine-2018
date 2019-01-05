@extends('navbars.navbarClient')

@section('content')

    <br>
    <h1> Modification Client: </h1>

    <div class="container-fluid">
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
                        <button type="submit" class="btn btn-primary" name="editClient">modifier </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-4">
                <h3> Points de réductions : {{ $points }}</h3>
            </div>
        </div>
    </div>
    <br>
    <div class = "container-fluid">
        <h3> Historique d'achats de {{$client->nomClient}} </h3>
    </div>
    @if($completedOrders->count() <= 0)
        <div class = "container-fluid">
            <h4> Votre historique d'achat est vide <h4>
        </div>
    @endif
    @if($completedOrders->count() != 0)
        <div class = "container-fluid">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th rowspan="2" style="width:10%">Commande Code</th>
                    <th rowspan="2" class="text-center"  style="width:20%">Prix</th>
                    <th rowspan="2" class="text-center"  style="width:20%">Magasin</th>
                    <th colspan="2" class="text-center" style="width:20%">Produits</th>
                    <th rowspan="2" class="text-left"  style="width:30%">Date achat</th>
                </tr>
                    <tr>
                        <th>Nom</th>
                        <th>Qte</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($completedOrders as $completed)
                    <tr>
                        <td data-th="Commande Code"> {{$completed->numCommande}}</td>
                        <td data-th="Prix" class="text-center" ><b>{{$completed->prixCommande}}€</b></td>
                        <td data-th="Magasin" class="text-center" ><b>{{$completed->store}}</b></td>
                        <td data-th="Produits" class = "container-fluid" >
                            <div class = "container-fluid">
                                <table id="cart" class="table table-hover table-condensed">
                                    <tbody>
                                    @foreach($completed->produits as $produit)
                                        <tr>
                                            <td data-th="Nom">{{$produit[0]}}</td>
                                            <td data-th="Qte">{{$produit[1]}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td data-th="Purchase date" class="text-right"><b>{{$completed->dateCommande}}</b></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif


@endsection