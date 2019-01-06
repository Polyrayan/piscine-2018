@extends('navbars.navbar')

@section('content')
    <div class = "container-fluid">
        <h1> Profil du vendeur {{$seller->nomVendeur}}</h1>

        <p> Nom      : {{$seller->nomVendeur}} </p>
        <p> Prénom   : {{$seller->prenomVendeur}} </p>
        <p> Mail     : {{$seller->mailVendeur}}</p>
        <P> Portable : {{$seller->telVendeur}}</P>

        <h1> Commerces de {{$seller->nomVendeur}} </h1>
        <ul>
            @foreach($shops as $shop)
                <li> <a  href="\Piscine\public\commerces\{{$shop->numSiretCommerce}}"> {{$shop->nomCommerce}} </a> </li>
                @endforeach
        </ul>
    </div>


@endsection
