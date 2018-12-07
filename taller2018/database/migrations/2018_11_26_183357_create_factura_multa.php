<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaMulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_multa', function (Blueprint $table) {
            $table->increments('id_f_m');
            $table->unsignedInteger('id_factura');
            $table->unsignedInteger('id_multa');
            $table->foreign('id_factura')->references('id_factura')->on('factura')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_multa')->references('id')->on('multas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('factura_multa');
    }
}
