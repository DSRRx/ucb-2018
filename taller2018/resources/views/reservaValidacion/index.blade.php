@extends('layout.principal')

@section('content')

<div id="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">

                    <div class="card-header border-0">
                        <h3 class="mb-0">Listado Visitas </h3>
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
                                <th>Parqueo</th>
                                <th>Dia Visita</th>
                                <th>Hora Visita</th>
                                <th>Fecha Creacion</th>
                                <th colspan="1">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reserva_validacions as $reserva_validacions)
                            <tr>
                                <td>
                                    @foreach($zona as $p)
                                    @foreach($parqueos as $p1)
                                    @if(($p1->id_parqueos == $reserva_validacions->id_parqueos)&&($p->id_zonas == $p1->id_zonas))
                                    {{$p1->direccion}} - {{$p->zona}}
                                    @endif
                                    @endforeach
                                    @endforeach

                                </td>

                                <td>
                                    @foreach($parqueos as $p1)
                                    @if($p1->id_parqueos == $reserva_validacions->id_parqueos){{$reserva_validacions ['dia_visita']}}@endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($parqueos as $p1)
                                    @if($p1->id_parqueos == $reserva_validacions->id_parqueos){{$reserva_validacions ['hora_visita']}}@endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($parqueos as $p1)
                                    @if($p1->id_parqueos == $reserva_validacions->id_parqueos){{$reserva_validacions ['created_at']}}@endif
                                    @endforeach
                                </td>

                                <!--
                                <td>
                                    <a href="{{action('ReservaValidacionController@show', $reserva_validacions['id_reserva_validacions'])}}" class="btn btn-warning">Editar</a>
                                </td>

                                -->

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
