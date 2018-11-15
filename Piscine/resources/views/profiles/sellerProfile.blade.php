@extends('navbars.navbar')

@section('content')
    <div class = "container-fluid">
        <h1> Profil du vendeur {{$seller->nomVendeur}}</h1>

        <p> Nom      : {{$seller->nomVendeur}} </p>
        <p> Prénom   : {{$seller->prenomVendeur}} </p>
        <p> mail     : {{$seller->mailVendeur}}</p>
        <P> portable : {{$seller->telVendeur}}</P>


    </div>


@endsection