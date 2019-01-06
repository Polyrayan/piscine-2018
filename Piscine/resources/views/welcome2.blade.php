@extends('navbars.navbar')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <div class="container-fluid">


        <h1> Page d'accueil </h1>

        <h3> ce qu'il manque : </h3>
        <ul>
            <li> trier par categorie </li>
            <li> pagination </li>
            <li> créer les tags  </li>
            <li> régler la connexion  </li>
            <li> faire le tunnel d'achat  </li>
            <li> régler les boutons non fonctionnels </li>
            <li> admin </li>
            <li> refered et js</li>
            <li> supprimer variante quand on supprime le groupe de produit pour eviter "la fuite memoire" </li>
            <li> put delete </li>
            <li> ajouter dans les formulaires d'un nouveau produit(myshop) + variante(editVariantesShop) la possibilité de donner une ou plusieurs images ( si plusieurs rajouter une table images dans la bd...) </li>
        </ul>
    </div>

    <!-- search -->
    </br>
   <div class="container-fluid">
       <h2> Produits </h2>
       <div class="row">
           <div class="col-lg-2"></div>
           <div class="col-lg-10">
               <div class="row">
                   <div class="col-lg-6">
                       <!-- first line-->
                       <input class="form-control" type="text" name="search" id="search" placeholder="Que recherchez-vous ?">
                   </div>
                   <div class="col-lg-2">
                       <select name="category" class="form-control">
                           <option> Toutes catégories </option>
                       </select>
                   </div>
                   <div class="col-lg-4"></div>
                   <!-- second line-->
                   <div class="col-lg-2">
                       <input class="form-control" type="number" name="minSearch" placeholder="Prix min">
                   </div>
                   <div class="col-lg-2">
                       <input class="form-control" type="number" name="maxSearch" placeholder="Prix max">
                   </div>
                   <div class="col-lg-2">
                       <select name="region" class="form-control">
                           <option> Languedoc-Roussillon </option>
                           <option> Aude </option>
                           <option> Gard </option>
                           <option> Hérault </option>
                           <option> Lozère </option>
                           <option> Pyrénées-Orientales </option>
                       </select>
                   </div>
                   <div class="col-lg-2">
                       <input class="form-control" type="text" name="citySearch" placeholder="Ville">
                   </div>
               </div>
           </div>
       </div>
   </div>
    </br>
    <div class="container-fluid">
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr>
                <th style="width:30%">Produit</th>
                <th style="width:5%" class="text-center">Couleur</th>
                <th style="width:8%" class="text-center">Taille</th>
                <th style="width:1%" class="text-center">Quantité</th>
                <th style="width:10%" class="text-center">Prix</th>
                <th style="width:10%" class="text-center">Distance</th>
                <th style="width:10%" class="text-center">Ville</th>
                <th style="width:10%"></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function(){

            fetch_customer_data();

            function fetch_customer_data(query = '')
            {
                $.ajax({
                    url:"{{ route('testController.action') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function(){
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>
@endsection
