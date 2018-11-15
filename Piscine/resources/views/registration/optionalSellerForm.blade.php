@extends('navbars.navbar')

@section('content')

    <h1> Rejoindre votre commerce </h1>

    <div class="container">
        <form action="" method="post">
            {{  csrf_field()  }}

            <div class="form-group ">

                <!-- numSiret -->
                <label class="col-sm-2 col-form-label"> numéro SIRET :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="numSiret" placeholder="nom" value="{{ old('numSiret') }}">
                @if ($errors->has('numSiret'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('numSiret') }} </div> </small>
                    @endif
                </div>

                <!-- code commerce -->
                <label class="col-sm-2 col-form-label">code commerce:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="joinCode" placeholder="code pour rejoindre le commerce" value="{{ old('joinCode') }}">
                @if ($errors->has('joinCode'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('joinCode') }} </div>  </small>
                    @endif
                </div>

                <!-- button to join a store -->
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" name="action" value="joinStore">Rejoindre </button>
                </div>
            </div>
        </form>
    </div>

    <h1> Ajouter votre commerce </h1>
    <div class="container">
        <form action="" method="post">
            {{  csrf_field()  }}

            <div class="form-group ">

                <!-- numSiret -->
                <label class="col-sm-2 col-form-label"> numéro SIRET :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="numSiret" placeholder="numéro SIRET*" value="{{ old('numSiret') }}">
                    @if ($errors->has('numSiret'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('numSiret') }} </div> </small>
                    @endif
                </div>

                <!-- name -->
                <label class="col-sm-2 col-form-label"> nom du commerce :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="nom *" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('name') }} </div> </small>
                    @endif
                </div>

                <!-- libelle -->
                <label class="col-sm-2 col-form-label"> libelle commerce :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="description" placeholder="description *" value="{{ old('description') }}">
                    @if ($errors->has('description'))
                        <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('description') }} </div> </small>
                    @endif
                </div>

                <!-- code commerce -->
                <label class="col-sm-2 col-form-label">code commerce:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="recruitmentCode" placeholder="code pour rejoindre ce commerce *" value="{{ old('recruitmentCode') }}">
                    @if ($errors->has('recruitmentCode'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('recruitmentCode') }} </div>  </small>
                    @endif
                </div>

                <!-- phone number -->
                <label class="col-sm-2 col-form-label">Telephone :</label>
                <div class="col-sm-10">
                    <input type="tel" class="form-control"  name="phone" placeholder="telephone du commerce *" value="{{ old('phone') }}">
                    @if ($errors->has('phone'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
                    @endif
                </div>

                <!-- address -->
                <label class="col-sm-2 col-form-label">adresse :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address"placeholder="15 rue Exemple *" value="{{ old('address') }}">
                    @if ($errors->has('address'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('address') }} </div>  </small>
                    @endif
                </div>

                <!-- city -->
                <label class="col-sm-2 col-form-label">ville :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="city" placeholder="Ville du commerce *" value="{{ old('city') }}">
                    @if ($errors->has('city'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('city') }} </div>  </small>
                    @endif
                </div>

                <!-- zip code -->
                <label class="col-sm-2 col-form-label">code postal du commerce :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="zipCode" placeholder="code postal du commerce *" value="{{ old('zipCode') }}">
                    @if ($errors->has('zipCode'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('zipCode') }} </div>  </small>
                    @endif
                </div>

                <!-- css file -->
                <label class="col-sm-6 col-form-label">ajouter votre liste de produit au format css:</label>
                <div class="col-sm-10 col-form-label">
                    <input type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile"> Choisir un fichier (optionnel)</label>
                </div>

                <!-- button to join a store -->
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="action" value="addStore"> Ajouter </button>
                </div>
            </div>
        </form>
    </div>
@endsection