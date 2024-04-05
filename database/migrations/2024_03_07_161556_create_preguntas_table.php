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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->integer('encuesta');
            $table->integer('seccion');
            $table->integer('asignacion');
            $table->integer('momento');
            $table->text('pregunta');
            $table->integer('tipo');
            $table->string('area')->default(0);;
            $table->string('nivel')->default(0);
            $table->boolean('obligatorio')->default(0);
            $table->string('orden')->default(0);
            $table->integer('subnivel')->default(0);
            $table->string('name')->default('');
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
        Schema::dropIfExists('preguntas');
    }
};
