<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->increments('id_factura');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_reservas');
            $table->date('fecha');
            $table->decimal('monto_efectivo', 10, 7)->nullable();
            $table->string('estado_factura')->nullable();
            $table->string('codigo_control')->nullable();
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_reservas')->references('id_reservas')->on('reservas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('factura');
    }
}
