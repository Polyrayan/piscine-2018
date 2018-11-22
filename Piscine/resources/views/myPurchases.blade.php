@extends('navbars.navbarClient')

@section('content')
    @stack('rating')
    <h1> Historique d'achat </h1>
    @foreach($commandes as $commande)
        <h3>nom :{{$commande->nomProduit}} </h3>
        <p><b> qte{{$commande->qteCommande}}</b></p>
        <p><b> prix unitaire{{$commande->prixProduit}}€</b></p>
        <p><b> total {{$commande->prixCommande}} €</b></p>
        <h2> laissez un avis :
        <div class="container">
            <div class="row" id="post-review-box">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" action="" method="post">
                        {{  csrf_field()  }}
                        <input name="productNumber" type="hidden" value="{{ $commande->numProduit }}">
                        <input name="mailClient" type="hidden" value="{{ $client->mailClient }}">
                            <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Laisser un commentaire" rows="5"> {{old('comment')}}</textarea>
                        @if ($errors->has('comment'))
                            <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('comment') }} </div>  </small>
                        @endif
                        <div class="text-right">
                            <div class="stars starrr" name="stars" data-rating="0"></div>
                            <div class="form-group col-lg-3">
                                <input type="number" class="form-control" name="mark" value="{{old('mark')}}" placeholder=" note /10" >
                                @if ($errors->has('mark'))
                                    <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mark') }} </div>  </small>
                                @endif
                            </div>
                            <button class="btn btn-success btn-lg" name="rate" type="submit">envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection