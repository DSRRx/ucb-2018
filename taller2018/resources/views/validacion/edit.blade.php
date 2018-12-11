@extends('layout.principal')
@section('content')
<link href="{{asset('css/parque.css')}}" rel="stylesheet">
<div id="content">

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">

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


                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Validar Parqueo:
                                    @foreach($d2 as $d)
                                        {{$d->sur_name}}
                                    @endforeach
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <form method="post" enctype="multipart/form-data" action="{{action('ValidacionController@update', $id)}}">
                            @csrf
                            <input name="_method" type="hidden" value="PATCH">

                                    <input type="text" class="form-control" name="latitud_x" value="{{$parqueo->latitud_x}}" id="lat" readonly hidden>

                                    <input type="text" class="form-control" name="longitud_y" value="{{$parqueo->longitud_y}}" id="lon" readonly hidden>

                                    <select name="id_zonas" id="id_zonas" class="form-control" readonly hidden>
                                        @foreach($pq2 as $p)
                                        @if($p->id_zonas == $parqueo['id_zonas'])
                                        <option value="{{$p->id_zonas}}" selected>{{ $p->zona }}</option>
                                        @else
                                        <option value ="{{$p->id_zonas}}">{{ $p->zona }}</option>@endif
                                        @endforeach
                                    </select>


                                    <input type="text" class="form-control" name="direccion" value="{{$parqueo->direccion}}" readonly hidden>


                                    <input type="text" class="form-control" name="cantidad_p" value="{{$parqueo->cantidad_p}}" readonly hidden>


                                    <input type="text" class="form-control" name="telefono_contacto_1" value="{{$parqueo->telefono_contacto_1}}" readonly hidden>

                                    <input type="text" class="form-control" name="telefono_contacto_2" value="{{$parqueo->telefono_contacto_2}}" readonly hidden>

                                    <input type="time" class="form-control" name="hora_apertura" value="{{$parqueo->hora_apertura}}" required readonly hidden>

                                    <input type="time" class="form-control" name="hora_cierre" value="{{$parqueo->hora_cierre}}" required readonly hidden>

                                    <input type="text" class="form-control" name="tarifa_hora_normal" value="{{$parqueo->tarifa_hora_normal}}" readonly hidden>


                                    @foreach($validado as $val)

                                        @foreach($dias as $dia)
                                        @if($val->id_dias == $dia->id_dias)
                                        @if($val->estado == true)
                                        <input type="checkbox" name="servi[]" value="{{$val->id_dias}}" checked readonly hidden>
                                        @else
                                        <input type="checkbox" name="servi[]" value="{{$val->id_dias}}" readonly hidden>
                                        @endif
                                        @endif
                                        @endforeach
                                    </label>
                                    @endforeach

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-control-label" for="input-parqueo">Observaciones:</label>
                                    <input type="text" class="form-control form-control-alternative" name="observaciones_validacion" id="observaciones_validacion" value ="{{$parqueo->observaciones_validacion}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="Imagen">Imagen Validacion:</label>
                                    <input type="file" accept="image/*" name="filename">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="Estado">Estado Funcionamiento:</label>

                                    <select name="estado_funcionamiento" id="estado_funcionamiento" class="form-control" value ="{{$parqueo->estado_funcionamiento}}">
                                        <option value="Aprobar">Aprobar</option>
                                        <option value="Denegar">Denegar</option>
                                        <option value="Observar">Observar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="form-group col-md-4" style="margin-top:60px">
                                    <button type="submit" class="btn btn-success">Editar Validacion</button>
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




