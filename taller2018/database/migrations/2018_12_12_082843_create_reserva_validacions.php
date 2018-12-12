<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaValidacions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserva_validacions', function (Blueprint $table) {
            $table->increments('id_reserva_validacions');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_parqueos');
            $table->foreign('id_parqueos')->references('id_parqueos')->on('parqueos')->onDelete('cascade')->onUpdate('cascade');
            $table->date('dia_visita')->nullable();
            $table->time('hora_visita')->nullable();
            $table->string('tipo_notificacion')->nullable();
            $table->string('descripcion_notificacion')->nullable();
            $table->integer('estado_reserva_visita')->nullable();
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
        Schema::dropIfExists('reserva_validacions');
    }
}
