@extends('navbars.navbarSeller')

@section('content')

    <br>

    <div class="container-fluid">
        <h1> Modification Vendeur : </h1>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-3">
                <form action="" method="post">
                {{  csrf_field()  }}

                    <!-- mail -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Email :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 col-form-label">
                            <p>{{ $seller->mailVendeur  }}</p>
                        </div>
                    </div>

                    <!-- name -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Nom :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="name" placeholder="nom" value="{{ $seller->nomVendeur }}">
                            @if ($errors->has('name'))
                                <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('name') }} </div> </small>
                            @endif
                        </div>
                    </div>

                    <!-- firstname -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Prénom :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" class="form-control" name="firstName" placeholder="prénom" value="{{ $seller->prenomVendeur }}">
                            @if ($errors->has('firstName'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('firstName') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- phone number -->
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label"> Téléphone :</label>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="tel" class="form-control"  name="phone" placeholder="telephone" value="{{ $seller->telVendeur }}">
                            @if ($errors->has('phone'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('phone') }} </div>  </small>
                            @endif
                        </div>
                    </div>

                    <!-- button to validate the register form -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"></div>
                        <input type="hidden" name="mail" value="{{$seller->mailVendeur}}">
                        <button type="submit" class="btn btn-primary" name="editSeller">Modifier </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
