<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenuncias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->increments('id_denuncias');
            $table->unsignedInteger('id_parqueos');
            $table->unsignedInteger('usuarios');
            $table->string('descripcion_adicional','250');
            $table->integer('cat_nivel_gravedad');
            $table->string('estado_denuncia','10');
            $table->integer('num_strikes')->nullable();
            $table->integer('cat_tipo_denuncia');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denuncias');
    }
}
