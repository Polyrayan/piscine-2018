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
                <a href="\Piscine\public\reductions" class="nav-link"> Les bons plans </a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\profil" class="nav-link">Profil</a>
            </li>
            <li class="nav-item">
                <a  href="\Piscine\public\client\profil" class="nav-link">Points</a>
            </li>
            <li class="nav-item">
                <a  href="#" class="nav-link">Comparer</a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\{{$id}}\reservations" class="nav-link">Reservation</a>
            </li>
            <li class="nav-item">
                <a href="\Piscine\public\client\{{$id}}\panier" class="nav-link">Panier</a>
            </li>

        </ul>
        <ul class="navbar-nav ml-auto ">
            <li class="nav-item">
                <a  href="\Piscine\public\client\deconnexion" class="nav-link"> deconnexion </a>
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
