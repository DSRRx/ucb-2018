@extends('layout.principal')

@section('content')

<div id="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">

                    <div class="card-header border-0">
                        <h3 class="mb-0">Listado Factura</h3>
                    </div>
                    @foreach($usuario as $user)
                    <li>{{$user->sur_name}}
                    {{$user->last_name}}</li>
                    <li>{{$user->email}}</li>
                    @endforeach
                    @foreach($parqueo as $par)
                    <li>{{$par->tarifa_hora_normal}}Bs. /hora</li>
                    <li>Producto: {{$par->direccion}}</li>
                    @endforeach
                    <li>invoiceId: 12123</li>
                    <li>nit: 12312312321</li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

