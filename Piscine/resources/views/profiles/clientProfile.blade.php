@extends('navbars.navbar')

@section('content')
<br>
    <div class = "container-fluid">
        <h1> Profil de {{$client->nomClient}}</h1>
        <p> Nom      : {{$client->nomClient}} </p>
        <p> Prénom   : {{$client->prenomClient}} </p>
        <p> mail     : {{$client->mailClient}}</p>
        <P> portable : {{$client->telClient}}</P>
    </div>

@endsection