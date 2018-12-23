<!-- Ajout -->
<div class="form col-lg-4">
    <h3> Ajouter une Catégorie : </h3> <br>

    <form action="" method="post">
        {{  csrf_field()  }}
        <div class="form">
            <div class="row">

                <!-- nom -->
                <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="Nom" placeholder="Nom" value="{{ old('nomTypeProduit') }}">
                </div>

                <!-- temps -->
                <label class="col-sm-4 col-form-label">Le temps de réservation :</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="temps" placeholder="temps (en minutes)"  value="{{ old('tempsReservation') }}">
                </div>


                <!-- button to add the category -->
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btnSubmit btn-primary" name="add"> Ajouter </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modification -->
<div class="form col-lg-4">
    <h3> Modifier une Catégorie : </h3> <br>

    <form action="" method="post">
        {{  csrf_field()  }}
        <div class="form">
            <div class="row">

                <!-- nom -->
                <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                <div class="col-sm-8">
                  <select name="Nom" >
                        <option value="{{ old('nomTypeProduit') }}">--Choisissez une categorie--</option>
                      @foreach($categories as $categorie)
                        <option value={{$categorie->nomTypeProduit}}>{{$categorie->nomTypeProduit}}</option>
                      @endforeach
                  </select>
                </div>

                <!-- temps -->
                <label class="col-sm-4 col-form-label">Le temps de réservation :</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="temps" placeholder="temps (en minutes)"  value="{{ old('tempsReservation') }}">
                </div>


                <!-- button to modif the category -->
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btnSubmit btn-primary" name="modifier"> Modifier </button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Supression -->
<div class="form col-lg-4">
    <h3> Modifier une Catégorie : </h3> <br>

    <form action="" method="post">
        {{  csrf_field()  }}
        <div class="form">
            <div class="row">

                <!-- nom -->
                <label class="col-sm-4 col-form-label"> Nom de la catégorie :</label>
                <div class="col-sm-8">
                  <select name="Nom" >
                        <option value="{{ old('nomTypeProduit') }}">--Choisissez une categorie--</option>
                      @foreach($categories as $categorie)
                        <option value={{$categorie->nomTypeProduit}}>{{$categorie->nomTypeProduit}}</option>
                      @endforeach
                  </select>
                </div>

                <!-- button to delete the category -->
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btnSubmit btn-primary" name="delete"> Supprimer </button>
                </div>
            </div>
        </div>
    </form>
</div>
