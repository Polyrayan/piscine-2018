@extends('navbar')
@section('content')

  <h1> Inscription Client: </h1>
  <div class="container">
    <form action="" method="post">
      {{  csrf_field()  }}

      <div class="form-group ">
        <!-- gender -->
        <label class="col-sm-2 col-form-label"> Vous êtes un(e) :</label>
        <div class="col-sm-10">
          <input class="form-check-input" type="radio" name="gender" id="M" value="male">
          <label class="form-check-label" for="M"> homme </label>
          <input class="form-check-input" type="radio" name="gender" id="F" value="female">
          <label class="form-check-label" for="F"> femme </label>
          @if ($errors->has('gender'))
          <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('gender') }} </div> </small>
          @endif
        </div>
        <!-- name -->
        <label class="col-sm-2 col-form-label">Nom :</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" placeholder="nom" value="{{ old('name') }}">
          @if ($errors->has('name'))
            <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('name') }} </div> </small>
          @endif
        </div>
        <!-- firstname -->
        <label class="col-sm-2 col-form-label">Prénom :</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="firstName" placeholder="prénom" value="{{ old('firstName') }}">
          @if ($errors->has('firstName'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('firstName') }} </div>  </small>
          @endif
        </div>
        <!-- mail -->
        <label class="col-sm-2 col-form-label">Email :</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="mail" placeholder="e-mail" value="{{ old('mail') }}">
          @if ($errors->has('mail'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mail') }} </div>  </small>
          @endif
        </div>
        <!-- password -->
        <label class="col-sm-2 col-form-label">Mot de passe :</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="password" placeholder="Mot de passe">
          <small id="passwordHelpBlock" class="form-text text-muted">
            votre mot de passe doit contenir au moins 6 caractères
            @if ($errors->has('password'))
              <div class="alert alert-danger" role="alert"> {{ $errors->first('password') }} </div>
            @endif
          </small>
        </div>
        <!-- password confirmation -->
        <label class="col-sm-2 col-form-label">Mot de passe :</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmer le mot de passe">
          @if ($errors->has('password_confirmation'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('password_confirmation') }} </div>  </small>
          @endif
        </div>
        <!-- phone number -->
        <label class="col-sm-2 col-form-label">Telephone :</label>
        <div class="col-sm-10">
          <input type="tel" class="form-control"  name="phone" placeholder="telephone" value="{{ old('phone') }}">
          @if ($errors->has('phone'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
          @endif
        </div>
        <!-- address -->
        <label class="col-sm-2 col-form-label">Adresse :</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="address"placeholder="15 rue Exemple" value="{{ old('address') }}">
          @if ($errors->has('address'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('address') }} </div>  </small>
          @endif
        </div>
        <!-- city -->
        <label class="col-sm-2 col-form-label">ville :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="city" placeholder="Ville" value="{{ old('city') }}">
            @if ($errors->has('city'))
              <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('city') }} </div>  </small>
            @endif
        </div>
      <!-- postal code -->
        <label class="col-sm-2 col-form-label">Code Postal :</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="postalCode" placeholder="34000" value="{{ old('postalCode') }}">
          @if ($errors->has('postalCode'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('postalCode') }} </div>  </small>
          @endif
        </div>
        <!-- birthday -->
        <label class="col-sm-2 col-form-label">Date de naissance :</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">
            @if ($errors->has('birthday'))
              <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('birthday') }} </div>  </small>
            @endif
        </div>
      </div>

      <!-- button to validate the register form -->
      <button type="submit" class="btn btn-primary" name="action" value="submitClient">S'inscrire </button>
    </form>
  </div>

  <h1> Inscription Vendeur : </h1>
  <div class="container">
    <form action="" method="post">
      {{  csrf_field()  }}

      <div class="form-group ">
        <!-- name -->
        <label class="col-sm-2 col-form-label">Nom :</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="nameSeller" placeholder="nom" value="{{ old('nameSeller') }}">
          @if ($errors->has('nameSeller'))
            <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('nameSeller') }} </div> </small>
          @endif
        </div>
        <!-- firstname -->
        <label class="col-sm-2 col-form-label">Prénom :</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="firstNameSeller" placeholder="prénom" value="{{ old('firstNameSeller') }}">
          @if ($errors->has('firstNameSeller'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('firstNameSeller') }} </div>  </small>
          @endif
        </div>
        <!-- mail -->
        <label class="col-sm-2 col-form-label">Email :</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="mailSeller" placeholder="e-mail" value="{{ old('mailSeller') }}">
          @if ($errors->has('mailSeller'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mailSeller') }} </div>  </small>
          @endif
        </div>
        <!-- password -->
        <label class="col-sm-2 col-form-label">Mot de passe :</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="passwordSeller" placeholder="Mot de passe">
          <small id="passwordHelpBlock" class="form-text text-muted">
            votre mot de passe doit contenir au moins 6 caractères
            @if ($errors->has('passwordSeller'))
              <div class="alert alert-danger" role="alert"> {{ $errors->first('passwordSeller') }} </div>
          @endif
          </small>
        </div>
        <!-- password confirmation -->
        <label class="col-sm-2 col-form-label">Mot de passe :</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="password_confirmationSeller" placeholder="Confirmer le mot de passe">
          @if ($errors->has('password_confirmationSeller'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('password_confirmationSeller') }} </div>  </small>
          @endif
        </div>
        <!-- phone number -->
        <label class="col-sm-2 col-form-label">Telephone :</label>
        <div class="col-sm-10">
          <input type="tel" class="form-control"  name="phoneSeller" placeholder="telephone" value="{{ old('phoneSeller') }}">
          @if ($errors->has('phoneSeller'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phoneSeller') }} </div>  </small>
          @endif
        </div>
      </div>

      <!-- button to validate the register form -->
      <button type="submit" class="btn btn-primary" name="action" value="submitSeller">S'inscrire </button>
    </form>
  </div>

@endsection
