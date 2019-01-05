@extends('navbars.navbarSeller')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/editProduct.css') }}" />


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

	<div class="container">
			<div class="main">
				<div class="main-center">
          <center>
				<h3>Modification du produit : {{$product->nomProduit}}</h3>
          </center>
					<form class="" method="post" action="#">
            {{  csrf_field()  }}

						<div class="form-group">
							<label for="name">Nom</label>
								<div class="input-group">
				<input type="text" class="form-control" name="name" value="{{$product->nomProduit}}" />
							</div>
						</div>

						<div class="form-group">
							<label for="libellé">Libellé</label>
								<div class="input-group">
									<input type="text" class="form-control" name="libelle" value="{{$product->libelleProduit}}" />
							</div>
						</div>

						<div class="form-group">
							<label for="qte">Quantité en stock</label>
								<div class="input-group">
									<input type="text" class="form-control" name="qteStockProduit" value="{{$product->qteStockProduit}}" />
								</div>
						</div>

            <div class="form-group ">
              <label > Livraison :</label>
                <input class="form-horizontal" type="radio" name="delivery" id="Y" value="1">
                <label class="form-check-label" for="M"> oui </label>
                <input class="form-horizontal" type="radio" name="delivery" id="N" value="2">
                <label class="form-check-label" for="F"> non </label>
                @if ($errors->has('delivery'))
                    <small> <div class="alert alert-danger" role="alert"> {{ $errors->first('delivery') }} </div> </small>
                @endif
            </div>

						<div class="form-group">
							<label for="password">Prix unitaire (en €)</label>
								<div class="input-group">
									<input type="text" class="form-control" name="prix" value="{{$product->prixProduit}}" />
								</div>
						</div>

						<div class="form-group">
							<label for="confirm">Couleur</label>
								<div class="input-group">
									<input type="text" class="form-control" name="couleurProduit" value="{{$product->couleurProduit}}"/>
								</div>
						</div>

            <div class="form-group">
							<label for="confirm">Taille (en cm x cm)</label>
								<div class="input-group">
									<input type="text" class="form-control" name="tailleProduit" value="{{$product->tailleProduit}}" />
								</div>
						</div>

            <div class="form-group">
							<label for="confirm">Marque</label>
								<div class="input-group">
									<input type="text" class="form-control" name="marqueProduit" value="{{$product->marqueProduit}}" />
								</div>
						</div>

						<input name="id" type="hidden" value="{{ $product->numProduit }}">

				<button type="submit" class="btnSubmit btn-primary" name='selectForm'>Modifier</button>

					</form>
				</div><!--main-center"-->
			</div><!--main-->
		</div><!--container-->



@endsection
