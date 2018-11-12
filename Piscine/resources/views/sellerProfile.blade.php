@extends('navbars.navbarSeller')

@section('content')


    <h1> Modification Vendeur : </h1>

    <div class="container">
        <form action="" method="post">

            {{  csrf_field()  }}

            <div class="form-group ">

                <!-- mail -->
                <label class="col-sm-2 col-form-label">Email :</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="mail" placeholder="e-mail" value="{{ old('mail') }}">
                    @if ($errors->has('mail'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mail') }} </div>  </small>
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

                <!-- phone number -->
                <label class="col-sm-2 col-form-label">Telephone :</label>
                <div class="col-sm-10">
                    <input type="tel" class="form-control"  name="phone" placeholder="telephone" value="{{ old('phone') }}">
                    @if ($errors->has('phone'))
                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
                    @endif
                </div>

            </div>

            <!-- button to validate the register form -->
            <button type="submit" class="btn btn-primary" name="action" value="edit">modifier </button>
        </form>
    </div>


@endsection