@extends('layout.principal')

@section('content')

<div id="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">

                    <div class="card-header border-0">
                        <h3 class="mb-0">Notificaciones</h3>
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
                                <th>Tipo Notificacion</th>
                                <th>Descripcion Notificacion</th>
                                <th>Dia Visita</th>
                                <th>Hora Visita</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reserva_validacions as $reserva_validacions)
                            <tr>
                                <td>{{$reserva_validacions['id_parqueos']}}</td>
                                <td>{{$reserva_validacions ['tipo_notificacion']}}</td>
                                <td>{{$reserva_validacions ['descripcion_notificacion']}}</td>
                                <td>{{$reserva_validacions ['dia_visita']}}</td>
                                <td>{{$reserva_validacions ['hora_visita']}}</td>

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
