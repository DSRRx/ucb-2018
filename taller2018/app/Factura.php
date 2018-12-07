<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //
    protected $primaryKey = 'id_factura';

    protected $fillable=[
        'id_factura',
        'id_user',
        'id_empresa',
        'id_reservas',
        'fecha',
        'monto_efectivo',
        'estado_factura',
        'codigo_control'
    ];
}
