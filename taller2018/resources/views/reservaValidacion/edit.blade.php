@extends('layout.principal')

@section('content')
<div id="content">
    <div class="container-fluid mt--7">
        <div class="row">

            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-info">
                            {{Session::get('success')}}
                        </div>
                        @endif

                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Visita Validacion</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reservaValidacion.update',$vh2->id_reserva_validacions) }}" role="form" class="panel-body" style="padding-bottom:30px;">
                            {{ csrf_field() }}


                            <!-- DATOS PARA LA RESERVA -->
                            <h6 class="heading-small text-muted mb-4">Datos para la Reserva</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php date_default_timezone_set('America/La_Paz');?>
                                            <label for="dia_visita">Fecha Visita:</label>
                                            <input type="date" value="{{$vh2->dia_visita}}" class="form-control" name="dia_visita" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="hora_visita">Hora Visita Aproximada:</label>
                                            <input type="time" class="form-control" value="{{$vh2->hora_visita}}" name="hora_visita" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="text" class="form-control form-control-alternative" name="id_parqueos" id="id_parqueos" value="{{$vh2->id_parqueos}}" readonly hidden>

                            <input type="text" class="form-control form-control-alternative" name="id_user" id="id_user" value="{{$vh2->id_user}}" readonly hidden>

                            <input type="text" class="form-control form-control-alternative" name="estado_reserva_visita" id="estado_reserva_visita" value="null" readonly hidden>


                            <input type="text" class="form-control form-control-alternative" name="tipo_notificacion" id="tipo_notificacion" value="{{$vh2->tipo_notificacion}}" readonly hidden>

                            <input type="text" class="form-control form-control-alternative" name="descripcion_notificacion" id="descripcion_notificacion" value="{{$vh2->descripcion_notificacion}}" readonly hidden>

                            <hr class="my-4" />

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="form-group col-md-4" style="margin-top:0px">
                                    <input class="btn btn-success" type="submit" value="Guardar">
                                    <a href="{{action('ReservaValidacionController@index')}}" class="btn btn-primary">Volver</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
