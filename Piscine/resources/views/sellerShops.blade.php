@extends('navbars.navbarSeller')

@section('content')

    <br>
    <form class="col-md-5 col-sm-5 col-lg-3 input-group pull-right" method="post" action="">
        {{  csrf_field()  }}
        <input type="text" name="nameShop"  placeholder="nom Commerce" class="form-control"
        maxlength="200">
        <input type="text" name="codeShop"  placeholder="code Recrutement" class="form-control"
        maxlength="200">
        <span class="input-group-btn"> <input type="submit" class="btn btn-primary btn-group" name="join" value="Rejoindre"> </span>
    </form>
    <br>

    <h3> Mes commerces : </h3>

        <ul>
            @foreach($shops as $shop)
                <li> {{$shop->nomCommerce}} </li>
                         <form class = "form-inline" method="POST" action="">
                             {{  csrf_field()  }}
                             <input name="shopName" type="hidden" value="{{$shop->nomCommerce}}">
                             <span class="input-group-btn">
                                <button class="btn-primary" name="visit" value="{{ $shop->numSiretCommerce }}"> visiter </button>
                             </span>
                         </form>
                        <p> faire le controller qui redirige vers la vue du commerce pour ajouter,modifier,supprimer les produits </p>
                        <form class = "form-inline" method="POST" action="">
                            {{  csrf_field()  }}
                            <input name="mailSeller" type="hidden" value="{{$shop->mailVendeur}}">
                            <span class="input-group-btn">
                                <button class="btn-danger" name="quit" value="{{ $shop->numSiretCommerce }}"> quitter </button>
                            </span>
                        </form>
            @endforeach

        </ul>


@endsection