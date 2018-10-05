<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->string('mailClient')->unique();
            $table->string('mdpClient');
            $table->string('nomClient');
            $table->string('prenomClient');
            $table->string('adresseClient');
            $table->string('villeClient');
            $table->string('codePostalClient');
            $table->string('telClient');
            $table->string('sexeClient');
            $table->date('dateNaissanceClient');
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
        Schema::dropIfExists('client');
    }
}
