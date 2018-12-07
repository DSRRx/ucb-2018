<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParqueos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parqueos', function (Blueprint $table) {
            $table->increments('id_parqueos');
            $table->unsignedInteger('id_users');
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_zonas');
            $table->foreign('id_zonas')->references('id_zonas')->on('zonas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('direccion', 100);
            $table->decimal('latitud_x', 20, 10);
            $table->decimal('longitud_y', 20, 10);
            $table->integer('cantidad_p');
            $table->integer('cantidad_actual')->nullable();
            $table->string('foto', 250);
            $table->string('telefono_contacto_1', 45);
            //$table->string('codigo_pais');
            //$table->string('authy_id')->nullable();
            //$table->boolean('verificar')->default(false);
            $table->string('telefono_contacto_2', 45)->nullable();
            $table->string('estado_funcionamiento'); // consultar para utilizar mas de solo dos estados_funcionamiento
            $table->time('hora_apertura');
            $table->time('hora_cierre');
            $table->decimal('tarifa_hora_normal', 10, 7);
            //$table->boolean('estado_funcionamiento');
            $table->unsignedInteger('cat_estado_parqueo')->nullable();
            $table->unsignedInteger('cat_validacion')->nullable();
            $table->string('foto_validacion', 250)->nullable();
            $table->string('observaciones_validacion', 500)->nullable();


            $table->rememberToken();
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
        Schema::dropIfExists('parqueos');
    }
}
