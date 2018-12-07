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
                                <h3 class="mb-0">Informacion del parqueo</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/" class="btn btn-sm btn-primary">Atras</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reservas.store') }}" role="form" class="panel-body" style="padding-bottom:30px;">
                            {{ csrf_field() }}
                            <!-- DATOS DEL PARQUEO SELECCIONADO EN EL MAPA-->
                            <h6 class="heading-small text-muted mb-4">Datos Parqueo</h6>
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
                                            <label class="form-control-label" for="input-username">Cantidad de espacios</label>
                                            <input type="text" disabled="true" name="cantidad_p" id="cantidad_p" class="form-control form-control-alternative" value="{{$vh->cantidad_p}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Telefono de contacto</label>
                                            <input type="text" disabled="true" name="telefono_contacto_1" id="telefono_contacto_1" class="form-control form-control-alternative" value="{{$vh->telefono_contacto_1}}" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Tarifa por hora</label>
                                            <input type="text" disabled="true" name="tarifa_hora_normal" id="tarifa_hora_normal" class="form-control form-control-alternative" value="{{$vh->tarifa_hora_normal}}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Hora Apertura</label>
                                            <input type="text" disabled="true" name="hora_apertura" id="hora_apertura" class="form-control form-control-alternative" value="{{$vh->hora_apertura}}" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Hora de Cierre</label>
                                            <input type="text" disabled="true" name="hora_cierre" id="hora_cierre" class="form-control form-control-alternative" value="{{$vh->hora_cierre}}" >
                                        </div>
                                    </div>
                                </div>
                                <label class="form-control-label" for="input-username">Dias Funcionamiento:</label>
                                <div class="row">

                                    @foreach($dias as $di)
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input type="text" disabled="true" name="hora_apertura" id="hora_apertura" class="form-control form-control-alternative" value="{{$di->nombre}}" >
                                        </div>
                                    </div>
                                    @endforeach
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Espacios Disponibles</label>
                                            <input type="text" disabled="true" name="hora_apertura" id="hora_apertura" class="form-control form-control-alternative" value="{{$vh->cantidad_actual}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php date_default_timezone_set('America/La_Paz');?>
                                            <label for="dia_reserva">Fecha Reserva:</label>
                                            <input type="date" value="{{date("Y-m-d")}}" min="{{date("Y-m-d")}}" class="form-control" name="dia_reserva" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="HoraApertura">Inicio de Reserva:</label>
                                            <input type="time" class="form-control" value="{{date("H:00", strtotime(date("H:00")) + 60*60)}}" name="hora_inicio" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="HoraCierre">Fin de Reserva:</label>
                                            <input type="time" class="form-control" value="{{date("H:00", strtotime(date("H:00")) + 60*120)}}" name="hora_fin" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <input class="btn btn-success" type="submit" value="Reservar parqueo">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
