@extends('layout.principal')

@section('content')

    <div id="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">

                        <div class="card-header border-0">
                            <h3 class="mb-0">Listado Parqueos</h3>
                        </div>

                        <div class="table-responsive">

                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <p>{{ \Session::get('success') }}</p>
                                </div><br />
                            @endif

                            <table class="table align-items-center table-flush">
                                <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Dueño Parqueo</th>
                                    <th>Direccion</th>
                                    <th>Horarios</th>
                                    <th>Dias <br> Funcionamiento</th>
                                    <th>Reservar</th>
                                    <th>Eliminar</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($l as $fav)
                                    <tr>

                                        <td>{{$fav['id_parqueos_favoritos']}}</td>
                                        <td>{{$fav['sur_name']}}  {{$fav['las_name']}} </td>
                                        <td>{{$fav['direccion']}}</td>
                                        <td><option>{{$fav['hora_apertura']}}</option>
                                            <option>{{$fav['hora_cierre']}}</option></td>
                                        <?php
                                        $validado = DB::table('precios_alquiler')
                                            ->select('id_dias')
                                            ->where('id_parqueos', $fav['id_parqueos'])
                                            ->where('estado', true)
                                            ->orderBy('id_precios_alquiler')
                                            ->get();
                                        ?>
                                        <td>
                                            @foreach($validado as $val)
                                                @foreach($dias as $dia)
                                                    @if($val->id_dias == $dia->id_dias)
                                                        <option>{{$dia->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </td>

                                        <td><a class="btn btn-dribbble btn-sm" href="{{route('reservas.edit', $fav['id_parqueos'])}}"  >
                                                <i class="ni ni-time-alarm"></i> </a></td>
                                        <td>
                                            <form action="{{action('FavoritosController@eliminar', $fav->id_parqueos_favoritos)}}" method="post">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Desea eliminar el parqueo de favoritos?')">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <a href="{{action('ParqueoController@create')}}" class="btn btn-primary">Registro</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

