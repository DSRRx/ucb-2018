<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaAnfitrion extends Model
{
    //
    protected $primaryKey = 'id_reservas';

    protected $fillable=[
        'id_usuarios',
        'id_precios_alquiler',
        'inicio_reserva',
        'fin_reserva',
        'estado_reserva',
        'estado_espacio',
        'calificacion_cliente',
        'calificacion_anfitrion'
    ];
}
