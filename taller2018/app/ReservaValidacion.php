<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaValidacion extends Model
{
    protected $primaryKey = 'id_notificaciones';

    protected $fillable=[
        'id_users',
        'id_parqueos',
        'inicio_reserva',
        'dia_visita',
        'hora_visita',
        'tipo_notificacion',
        'descripcion_notificacion',
        'estado_reserva_visita'
    ];
}
