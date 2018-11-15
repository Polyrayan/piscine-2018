@extends('navbars.navbar')

@section('content')

<h1> Page d'accueil </h1>

<div class="container">
    </div>
    <div class="row text-center">
        <div class="col">
            <div class="counter">
                <i class="fa fa-code fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="100" data-speed="1500"></h2>
                <p class="count-text ">Our Customer</p>
            </div>
        </div>
        <div class="col">
            <div class="counter">
                <i class="fa fa-coffee fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="1700" data-speed="1500"></h2>
                <p class="count-text ">Happy Clients</p>
            </div>
        </div>
        <div class="col">
            <div class="counter">
                <i class="fa fa-lightbulb-o fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
                <p class="count-text ">Project Complete</p>
            </div></div>
        <div class="col">
            <div class="counter">
                <i class="fa fa-bug fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="157" data-speed="1500"></h2>
                <p class="count-text ">Coffee With Clients</p>
            </div>
        </div>
    </div>
</div>

    <h2> Produits </h2>

    <ul>
        @foreach($products as $product)
            <li> {{$product->nomProduit}}  <a  href="\Piscine\public\vendeur\{{$product->numProduit}}"> acheter </a> <a  href="\Piscine\public\vendeur\{{$product->numProduit}}"> reserver </a></li>
        @endforeach
    </ul>


@endsection
