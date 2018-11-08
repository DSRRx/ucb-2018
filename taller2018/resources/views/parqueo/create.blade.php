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
                                <h3 class="mb-0">Registro de Parqueos:</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <form method="post" action="{{url('parqueos')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                  <div class="form-group col-md-10">
                                    <label for="PrimerNombre">Zonas:</label>
                                    <select name="id_zonas" id="id_zonas" class="form-control">
                                            @foreach($pq2 as $p)
                                            <option value ="{{$p->id_zonas}}">{{ $p->zona }}</option>
                                            @endforeach
                                         </select>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-10">
                                      <label for="Direccion">Direccion:</label>
                                      <input type="text" class="form-control" name="direccion">
                                    </div>
                                  </div>
                                <div class="row">
                                    <div class="form-group col-md-10">
                                      <label for="Latitud">Latitud:</label>
                                      <input type="text" class="form-control" name="latitud_x">
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-md-10">
                                        <label for="Longitud">Longitud:</label>
                                        <input type="text" class="form-control" name="longitud_y">
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                            <label for="Cantidad">Cantidad Vehiculos:</label>
                                            <input type="text" class="form-control" name="cantidad_p">
                                        </div>
                                    </div>
                                        <div class="row">
                                                <div class="form-group col-md-4">
                                                        <label for="Imagen">Imagen:</label>
                                                  <input type="file" accept="image/*" name="filename">    
                                               </div>
                                              </div>
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                            <label for="Nacionalidad">Contacto 1:</label>
                                            <input type="text" class="form-control" name="telefono_contacto_1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="Nacionalidad">Estado Funcionamiento:</label>
                                            <input type="text" value="Inactivo" class="form-control" name="estado_funcionamiento" readonly>
                                        </div>
                                    </div>
                                <div class="row">
                                  <div class="col-md-4"></div>
                                  <div class="form-group col-md-4" style="margin-top:60px">
                                    <button type="submit" class="btn btn-success">Submit</button>
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
