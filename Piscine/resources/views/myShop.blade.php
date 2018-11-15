@extends('navbars.navbarSeller')

@section('content')

    <h1> Commerce : {{ $shopName }} </h1>

    <h5> liste des commerçants : </h5>
    <ul>
        @foreach($sellers as $seller)
            <li> {{$seller->nomVendeur}}  <a  href="\Piscine\public\vendeur\{{$seller->mailVendeur}}"> infos </a></li>
            @endforeach
    </ul>

    


@endsection