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
                                <th>Zona</th>
                                <th>Direccion</th>
                                <th>Capacidad</th>
                                <th>Imagen</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($parqueos as $parqueo)
                            <tr>
                                <td>@foreach($pq2 as $p)
                                    @if($p->id_zonas == $parqueo['id_zonas']){{ $p->zona }}@endif
                                    @endforeach</td>
                                <td>{{$parqueo['direccion']}}</td>
                                <td>{{$parqueo['cantidad_p']}}</td>
                                <td>{{$parqueo['foto']}}</td>
                                <td><option>{{$parqueo['telefono_contacto_1']}}</option><option>{{$parqueo['telefono_contacto_2']}}</option></td>
                                <td>@if($parqueo['estado_funcionamiento'] == '0') Invalido @endif</td>

                                <td><a href="{{action('ParqueoController@edit', $parqueo['id_parqueos'])}}" class="btn btn-warning">Edit</a></td>
                                <td>
                                    <form action="{{action('ParqueoController@destroy', $parqueo['id_parqueos'])}}" method="post">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('¿Quiere borrar la zona?')">Delete</button>
                                    </form>
                                </td>
                                <td><a class="btn btn-primary btn-xs" href="{{action('DenunciaController@index', $parqueo->id_parqueos)}}" >
                                        <i class="ni ni-fat-add"></i></a></td>
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
