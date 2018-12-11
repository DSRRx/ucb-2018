<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioAlquiler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios_alquiler', function (Blueprint $table) {
            $table->increments('id_precios_alquiler');
            $table->unsignedInteger('id_parqueos');
            $table->foreign('id_parqueos')->references('id_parqueos')->on('parqueos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_dias');
            $table->foreign('id_dias')->references('id_dias')->on('dias')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('estado');
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
        Schema::dropIfExists('precio_alquiler');
    }
}
