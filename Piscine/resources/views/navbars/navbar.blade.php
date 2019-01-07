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
        <a class="logo" href="#"><img class="img-responsive logo" src="{{ URL::to('img/cci.png') }}" alt=""></a>
        <div class="container">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="./register" class="nav-link"> Inscription</a>
                </li>
                <li class="nav-item">
                    <a href="./login" class="nav-link"> Connexion </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<body>
    <div class="text-center">
        @include('flash::message')
    </div>
    @yield('content')
    
    <footer class="footer">
    
        <div class="row" style="background-color: #dbdcda">
            <div class="container">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <a href="/Piscine/public/contact" class="nav-link"> Nous contacter </a>
                            </td>
                            <td>
                                <a href="/Piscine/public/credits" class="nav-link"> Mentions légales </a>
                            </td>
                            <td>
                                <a href="https://www.facebook.com/CCIHerault/" class="nav-link" title="Facebook">
                                    <img class="img-responsive" src="{{ URL::to('img/facebook-logo.png') }}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="https://twitter.com/CCIHerault" class="nav-link" title="Twitter">
                                    <img class="img-responsive" src="{{ URL::to('img/twitter-logo.png') }}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="https://www.linkedin.com/company/cci-h%C3%A9rault" class="nav-link" title="LinkedIn">
                                    <img class="img-responsive" src="{{ URL::to('img/linkedin-logo.png') }}" alt="">
                                </a>
                            </td>
                            <td>
                                <div> <small>Icons made by</small> <a href="https://www.freepik.com/" title="Freepik"><small>Freepik</small></a><small> from </small><a href="https://www.flaticon.com/" title="Flaticon"><small>www.flaticon.com</small></a> <small>is licensed by</small> <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank"><small>CC 3.0 BY</small></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </footer>
    <script href="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
