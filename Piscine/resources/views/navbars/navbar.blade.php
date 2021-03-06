<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/nav.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/shoppingCart.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/product.css') }}" />
</head>

<nav class="navbar navbar-expand-md sticky-top " style="background-color: #dbdcda">
    
    <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target" data-spy="affix"  data-offset-top="100">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="collapse_target">
        <a href="#" class="navbar-brand"><img class="img-responsive" style="height: 50px; width: 50px;" src="{{ URL::to('img/cci.png') }}" alt=""></a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="./register" class="nav-link"> Inscription</a>
                </li>
                <li class="nav-item">
                    <a href="./login" class="nav-link"> Connexion </a>
                </li>
            </ul>
    </div>
</nav>


<body>
    <div class="text-center">
        @include('flash::message')
    </div>
    @yield('content')

    <script href="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
