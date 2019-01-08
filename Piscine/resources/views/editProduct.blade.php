@extends('navbars.navbarSeller')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/editProduct.css') }}" xmlns="http://www.w3.org/1999/html"/>


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
							@if ($errors->has('name'))
								<div class="alert alert-danger" role="alert"> Le nom ne doit pas etre vide </div>
						@endif
						</div>

						<div class="form-group">
							<label for="libellé">Libellé</label>
								<div class="input-group">
                                    <textarea type="text" class="form-control" rows="2" name="libelle" value="{{$product->libelleProduit}}" />{{$product->libelleProduit}}</textarea>
							    </div>
									@if ($errors->has('libelle'))
										<div class="alert alert-danger" role="alert"> Le libellé ne doit pas etre vide </div>
								@endif
						</div>

						<div class="form-group">
							<label for="qte">Quantité en stock</label>
								<div class="input-group">
									<input type="text" class="form-control" name="qteStockProduit" value="{{$product->qteStockProduit}}" />
								</div>
								@if ($errors->has('qteStockProduit'))
									<div class="alert alert-danger" role="alert"> La quantité ne doit pas etre vide (peut être égale à 0) </div>
							@endif
						</div>

                        <div class="form-group ">
                            <label > Livraison :</label>

                            @if ($product->livraison == 0)
                                <input class="form-horizontal" type="radio" name="delivery" id="Y" value="0" checked>
                            @else
                                <input class="form-horizontal" type="radio" name="delivery" id="Y" value="0" >
                            @endif
                            <label class="form-check-label" for="M"> oui </label>
                            @if ($product->livraison == 1)
                                <input class="form-horizontal" type="radio" name="delivery" id="N" value="1" checked>
                            @else
                                <input class="form-horizontal" type="radio" name="delivery" id="N" value="1">
                            @endif
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
																@if ($errors->has('prix'))
																	<div class="alert alert-danger" role="alert"> Le prix ne doit pas etre vide </div>
															@endif
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

                        <!-- image -->
                        <div class="form-group">
                            <label for="confirm">Image :</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="image" placeholder=" url de l'image (option)" value="{{$product->imageProduit}}">
                            </div>
                            @if ($errors->has('image'))
                                <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('image') }} </div>  </small>
                            @endif
                        </div>

                        <input name="id" type="hidden" value="{{ $product->numProduit }}">

                        <button type="submit" class="btnSubmit btn-primary" name='editMyProduct'>Modifier</button>
					</form>
				</div><!--main-center"-->
			</div><!--main-->
		</div><!--container-->



@endsection
