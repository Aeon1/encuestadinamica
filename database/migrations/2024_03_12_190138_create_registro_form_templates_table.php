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
        Schema::create('registro_form_templates', function (Blueprint $table) {
            $table->id();
            $table->string('texto');
            $table->integer('campo')->comment('1-input, 2-input number, 3- input email, 4-select, 5- text, 6- select area, 7 select nivel');
            $table->string('name')->unique();
            $table->boolean('activo')->default(1);
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
        Schema::dropIfExists('registro_form_templates');
    }
};
