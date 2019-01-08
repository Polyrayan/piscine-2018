@extends('navbars.navbarAdmin')

@section('content')
    <br>
<div class="container-fluid">
    <div class="row">
        <!-- Ajout -->
        <div class="form col-lg-4">
            <h3> Ajouter une Catégorie : </h3> <br>

            <form action="" method="post">
                {{  csrf_field()  }}
                <div class="form">
                    <div class="row">

                        <!-- nom -->
                        <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Nom" placeholder="Nom" value="{{ old('nomTypeProduit') }}">
                        </div>

                        <!-- temps -->
                        <label class="col-sm-4 col-form-label">Le temps de réservation :</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="temps" placeholder="temps (en minutes)"  value="{{ old('tempsReservation') }}">
                        </div>


                        <!-- button to add the category -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary" name="add"> Ajouter </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modification -->
        <div class="form col-lg-4">
            <h3> Modifier une Catégorie : </h3> <br>

            <form action="" method="post">
                {{  csrf_field()  }}
                <div class="form">
                    <div class="row">

                        <!-- nom -->
                        <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                        <div class="col-sm-8">
                            <select name="Nom" class="form-control">
                                <option value="{{ old('nomTypeProduit') }}">--Choisissez une categorie--</option>
                                @foreach($categories as $categorie)
                                    <option value={{$categorie->nomTypeProduit}}>{{$categorie->nomTypeProduit}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- temps -->
                        <label class="col-sm-4 col-form-label">Le temps de réservation :</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="temps" placeholder="temps (en minutes)"  value="{{ old('tempsReservation') }}">
                        </div>


                        <!-- button to modif the category -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary" name="modifier"> Modifier </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <!-- Supression -->
        <div class="form col-lg-4">
            <h3> Supprimer une Catégorie : </h3> <br>

            <form action="" method="post">
                {{  csrf_field()  }}
                <div class="form">
                    <div class="row">

                        <!-- nom -->
                        <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                        <div class="col-sm-8">
                            <select name="Nom" class="form-control">
                                <option value="{{ old('nomTypeProduit') }}">--Choisissez une categorie--</option>
                                @foreach($categories as $categorie)
                                    <option value={{$categorie->nomTypeProduit}}>{{$categorie->nomTypeProduit}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- button to delete the category -->
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary" name="delete"> Supprimer </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
        <h3> Prendre le contrôle d'un commerçant : </h3>
        <div class="row">
            <div class="col-lg-5">
                <form class="form-inline " method="post">
                    {{  csrf_field()  }}
                    <div class="col-lg-1"></div>
                    <div class="col-lg-6">
                        @if ($errors->has('connect'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('connect') }} </div>  </small>
                        @endif
                    </div>
                    <div class="col-lg-5"></div>
                    <div class="col-lg-1"></div>
                    <h5> Avec son mail : </h5>
                    <input type="email" name="mailSeller"  placeholder="email *" class="form-control">
                    <button class="btn btn-primary" name="connect"> Connexion </button>
                </form>
            </div>
        </div>
</div>


@endsection
