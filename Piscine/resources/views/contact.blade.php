@extends('navbars.navbar')

@section('content')
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7">
            <h3> Contactez-nous </h3>
            <form method="post">
                {{  csrf_field()  }}
                <div class="form-group">
                    <input type="email" class="form-control" name="mail" placeholder="Email *" value="{{ old('mailClient') }}">
                    <!-- @if ($errors->has('mailClient'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mailClient') }} </div>  </small>
                    @endif -->
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="Objet...">
                </div>
                <div class="form-group">
                    <textarea type="text" class="form-control" name="textMessage" placeholder="Tapez votre message..." cols="40" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submitMessage"> Envoyer </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection