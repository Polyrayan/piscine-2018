@extends('navbar')
@section('contenu')
  <h1> Connexion : </h1>
  <div class="container">
    <form class="form-inline" action="/register" method="post">
      {{  csrf_field()  }}
      <div class="form-group row">
        <!-- mail -->
        <div class="form-group">
          <label>Email: </label>
          <input type="email" class="form-control" name="mail" placeholder="e-mail" value="{{ old('mail') }}">
          @if ($errors->has('mail'))
            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mail') }} </div>  </small>
          @endif
        </div>
        <!-- password -->
        <div class="form-group">
          <label>Mot de passe:</label>
          <input type="password" class="form-control" name="password" placeholder="Mot de passe">
          @if ($errors->has('password'))
            <small><div class="alert alert-danger" role="alert"> {{ $errors->first('password') }} </div>  </small>
          @endif
        </div>
        <!-- button to validate the login form -->
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Se connecter">
        </div>
      </div>
    </form>
  </div>
@endsection
