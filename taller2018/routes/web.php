<?php
Auth::routes ();

// Rutas de ADMINISTRADOR:
    Route::resource ('/tipoMultas', 'TipoMultaController')->middleware('auth');
    Route::resource('/roles','RoleController', ['middleware'=>['auth', 'admin']]);
    Route::resource('/users','UsersRoleController', ['middleware'=>['auth', 'admin']]);
    Route::resource('parqueo_admin','ParqueoAdminController',['middleware' => ['auth', 'admin']]);
    Route::resource('denuncia','DenunciaController',['middleware' => ['auth', 'admin', 'user']]);
    Route::resource('validacion','ValidacionController')->middleware('auth');
    Route::resource('notificacion','NotificacionController')->middleware('auth');
    Route::resource('reserva_validacions','ReservaValidacionController')->middleware('auth');
    Route::get('/reserva_validacions/store/{id}',[
        'uses' => 'ReservaValidacionController@store',
        'as' => 'testa.route'
    ], ['middleware'=>['auth', 'user','admin']]);

// Rutas de CLIENTE O USUARIO;
    Route::resource('/','ClienteController', ['middleware'=>['auth', 'user']]);
    Route::resource('factura','FacturaController', ['middleware'=>['auth', 'user']]);

    Route::get('/reservas/facturacion/{id}',[
        'uses' => 'FacturaController@showFactura',
        'as' => 'test.route'
    ], ['middleware'=>['auth', 'user']]);

    Route::get('/reservas/store/{id}',[
        'uses' => 'ReservaController@store',
        'as' => 'testa.route'
    ], ['middleware'=>['auth', 'user']]);

    Route::resource('cliente','ClienteController', ['middleware'=>['auth', 'user']]);
    Route::resource('reservacliente','ReservaClienteController', ['middleware'=>['auth', 'user']]);
    Route::resource('vehiculo','VehiculoController', ['middleware'=>['auth', 'user']]);
    Route::get('makeMeUser','UsersRoleController@makeMeUser', ['middleware'=>['auth']]);
    Route::resource('reservas','ReservaController', ['middleware' => ['auth', 'user']]);
    Route::get('/list','VehiculoController@list', ['middleware' => ['auth', 'user']]);
    Route::get('vehiculo/{vehiculo}/edit','VehiculoController@edit', ['middleware' => ['auth', 'user']]);
    Route::resource('cliente_busqueda','ClienteController')->middleware('auth');
    Route::get('/lista_reservas','ReservaController@lista_estado');//nueva
    Route::get('mostrar_reserva','ReservaController@edit');//nueva




// Rutas de OWNER
    Route::resource('zona','ZonaController',['middleware' => ['auth', 'owner']]);
    Route::resource('parqueos','ParqueoController',['middleware' => ['auth', 'owner']]);
    Route::resource('reservasanfitrion','ReservaAnfitrionController')->middleware('auth',['middleware' => ['auth', 'owner']]);

// Dejo dos opciones para que veáis cómo implementar los middlewares para cada URL,
// Cambia ligeramente entre Route::get y Route::resource.
// Route::get ('adminOnly', function () {})->middleware('auth', 'admin');
// Route::resource ('pruebaRole', 'RoleController', ['middleware'=>['auth', 'owner']]);

// Hay tres middlewares básicos:
// admin
// owner
// user
// Cuando el usuario inicia sesión, el sistema ve el role que tiene y lo designa como
// admin, user u owner. En el ejemplo aparece el ejemplo de admin y owner.
// En el caso de la ruta "adminOnly", cuando un usuario intente entrar a la ruta, el middleware
// comprobará el role que tiene el usuario y, si tiene el rol de admin entrará a la ruta; sino,
// lo redireccionará a la ruta '/'
