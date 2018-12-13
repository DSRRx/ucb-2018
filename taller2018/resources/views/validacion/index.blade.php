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


    <!-- Mapa -->
    <div class="container-fluid mt--7">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Validar Parqueos</h3>
                    @foreach($pq3 as $d)
                    {{$d->id_user}}
                    {{$usu}}
                    @endforeach
                </div>
                <div class="form-group col-md-12" >
                    <div aling="center" id="mymap">
                    </div>
                </div>

                @routes
                @foreach($pq3 as $d)
                    @if($d->id_user == $usu)
                        <script type="text/javascript">


                            var locations = <?php print_r(json_encode($locations)) ?>;
                            var mymap = new GMaps({
                                el: '#mymap',
                                lat: -16.4897,
                                lng: -68.1193,
                                zoom:13
                            });

                            var pinImage = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/FF5733/");
                            var pinImageO = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/FFC300/");
                            var pinImage1 = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/4da6ff/");

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

                                if(value.estado_funcionamiento == 'Observacion')
                                {
                                    mymap.addMarker({
                                        icon : pinImageO,
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
                                                '<br><b>Estado de Funcionamiento:</b>'+
                                                '<br>'+value.estado_funcionamiento+
                                                '<br><b>Foto de referencia:</b><br>' +
                                                '<br><img width="200" height="100" src="./images/'+value.foto+'"><br>'+
                                                '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar Visita</button><button type="submit" onclick="pruebab('+value.id_parqueos+')" class="btn btn-info btn-sm">Editar Validacion</button>'
                                        }
                                    });
                                }else{
                                    if(value.estado_funcionamiento == 'Inactivo')
                                    {
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
                                                    '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar Visita</button><button type="submit" onclick="pruebab('+value.id_parqueos+')" class="btn btn-info btn-sm">Editar Validacion</button>'
                                            }
                                        });
                                    }else{
                                        mymap.addMarker({
                                            icon : pinImage1,
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
                                                    '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar Visita</button><button type="submit" onclick="pruebab('+value.id_parqueos+')" class="btn btn-info btn-sm">Editar Validacion</button>'
                                            }
                                        });
                                    }
                                }

                            });

                            function prueba($id){
                                var id = $id;
                                var prueba_r= '{{ route('reserva_validacions.edit', ":id") }}';
                                prueba_r = prueba_r.replace(':id', $id);
                                document.location.href=prueba_r;
                            }

                            function pruebab($id){
                                var id = $id;
                                var prueba_r= '{{ route('validacion.edit', ":id") }}';
                                prueba_r = prueba_r.replace(':id', $id);
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
                    @endif
                    @if($d->id_user != $usu)
                        <script type="text/javascript">


                            var locations = <?php print_r(json_encode($locations)) ?>;
                            var mymap = new GMaps({
                                el: '#mymap',
                                lat: -16.4897,
                                lng: -68.1193,
                                zoom:13
                            });

                            var pinImage = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/FF5733/");
                            var pinImageO = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/FFC300/");
                            var pinImage1 = new google.maps.MarkerImage("http://www.googlemapsmarkers.com/v1/4da6ff/");

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

                                if(value.estado_funcionamiento == 'Observacion')
                                {
                                    mymap.addMarker({
                                        icon : pinImageO,
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
                                                '<br><b>Estado de Funcionamiento:</b>'+
                                                '<br>'+value.estado_funcionamiento+
                                                '<br><b>Foto de referencia:</b><br>' +
                                                '<br><img width="200" height="100" src="./images/'+value.foto+'"><br>'+
                                                '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar Visita</button><button type="submit" onclick="pruebab('+value.id_parqueos+')" class="btn btn-info btn-sm">Editar Validacion</button>'
                                        }
                                    });
                                }else{
                                    if(value.estado_funcionamiento == 'Inactivo')
                                    {
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
                                                    '<br><button type="submit" onclick="prueba('+value.id_parqueos+')" class="btn btn-info btn-sm">Reservar Visita</button><button type="submit" onclick="pruebab('+value.id_parqueos+')" class="btn btn-info btn-sm">Editar Validacion</button>'
                                            }
                                        });
                                    }else{
                                        mymap.addMarker({
                                            icon : pinImage1,
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
                                                    '<br><img width="200" height="100" src="./images/'+value.foto+'"><br>'
                                            }
                                        });
                                    }
                                }

                            });

                            function prueba($id){
                                var id = $id;
                                var prueba_r= '{{ route('reserva_validacions.edit', ":id") }}';
                                prueba_r = prueba_r.replace(':id', $id);
                                document.location.href=prueba_r;
                            }

                            function pruebab($id){
                                var id = $id;
                                var prueba_r= '{{ route('validacion.edit', ":id") }}';
                                prueba_r = prueba_r.replace(':id', $id);
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
                    @endif

                @endforeach

            </div>
        </div>
    </div>

    <!-- Tabla de parqueos a validar -->
    <div class="container-fluid mt--7">
        <div class="col-xl-12 order-xl-1">
            <div class="card shadow">
                <div class="table-responsive">

                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>{{ \Session::get('success') }}</p>
                        </div><br />
                    @endif

                    <table class="table align-items-center table-flush">
                        <thead>
                            <tr>
                                <th>Direccion</th>
                                <th>Capacidad</th>
                                <th>Imagen Parqueo/Validacion</th>
                                <th>Observaciones</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <!--  <th colspan="1">Action</th>  -->
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($parqueos as $parqueo)
                                @if($parqueo['estado_funcionamiento'] != 'Aprobado')
                                <tr>
                                    <td>{{$parqueo['direccion']}}</td>
                                    <td>{{$parqueo['cantidad_p']}}</td>
                                    <td>{{$parqueo['foto']}}
                                    <br>{{$parqueo['foto_validacion']}}</td>
                                    <td>{{$parqueo['observaciones_validacion']}}</td>
                                    <td><option>{{$parqueo['telefono_contacto_1']}}</option><option>{{$parqueo['telefono_contacto_2']}}</option></td>

                                    <td>{{$parqueo['estado_funcionamiento']}}</td>

                                    <!-- <td><a href="{{action('ValidacionController@edit', $parqueo['id_parqueos'])}}" class="btn btn-warning" )">Editar Validacion</a></td> -->

                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
