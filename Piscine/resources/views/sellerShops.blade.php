@extends('navbars.navbarSeller')

@section('content')

    <br>
    <div class="text-right container col-lg-11">
        <h4> Rejoindre un commerce </h4>
    </div>
    <form class=" pull-right form-horizontal form-inline " method="post">
        <input name="mailSeller" type="hidden" value="{{$mailSeller}}">
        {{  csrf_field()  }}
        <input type="text" name="numShop"  placeholder="numéro SIRET" class="form-control">
        <input type="text" name="codeShop"  placeholder="code Recrutement" class="form-control">
        <button class="btn btn-primary" name="join"> Rejoindre </button>
    </form>

    <br>

    <h3> Mes commerces : </h3>
    @foreach($shops as $shop)
        <ul>

            <form class ="input-group" style="display: inline-block" method="POST">
                <li> {{$shop->nomCommerce}}
                    {{  csrf_field()  }}

                    <!-- visit  -->
                    <input name="shopName" type="hidden" value="{{$shop->nomCommerce}}">
                    <button class="btn btn-primary btn-group" name="visit"  value="{{ $shop->numSiretCommerce }}"> visiter </button>

                    <!-- quit  -->
                    <input name="mailSeller" type="hidden" value="{{$shop->mailVendeur}}">
                    <button class="btn btn-danger btn-group"  name="quit" value="{{ $shop->numSiretCommerce }}"> quitter </button>
                </li>
            </form>


        </ul>
        @endforeach



@endsection