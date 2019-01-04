<link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<script src="//netdna.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/4.0.0/jquery.min.js"></script>
<link rel="stylesheet" href="{{ URL::asset('css/nav.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/shoppingCart.css') }}" />
<!------ Include the above in your HEAD tag ---------->

<nav class="navbar navbar-expand-md sticky-top " style="background-color: #dbdcda">

    <button class="navbar-toggler navbar-light" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="collapse_target">

        <a href="#" class="logo"><img class="img-responsive logo" src="{{ URL::to('img/cci.png') }}" alt=""></a>
        <ul class="navbar-nav mr-auto">
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>

            <li class="nav-item ">
                <a href="\Piscine\public\vendeur\commerces" class="nav-link"> Mes commerces </a>
            </li>
            @if(!is_null($favoriteShop))
                <li class="nav-item">
                    <a href="\Piscine\public\vendeur\commerces\{{$favoriteShop}}" class="nav-link"> Visiter </a>
                </li>
                <li class="nav-item">
                    <a href="\Piscine\public\vendeur\commerces\{{$favoriteShop}}\ventes" class="nav-link"> Ventes </a>
                </li>
                <li class="nav-item">
                    <a  href="\Piscine\public\vendeur\commerces\{{$favoriteShop}}\horaires" class="nav-link"> Horaires </a>
                </li>
                <li class="nav-item">
                    <a  href="\Piscine\public\vendeur\commerces\{{$favoriteShop}}\coupons" class="nav-link"> Coupons </a>
                </li>
            @endif

        </ul>
        <ul class="navbar-nav ml-auto">
            @if($adminConnected)
                <li class="nav-item">
                    <a  href="\Piscine\public\admin" class="nav-link"> <font color="#DF3A01"> arreter l'aide et revenir à la page admin </font> </a>
                </li>
            @else
                <li class="nav-item">
                    <a  href="" class="nav-link"> Aide </a>
                </li>
                <li class="nav-item">
                    <a  href="\Piscine\public\vendeur\deconnexion" class="nav-link"> Déconnexion </a>
                </li>
            @endif
        </ul>
    </div>
</nav>

<body>
    <div class="text-center">
        @include('flash::message')
    </div>
  @yield('content')
</body>
