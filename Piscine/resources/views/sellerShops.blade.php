@extends('navbars.navbarSeller')

@section('content')

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <h2> Mes commerces : </h2><br/>
            </div>
            <div class="col-lg-5">
                <form class="form-inline " method="post">
                    {{  csrf_field()  }}

                    <h5> Rejoindre un commerce : </h5>
                    <input name="mailSeller" type="hidden" value="{{$mailSeller}}">
                    <input type="text" name="numShop"  placeholder="numéro SIRET" class="form-control">
                    <input type="text" name="codeShop"  placeholder="code Recrutement" class="form-control">
                    <button class="btn btn-primary" name="join"> Rejoindre </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                @foreach($shops as $shop)
                    <ul>
                        <form class ="input-group" style="display: inline-block" method="POST">
                            {{  csrf_field()  }}
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <h3>{{$shop->nomCommerce}}</h3>
                                    </div>
                                    <div class="col-lg-4">
                                        <input name="shopName" type="hidden" value="{{$shop->nomCommerce}}">
                                        <input name="siretNumber" type="hidden" value="{{$shop->numSiretCommerce}}">
                                        <input name="mailSeller" type="hidden" value="{{$shop->mailVendeur}}">
                                        <!-- visit  -->
                                        <button class="btn btn-primary" name="visit"  value="{{ $shop->numSiretCommerce }}"> visiter </button>
                                        <!-- orders -->
                                        <button  class="btn btn-info" name="sales"> Ventes  <span class="badge badge-light"> {{$orders->where('numSiretCommerce',$shop->numSiretCommerce)->count()}} </span> </button>
                                        <!-- quit  -->
                                        <button class="btn btn-danger"  name="quit" value="{{ $shop->numSiretCommerce }}"> quitter </button>
                                        <!favorite>
                                        @if ($shop->numSiretCommerce == $favoriteShop)
                                            <button class="btn bg-light" name="favorite"><i class="fas fa-star"></i></button>
                                        @else
                                            <button class="btn bg-light" name="favorite"> <i class="far fa-star"></i> </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </ul>
                @endforeach
            </div>
            <div class="col-lg-3">
                <h3> Créer un commerce : </h3>
                <form method="POST">
                    {{  csrf_field()  }}
                    <div class="form-group ">

                        <!-- numSiret -->
                        <div class="row">
                        <label class="col-sm-4 col-form-label"> Numéro SIRET :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numSiret" placeholder="numéro SIRET*" value="{{ old('numSiret') }}">
                                @if ($errors->has('numSiret'))
                                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('numSiret') }} </div> </small>
                                @endif
                            </div>
                        </div>

                        <!-- name -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label"> Nom du commerce :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="nom *" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('name') }} </div> </small>
                                @endif
                            </div>
                        </div>

                        <!-- libelle -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label"> Libelle commerce :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="description" placeholder="description *" value="{{ old('description') }}">
                                @if ($errors->has('description'))
                                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div> </small>
                                @endif
                            </div>
                        </div>


                        <!-- code commerce -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Code commerce:</label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" name="recruitmentCode" placeholder="code pour rejoindre ce commerce *" value="{{ old('recruitmentCode') }}">
                                @if ($errors->has('recruitmentCode'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('recruitmentCode') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- phone number -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Téléphone :</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control"  name="phone" placeholder="telephone du commerce *" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- address -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Adresse :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address"placeholder="15 rue Exemple *" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('address') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- city -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Ville :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="city" placeholder="Ville du commerce *" value="{{ old('city') }}">
                                @if ($errors->has('city'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('city') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- zip code -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Code postal :</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="zipCode" placeholder="code postal du commerce *" value="{{ old('zipCode') }}">
                                @if ($errors->has('zipCode'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('zipCode') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- region -->
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Région :</label>
                            <div class="col-sm-8">
                                <select name="region" class="form-control">
                                    <option> Languedoc-Roussillon </option>
                                    <option> Aude </option>
                                    <option> Gard </option>
                                    <option> Hérault </option>
                                    <option> Lozère </option>
                                    <option> Pyrénées-Orientales </option>
                                </select>
                                @if ($errors->has('region'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('region') }} </div>  </small>
                                @endif
                            </div>
                        </div>

                        <!-- button to join a store -->
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <input type="hidden" name="sellerMail" value="{{$mailSeller}}">
                                <button type="submit" class="btn btn-primary" name="addStore"> Ajouter </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>






@endsection
