<?php

namespace App\Http\Controllers;

use App\Parqueo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Carbon;

class ParqueoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $pq2 = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();

        $dias = DB::table('dias')
            ->select('*')
            ->orderBy('id_dias')
            ->get();

        $parqueos=\App\Parqueo::paginate(10);
        $parqueos = \App\Parqueo::where('id_users',Auth::id())->orderBy('id_parqueos')->get();

  
        return view('parqueo.index',compact('parqueos','pq2','dias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           //configuaración
           $config = array();
           $config['center'] = 'auto';
           $config['map_width'] = 'auto';
           $config['map_height'] = 400;
           $config['zoom'] = '15';
           $config['onboundschanged'] = 'if (!centreGot) {
               var mapCentre = map.getCenter();
               marker_0.setOptions({
                   position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
   
               });
           }
           centreGot = true;';
   
           \Gmaps::initialize($config);
   
           // Colocar el marcador
           // Una vez se conozca la posición del usuario
   
           $marker = array();
           $marker['position'] = 'auto';
           $marker['infowindow_content'] = 'Posicion Actual';
           $marker['draggable'] = true;
           $marker['ondragend'] = 'document.getElementById("lat").value = event.latLng.lat(); document.getElementById("lon").value = event.latLng.lng();';
           \Gmaps::add_marker($marker);
   
           $map = \Gmaps::create_map();

        $pq2 = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();
        
        return view('parqueo.create',compact('pq2','map'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if($request->hasfile('filename'))
         {
            $file = $request->file('filename');
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
         }
        $parqueo= new \App\Parqueo;
        $parqueo->id_users = Auth::id();
        $parqueo->id_zonas = $request->input('id_zonas');
        $parqueo->direccion = $request->input('direccion');
        $parqueo->latitud_x = $request->input('latitud_x');
        $parqueo->longitud_y = $request->input('longitud_y');
        $parqueo->cantidad_p = $request->input('cantidad_p');
        $parqueo->cantidad_actual = $request->input('cantidad_p');
        $parqueo->foto = $name;
        $parqueo->telefono_contacto_1 = $request->input('telefono_contacto_1');
        $parqueo->telefono_contacto_2 = $request->input('telefono_contacto_2');
        $parqueo->hora_apertura = $request->input('hora_apertura');
        $parqueo->hora_cierre = $request->input('hora_cierre');
        $parqueo->tarifa_hora_normal = $request->input('tarifa_hora_normal');
        $parqueo->estado_funcionamiento = $request->input('estado_funcionamiento');
        $parqueo->cat_estado_parqueo = $request->input('cat_estado_parqueo');
        $parqueo->cat_validacion = $request->input('cat_validacion');
        $parqueo->save();

        //algoritmo para determinar el estado de los dias con los checkbox
        $array = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
        $estado = array();
        $myCheckboxes = $request->input('dia');
                for($i = 0; $i <= 6; $i++){
                    $aux = 0;
                    foreach($myCheckboxes as $value){
                    if($value == $array[$i]){
                        //echo $value.'original'."<br>";
                        array_push($estado, true);
                        $aux=1;
                        break;
                    }
                }
                if($aux == 0){
                    //echo $array[$i].'fake'."<br>";
                    array_push($estado, false);
                }
            }
            //dd($estado);

        //insert de los dias al sistema
        for($i = 1; $i <= 7; $i++){
            DB::table('precios_alquiler')->insert(
                array(
                    'id_parqueos' => $parqueo->id_parqueos,
                    'id_dias' => $i,
                    'estado' => $estado[$i-1]
                )
            );
        }
        
        return redirect('parqueos')->with('success', 'Parqueo Anadido');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parqueo $parqueo
     * @return \Illuminate\Http\Response
     */
    public function show(Parqueo $parqueo)
    {
        //return view('parqueo.show',compact('parqueo'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parqueo $parqueo
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        
        $parqueo = \App\Parqueo::find($id);
        //configuaración
        $config = array();
        $config['center'] = ''. $parqueo->latitud_x . '' . ',' . '' .$parqueo->longitud_y . '';
        $config['map_width'] = 'auto';
        $config['map_height'] = 400;
        $config['zoom'] = 15;
        $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())

            });
        }
        centreGot = true;';

        \Gmaps::initialize($config);

        // Colocar el marcador
        // Una vez se conozca la posición del usuario

        $marker = array();
        $marker['position'] = ''. $parqueo->latitud_x . '' . ',' . '' .$parqueo->longitud_y . '';
        $marker['draggable'] = true;
        $marker['ondragend'] = 'document.getElementById("lat").value = event.latLng.lat(); document.getElementById("lon").value = event.latLng.lng();';
        $marker['infowindow_content'] = 'Ubicacion Actual';
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();
        $pq2 = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();

        $validado = DB::table('precios_alquiler')
            ->select('*')
            ->where('id_parqueos', $id)
            ->orderBy('id_precios_alquiler')
            ->get();

        $dias = DB::table('dias')
            ->select('*')
            ->orderBy('id_dias')
            ->get();

        return view('parqueo.edit',compact('parqueo','id','pq2','map','validado','dias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parqueo $parqueo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gg=0;
        if($request->input('estado_funcionamiento') == 'Inactivo')
         {
            $chozni = 0;
         }else{
            $chozni = 1;
         }
        $parqueo= \App\Parqueo::find($id);
        $parqueo->id_users = Auth::id();
        $parqueo->id_zonas = $request->input('id_zonas');
        $parqueo->direccion = $request->input('direccion');
        $parqueo->latitud_x = $request->input('latitud_x');
        $parqueo->longitud_y = $request->input('longitud_y');
        $parqueo->cantidad_p = $request->input('cantidad_p');
        $parqueo->cantidad_actual = $request->input('cantidad_p');
        $parqueo->telefono_contacto_1 = $request->input('telefono_contacto_1');
        $parqueo->telefono_contacto_2 = $request->input('telefono_contacto_2');
        $parqueo->hora_apertura = $request->input('hora_apertura');
        $parqueo->hora_cierre = $request->input('hora_cierre');
        $parqueo->tarifa_hora_normal = $request->input('tarifa_hora_normal');
        $parqueo->estado_funcionamiento = $chozni;
        $parqueo->cat_estado_parqueo = $request->input('cat_estado_parqueo');
        $parqueo->cat_validacion = $request->input('cat_validacion');
        $parqueo->save();

        $myCheckboxes = $request->input('servi');
        
        DB::table('precios_alquiler')
        ->where('id_parqueos', $id)
        ->delete();

        for($i = 1, $aux = 0; $i <= 7; $i++){
               $estado = false;
               if(count($myCheckboxes) > $aux){
                     if($i == $myCheckboxes[$aux]){
                        $estado = true;
                        $aux++;
                     }
               }
                DB::table('precios_alquiler')->insert(
                array(
                    'id_parqueos' => $id,
                    'id_dias' => $i,
                    'estado' => $estado
                )
            );
        }

        //verificar si hay reservas activas
        $verificar = DB::table('precios_alquiler')
                        ->select('*')
                        ->where('id_parqueos', $id)
                        ->get();

        $reservasanfitrion = DB::table('reservas')
                        ->select('*')
                        ->join('parqueos', 'parqueos.id_parqueos', '=', 'reservas.id_parqueos')
                        ->where('parqueos.id_users', Auth::id())
                        ->where('parqueos.id_parqueos', $id)
                        ->orderBy('h_inicio_reserva')
                        ->get();
        date_default_timezone_set('America/La_Paz');
        $mytime = Carbon\Carbon::now();
        //echo $mytime->toDateString();
        //echo $verificar;
        $hoje = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $chozni = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
        foreach($verificar as $veri){
            if($veri->estado == false){
                //echo 0 ."dia". $veri->id_dias;
                for($i =0 ; $i < count($reservasanfitrion); $i++){
                    if($mytime->toDateString() < $reservasanfitrion[$i]->dia_reserva){
                        //echo date('D', strtotime($reservasanfitrion[$i]->dia_reserva));
                        if(date('D', strtotime($reservasanfitrion[$i]->dia_reserva)) == $hoje[$veri->id_dias-1]){
                            echo '<script type="text/javascript">
                            alert("Existe una reserva activa el dia '.$chozni[$veri->id_dias-1].' eliminela e intente de nuevo");
                            </script>';
                            $gg=1;
                            DB::table('precios_alquiler')
                                ->where('id_parqueos', $id)
                                ->where('id_dias', $veri->id_dias)
                                ->update(['estado'=>true]);
                        }
                    }
                }
            }
        }
        
        if($gg==0){
            return redirect('parqueos');
        }else{
            return $this->edit($id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parqueo = \App\Parqueo::find($id);
        $parqueo->delete();
        return redirect('parqueos')->with('success','Information has been deleted');
    }

    /*public function getParqueoEdit()
    {
        $pq2 = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();
        return view('parqueo.edit',compact('parqueo','id','pq2','map'));
    }*/



}
