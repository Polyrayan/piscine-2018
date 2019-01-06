@extends('navbars.navbarSeller')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/editProduct.css') }}" xmlns="http://www.w3.org/1999/html"/>


	<div class="container">
			<div class="main">
				<div class="main-center">
          <center>
				<h3>Modification du commerce : {{$shop->nomCommerce}}</h3>
          </center>
					<form class="" method="post">
                        {{  csrf_field()  }}

						<div class="form-group">
							<label for="name">Nom</label>
                            <div class="input-group">
				                <input type="text" class="form-control" name="name" value="{{$shop->nomCommerce}}" />
							</div>
							@if ($errors->has('name'))
								<div class="alert alert-danger" role="alert"> Le nom ne doit pas etre vide </div>
						@endif
						</div>

						<div class="form-group">
							<label for="libellé">Libellé</label>
								<div class="input-group">
                                    <textarea type="text" class="form-control" rows="2" name="libelle" value="{{$shop->libelleCommerce}}" />{{$shop->libelleCommerce}}</textarea>
							    </div>
									@if ($errors->has('libelle'))
										<div class="alert alert-danger" role="alert"> Le libellé ne doit pas etre vide </div>
								@endif
						</div>

						<div class="form-group">
							<label for="qte">Adresse</label>
								<div class="input-group">
									<input type="text" class="form-control" name="adresse" value="{{$shop->adresseCommerce}}" />
								</div>
								@if ($errors->has('adresse'))
									<div class="alert alert-danger" role="alert"> L'adresse ne doit pas etre vide </div>
							@endif
						</div>

                        <div class="form-group">
                            <label for="password">Ville</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="ville" value="{{$shop->villeCommerce}}" />
                                </div>
																@if ($errors->has('ville'))
									                <div class="alert alert-danger" role="alert"> La ville ne doit pas etre vide </div>
									            @endif
                        </div>

                        <div class="form-group">
                            <label for="confirm">Code postal</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="codePostal" value="{{$shop->codePostalCommerce}}"/>
                                </div>
																@if ($errors->has('codePostal'))
									                <div class="alert alert-danger" role="alert"> Le code postal ne doit pas etre vide </div>
									            @endif
                        </div>
                        <div class="form-group">
                            <label for="confirm">Region</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="region" value="{{$shop->regionCommerce}}" />
                                </div>
																@if ($errors->has('region'))
									                <div class="alert alert-danger" role="alert"> La region ne doit pas etre vide </div>
									            @endif
                        </div>

                        <div class="form-group">
                            <label for="confirm">Numéro de tel</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="numTel" value="{{$shop->telCommerce}}" />
                                </div>
																@if ($errors->has('numTel'))
									                <div class="alert alert-danger" role="alert"> Le numero de tel doit pas etre valide </div>
									            @endif
                        </div>

                        <div class="form-group">
                            <label for="confirm">Code de recrutement</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" value="{{$shop->codeRecrutement}}" />
                                </div>
																@if ($errors->has('code'))
									                <div class="alert alert-danger" role="alert"> Le code de recrutement ne doit avoir au moins 6 chiffre </div>
									            @endif
                        </div>


                        <input name="siret" type="hidden" value="{{ $shop->numSiretCommerce }}">

                        <button type="submit" class="btnSubmit btn-primary" name='Commerce' >Modifier</button>
					</form>
				</div><!--main-center"-->
			</div><!--main-->
		</div><!--container-->



@endsection
