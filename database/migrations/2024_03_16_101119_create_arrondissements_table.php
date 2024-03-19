<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrondissementsTable extends Migration
{
    public function up()
    {
        Schema::create('arrondissements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commune_id'); // Renommer la colonne communeId en commune_id
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->string('label');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('arrondissements');
    }
}