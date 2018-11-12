<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->addColumn('varchar','mailClient');
            $table->addColumn('varchar','nomClient');
            $table->addColumn('varchar','prenomClient');
            $table->addColumn('varchar','mdpClient');
            $table->addColumn('varchar','adresseClient');
            $table->addColumn('varchar','villeClient');
            $table->addColumn('number','codePostalClient');
            $table->addColumn('phone','telClient');
            $table->addColumn('varchar','numReduction', 'null');
            $table->addColumn('varchar','sexeClient');
            $table->addColumn('date','nomClient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
