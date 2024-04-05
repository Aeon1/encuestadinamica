<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_encuestas', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->bigInteger('encuesta');
            $table->boolean('publicada')->default(0);
            $table->boolean('programada_inicio')->default(0);
            $table->boolean('programada_fin')->default(0);
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();            
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
        Schema::dropIfExists('configuracion_encuestas');
    }
};
