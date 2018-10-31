<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{ URL::asset('css/register.css') }}" />
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">


                        <ul class="tab_frm">
                            <li><a href="#" class="active" id="login-form-link">Client</a></li>
                            <li>	<a href="#" id="register-form-link">Vendeur</a></li>
                        </ul>

                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="http://phpoll.com/login/process" method="post" role="form" style="display: block;">
                                    <div class="container">
                                        <form action="" method="post">
                                            {{  csrf_field()  }}

                                            <div class="form-group ">
                                                <!-- gender -->
                                                <label class="col-sm-2 col-form-label"> Vous êtes un(e) :</label>
                                                <div class="class="col-sm-6 col-sm-offset-3">
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
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                        <label for="remember"> Remember Me</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="register-form" action="http://phpoll.com/register/process" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/register.js') }}"></script>
</body>
