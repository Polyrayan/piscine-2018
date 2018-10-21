@extends('navbar')
@section('content')
  <div class="container login-container">
    <div class="row">
      <div class="col-md-6 login-form-1">
        <h3> Client</h3>
        <form>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email *" value="" />
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="mot de passe *" value="" />
          </div>
          <div class="form-group">
            <input type="submit" class="btnSubmit" value="Se connecter" /> <br>
          </div>
          <div class="form-group">
            <input type="submit" class="btnSubmit" value="facebook" />
          </div>
          <div class="form-group">
            <a href="#" class="ForgetPwd">mot de passe oublié ?</a>
          </div>
        </form>
      </div>
      <div class="col-md-6 login-form-2">
        <h3> Commerçant</h3>
        <form>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email *" value="" />
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="mot de passe *" value="" />
          </div>
          <div class="form-group">
            <input type="submit" class="btnSubmit" value="Se connecter" />
          </div>
          <div class="form-group">

            <a href="#" class="ForgetPwd" value="Login">mot de passe oublié ?</a> <br>
            <a href="#admin" class="ForgetPwd" value="Login">admin</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
