@extends('navbars.navbarClient')

@section('content')
    @stack('rating')
    <h1> Historique d'achat </h1>
    @foreach($commandes as $commande)
        <div class="container-fluid">
            <div class="row" id="post-review-box">
                <form accept-charset="UTF-8" action="" method="post">
                    {{  csrf_field()  }}
                    <div class="col-md-3">
                        <h3>nom :{{$commande->nomProduit}} </h3>
                        <p><b> qte{{$commande->qteCommande}}</b></p>
                        <p><b> prix unitaire{{$commande->prixProduit}}€</b></p>
                        <p><b> total {{$commande->prixCommande}} €</b></p>
                    </div>
                    <div class="col-md-3">
                        <h4> Laissez un avis : </h4>

                            <input name="productNumber" type="hidden" value="{{ $commande->numProduit }}">
                            <input name="mailClient" type="hidden" value="{{ $client->mailClient }}">
                                <textarea class="form-control animated" cols="40" id="new-review" name="comment" placeholder="Laisser un commentaire" rows="2"> {{old('comment')}}</textarea>
                            @if ($errors->has('comment'))
                                <small>  <div class="alert alert-danger"  role="alert"> {{ $errors->first('comment') }} </div>  </small>
                            @endif
                    </div>
                    <div class="col-md-2 form-inline">
                        <br/><br/>
                                    <input type="number" class="form-control" name="mark" value="{{old('mark')}}" placeholder=" note /10" >
                                    @if ($errors->has('mark'))
                                        <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mark') }} </div>  </small>
                                    @endif
                                    <button class="btn btn-success btn-group" name="rate" type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
