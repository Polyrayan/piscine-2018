@extends('navbars.navbar')

@section('content')

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3"></div>
            <div class="col-md-6 login-form-2">
                <h3> Administateur </h3>
                <form method="post">
                    {{  csrf_field()  }}
                    <div class="form-group">
                        <input type="email" class="form-control" name="mailAdmin" placeholder="Email *" value="{{ old('mailAdmin') }}">
                        @if ($errors->has('mailAdmin'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mailAdmin') }} </div>  </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="passwordAdmin" placeholder="Mot de passe *">
                        @if ($errors->has('passwordAdmin'))
                            <div class="alert alert-danger" role="alert"> {{ $errors->first('passwordAdmin') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="loginAdmin">Se connecter </button>
                    </div>
                    <div class="form-group">
                        <a href="../login" class="ForgetPwd"> Je ne suis pas un administrateur </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
