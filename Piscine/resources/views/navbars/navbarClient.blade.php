<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="{{ URL::asset('css/nav.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/shoppingCart.css') }}" />
<script type="text/javascript" src="{{ URL::asset('js/countDown.js') }}"></script>

<nav class="navbar navbar-expand-md sticky-top " style="background-color: #dbdcda">

    <button class="navbar-toggler navbar-light" data-toggle="collapse" data-target="#collapse_target">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="collapse_target">

        <a href="#" class="logo"><img class="img-responsive logo" src="{{ URL::to('img/cci.png') }}" alt=""></a>
        <ul class="navbar-nav mx-auto">
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>
            <a class="navbar-brand" href=""></a>

            <li class="nav-item ">
                <a href="\Piscine\public\" class="nav-link"> Accueil </a>
            </li>
            <li class="nav-item ">
                <a href="\Piscine\public\client\{{$id}}\bonsPlans" class="nav-link"> Les bons plans </a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\profil" class="nav-link">Profil & Points</a>
            </li>
            <li class="nav-item">
                <a  href="\Piscine\public\MesComparaisons" class="nav-link">Comparer<span class="badge badge-light">{{$nbCompare}}</span></a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\{{$id}}\reservations" class="nav-link">Réservation</a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\{{$id}}\panier" class="nav-link">Panier</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item">
                <a  href="\Piscine\public\client\deconnexion" class="nav-link"> Déconnexion </a>
            </li>
        </ul>

    </div>
</nav>

<body>
<div class="text-center">
    @include('flash::message')
</div>
@yield('content')

</body>

<nav class="navbar navbar-expand-md" style="background-color: #dbdcda">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="./contact" class="nav-link"> Nous contacter </a>
            </li>
            <li class="nav-item">
                <a href="./credits" class="nav-link"> Mentions légales </a>
            </li>
            <li class="nav-item">
                <a href="https://www.facebook.com/CCIHerault/" class="nav-link">
                    <img class="img-responsive" src="{{ URL::to('img/facebook_128.png') }}" alt="" width="64" height="64">
                </a>
            </li>
            <li class="nav-item">
                <a href="https://twitter.com/CCIHerault" class="nav-link">
                    <img class="img-responsive" src="{{ URL::to('img/twitter-128.png') }}" alt="" width="80" height="80">
                </a>
            </li>
            <li class="nav-item">
                <a href="https://www.linkedin.com/company/cci-h%C3%A9rault" class="nav-link">
                    <img class="img-responsive" src="{{ URL::to('img/linkedin-128.png') }}" alt="" width="64" height="64">
                </a>
            </li>
        </ul>
    </div>
</nav>
