@extends('layout.principal')

@section('content')

<div id="content">


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- LLAVE API KEY -->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqM_uRRSwywJEZ7kyEQxg_eLbrvTU-VNA&sensor=TRUE_OR_FALSE">
    </script>
    <!-- LLAVE API KEY -->
    <script type="text/javascript" src="https://hpneo.github.io/gmaps/gmaps.js"></script>
    <script type="text/javascript" src="https://hpneo.github.io/gmaps/prettify/prettify.js"></script>
    <script type="text/javascript"src="https://hpneo.github.io/gmaps/styles.css"></script>
    <link href='https://hpneo.github.io/gmaps/prettify/prettify.css' rel='stylesheet' type='text/css' />


    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">

                    <div class="card-header border-0">
                        <h3 class="mb-0">Validar Parqueos</h3>
                    </div>

                    <div class="table-responsive">

                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ \Session::get('success') }}</p>
                        </div><br />
                        @endif

                        <div class="form-group col-md-8" >
                            <div class="card-header border-1" id="mymap">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="modal fade" id="reservas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">

                                    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h6 class="modal-title" id="modal-title-default">Type your modal title</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body ">
                                                <form role="form">
                                                    <div class="form-group">

                                                        <label for="Direccion">Direccion:</label>
                                                        <input type="text" class="form-control" name="direccion" value="">

                                                        <label for="Cantidad">Cantidad Vehiculos:</label>
                                                        <input type="text" class="form-control" name="cantidad_p" value="">

                                                        <label for="HoraApertura">Hora Apertura:</label>
                                                        <input type="time" class="form-control" name="hora_apertura" value="">

                                                        <label for="HoraCierre">Hora Cierre:</label>
                                                        <input type="time" class="form-control" name="hora_cierre" value="">

                                                        <label for="Tarifa">Tarifa:</label>
                                                        <input type="text" class="form-control" name="tarifa_hora_normal" value="">

                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="Nacionalidad">Dias Funcionamiento Parqueo:</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Lun</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Mar</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Mie</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Jue</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Vie</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Sab</label>
                                                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp;Dom</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary my-4">Reservar</button>
                                                        <button type="button" class="btn btn-warning my-4" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @routes
                        <script type="text/javascript">


                            var locations = <?php print_r(json_encode($locations)) ?>;
                            var mymap = new GMaps({
                                el: '#mymap',
                                lat: -16.4897,
                                lng: -68.1193,
                                zoom:13
                            });
                            var pinImage = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/009900/");

                            GMaps.geolocate({
                                success: function(position) {
                                    mymap.setCenter(position.coords.latitude, position.coords.longitude);
                                    mymap.addMarker({
                                        lat:position.coords.latitude,
                                        lng:position.coords.longitude,
                                    });
                                },
                                error: function(error) {
                                    alert('Geolocalizacion fallida: '+error.message);
                                },
                                not_supported: function() {
                                    alert("Tu navegador no soporta geolocalizacion");
                                }
                            });


                            $.each( locations, function( index, value ){

                                mymap.addMarker({
                                    icon : pinImage,
                                    scale : 6,
                                    lat: value.latitud_x,
                                    lng: value.longitud_y,
                                    title: value.direccion,
                                    infoWindow: {
                                        content:
                                            '<b>Direccion: </b>'+
                                            '<br>'+value.direccion+
                                            '<br><b>Espacios del parqueo:</b>'+
                                            '<br>'+value.cantidad_p+
                                            '<br><b>Foto de referencia:</b><br>' +
                                            '<br><img width="200" height="100" src="./images/'+value.foto+'"><br>'+
                                            '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar</button>'

                                    }

                                });
                            });

                            function prueba($id){
                                var prueba_r= "{{route('reservas.edit',1)}}";
                                console.log($id);
                                document.location.href=prueba_r;
                            }

                            $(document).ready(function(){
                                prettyPrint();

                                $('#geocoding_form').submit(function(e){
                                    e.preventDefault();
                                    GMaps.geocode({
                                        address: $('#address').val().trim(),
                                        callback: function(results, status){
                                            if(status=='OK'){
                                                var latlng = results[0].geometry.location;
                                                mymap.setCenter(latlng.lat(), latlng.lng());
                                            }
                                        }
                                    });
                                });
                            });


                        </script>


                        <table class="table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th>Direccion</th>
                                <th>Capacidad</th>
                                <th>Imagen Parqueo/Validacion</th>
                                <th>Observaciones</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($parqueos as $parqueo)
                            <tr>
                                <td>{{$parqueo['direccion']}}</td>
                                <td>{{$parqueo['cantidad_p']}}</td>
                                <td>{{$parqueo['foto']}}
                                <br>{{$parqueo['foto_validacion']}}</td>
                                <td>{{$parqueo['observaciones_validacion']}}</td>
                                <td><option>{{$parqueo['telefono_contacto_1']}}</option><option>{{$parqueo['telefono_contacto_2']}}</option></td>

                                <td>
                                    @if($parqueo['estado_funcionamiento'] == '0')
                                        Invalido
                                    @else
                                        @if($parqueo['estado_funcionamiento'] == '1')
                                            Aprobado
                                        @else
                                            @if($parqueo['estado_funcionamiento'] == '2')
                                                Denegado
                                            @else
                                                @if($parqueo['estado_funcionamiento'] == '3')
                                                    Observar
                                                @endif
                                            @endif

                                        @endif

                                    @endif

                                </td>

                                <td><a href="{{action('ValidacionController@edit', $parqueo['id_parqueos'])}}" class="btn btn-warning" )">Editar Validacion</a></td>

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
