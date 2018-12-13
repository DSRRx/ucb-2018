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
                                <h3 class="mb-0">Reserva Visita Validacion</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reservaValidacion.store') }}" role="form" class="panel-body" style="padding-bottom:30px;">
                            {{ csrf_field() }}
                            <!-- DATOS DEL PARQUEO SELECCIONADO EN EL MAPA-->
                            <h6 class="heading-small text-muted mb-4">Datos Parqueo:
                                @foreach($d2 as $d)
                                    {{$d->sur_name}}
                                @endforeach
                            </h6>

                            <div class="pl-lg-4">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" hidden="true" name="id_parqueos" id="id_parqueos" class="form-control form-control-alternative" required value="{{$vh->id_parqueos}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Direccion</label>
                                            <input type="text" disabled="true" name="direccion" id="direccion" class="form-control form-control-alternative" value="{{$vh->direccion}}" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Telefono de contacto</label>
                                            <input type="text" disabled="true" name="telefono_contacto_1" id="telefono_contacto_1" class="form-control form-control-alternative" value="{{$vh->telefono_contacto_1}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="form-control-label" for="input-username">Foto de referencia</label>
                                        <img width="400" height="200" src="../../../images/{{$vh->foto}}">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />

                            <!-- DATOS PARA LA RESERVA -->
                            <h6 class="heading-small text-muted mb-4">Datos para la Reserva</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php date_default_timezone_set('America/La_Paz');?>
                                            <label for="dia_visita">Fecha Visita:</label>
                                            <input type="date" value="{{date("Y-m-d")}}" min="{{date("Y-m-d")}}" class="form-control" name="dia_visita" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="hora_visita">Hora Visita Aproximada:</label>
                                            <input type="time" class="form-control" value="{{date("H:00", strtotime(date("H:00")) + 60*60)}}" name="hora_visita" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="text" class="form-control form-control-alternative" name="tipo_notificacion" id="tipo_notificacion" value="Visita" readonly hidden>

                            <input type="text" class="form-control form-control-alternative" name="descripcion_notificacion" id="descripcion_notificacion" value="Visita prevista para validar el funcionamiento y estado del parqueo" readonly hidden>

                            <hr class="my-4" />

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="form-group col-md-4" style="margin-top:0px">
                                    <input class="btn btn-success" type="submit" value="Reservar parqueo">
                                    <a href="{{action('ValidacionController@index')}}" class="btn btn-primary">Volver</a>
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
