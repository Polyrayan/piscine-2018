@extends('navbars.navbarSeller')

@section('content')

    <br>
    <form class="col-md-5 col-sm-5 col-lg-3 input-group pull-right" method="POST">
        <input type="text" name="search" id="id_search"  placeholder="nom Commerce" class="form-control"
        maxlength="200">
        <input type="text" name="search" id="id_search"  placeholder="code Recrutement" class="form-control"
        maxlength="200">
        <span class="input-group-btn"> <input type="submit" class="btn btn-primary btn-group" name="action" value="Rejoindre"> </span>
    </form>
    <br>

    <h3> Mes commerces : </h3>

        <ul>
            @foreach($shops as $shop)
                <li> {{$shop->nomCommerce}} </li>
                         <form class = "form-inline" method="POST" action="">
                             <span class="input-group-btn">
                                <button class="btn-primary" name="action" value="{{ $shop->numSiretCommerce }}"> visiter </button>
                             </span>
                         </form>
                        <p> faire le controller qui redirige vers la vue du commerce pour ajouter,modifier,supprimer les produits </p>
                        <form class = "form-inline" method="POST" action="">
                            <span class="input-group-btn">
                                <button class="btn-danger" name="action" value="{{ $shop->numSiretCommerce }}"> quitter </button>
                            </span>
                        </form>
            @endforeach

        </ul>


@endsection