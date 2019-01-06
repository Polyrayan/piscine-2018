@extends('navbars.navbar')

@section('content')
<br>
    <div class = "container-fluid">
        <h1> Profil de {{$client->nomClient}}</h1>
        <p> Nom      : {{$client->nomClient}} </p>
        <p> Prénom   : {{$client->prenomClient}} </p>
        <p> Mail     : {{$client->mailClient}}</p>
        <P> Portable : {{$client->telClient}}</P>
    </div>

@endsection
