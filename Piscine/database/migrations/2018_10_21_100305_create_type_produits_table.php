<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typeProduits', function (Blueprint $table) {
            $table->increments('numTypeProduit');
            $table->string('libelleTypeProduit', 50);
            $table->string('couleur', 10);
            $table->string('taille', 10);
            $table->string('marque', 10);
            $table->string('tempsReservation', 10);

            $table->timestamps();
        });

        Schema::table('produit', function(Blueprint $table){
            $table->integer('typeProduit')->->unsigned()->index;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_produits');
    }
}
