@extends('navbars.navbar')

@section('content')
    <div class = "container-fluid">
        <h1> Profil du vendeur {{$seller->nomVendeur}}</h1>

        <p> Nom      : {{$seller->nomVendeur}} </p>
        <p> Prénom   : {{$seller->prenomVendeur}} </p>
        <p> mail     : {{$seller->mailVendeur}}</p>
        <P> portable : {{$seller->telVendeur}}</P>

        <h1> commerces de {{$seller->nomVendeur}} </h1>
        <ul>
            @foreach($shops as $shop)
                <li> <a  href="\Piscine\public\commerces\{{$shop->numSiretCommerce}}"> {{$shop->nomCommerce}} </a> </li>
                @endforeach
        </ul>
    </div>


@endsection