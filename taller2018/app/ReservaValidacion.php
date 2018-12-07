<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservaValidacion extends Model
{
    protected $primaryKey = 'id_parqueos';

    protected $fillable=[
        'id_zona',
        'direccion',
        'latitud_x',
        'longitud_y',
        'cantidad_p',
        'foto',
        'telefono_contacto_1',
        'telefono_contacto_2',
        'estado_funcionamiento',
        'cat_estado_parqueo',
        'cat_validacion'
    ];
}
