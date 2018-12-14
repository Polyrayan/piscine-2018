@extends('navbars.navbarSeller')

@section('content')

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <h2> Mes commerces : </h2><br/>
            </div>
            <div class="col-lg-5">
                <form class="form-inline " method="post">
                    {{  csrf_field()  }}
                    <h5> Rejoindre un commerce : </h5>
                    <input name="mailSeller" type="hidden" value="{{$mailSeller}}">
                    <input type="text" name="numShop"  placeholder="numéro SIRET" class="form-control">
                    <input type="text" name="codeShop"  placeholder="code Recrutement" class="form-control">
                    <button class="btn btn-primary" name="join"> Rejoindre </button>
                </form>

            </div>
        </div>
    </div>

    @foreach($shops as $shop)
        <ul>
                <form class ="input-group" style="display: inline-block" method="POST">
                    {{  csrf_field()  }}
                    <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-1">
                                    <h3>{{$shop->nomCommerce}}</h3>
                                </div>
                                <div class="col-lg-4">
                                    <!-- visit  -->
                                    <input name="shopName" type="hidden" value="{{$shop->nomCommerce}}">
                                    <button class="btn btn-primary" name="visit"  value="{{ $shop->numSiretCommerce }}"> visiter </button>

                                    <!-- orders -->
                                    <input name="siretNumber" type="hidden" value="{{$shop->numSiretCommerce}}">
                                    <button  class="btn btn-info" name="sales"> Ventes  <span class="badge badge-light"> {{$orders->where('numSiretCommerce',$shop->numSiretCommerce)->count()}} </span> </button>

                                    <!-- quit  -->
                                    <input name="mailSeller" type="hidden" value="{{$shop->mailVendeur}}">
                                    <button class="btn btn-danger"  name="quit" value="{{ $shop->numSiretCommerce }}"> quitter </button>
                                </div>
                            </div>
                    </div>
                </form>
        </ul>
    @endforeach




@endsection