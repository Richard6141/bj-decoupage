<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartiersTable extends Migration
{
    public function up()
    {
        Schema::create('quartiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arrondissement_id'); // Renommer la colonne arrondissementId en arrondissement_id
            $table->foreign('arrondissement_id')->references('id')->on('arrondissements');
            $table->string('label');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quartiers');
    }
}