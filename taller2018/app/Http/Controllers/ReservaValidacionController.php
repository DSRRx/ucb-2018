<?php

namespace App\Http\Controllers;

use App\Parqueo;

use App\ReservaValidacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $locations = DB::table('parqueos')->get();
        return view('cliente.busqueda_parqueo',compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pq2 = DB::table('users')
            ->select('*')
            ->orderBy('id')
            ->get();
        $pq1 = DB::table('parqueos')
            ->select('*')
            ->orderBy('id_parqueos')
            ->get();
        $date = '==';
        $reservas=\App\ReservaValidacion::paginate(10);
        $reservas = \App\ReservaValidacion::orderBy('h_inicio_reserva')->get();
        return view('reserva.historia',compact('reservas','pq2','pq1','date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gg=0;
        $cliente = auth()->user()->id;
        date_default_timezone_set('America/La_Paz');
        $fecha=date("Y-m-d");
        $this->validate($request,[
            'hora_visita'=>'required'
        ]);
        //dd($request->input('id_parqueos'));
        //$request->input('id_parqueos');
        $v = new ReservaValidacion();
        $v->id_user= $cliente;
        $v->id_parqueos= $request->input('id_parqueos');
        $v->dia_visita = $request->input('dia_visita');
        $v->hora_visita = $request->input('hora_visita');
        $v->tipo_notificacion=$request->input('tipo_notificacion');

        $parqueo = DB::table('parqueos')
            ->select('*')
            ->where('id_parqueos', $v->id_parqueos)
            ->get();

        //ifs que determinan la validez de las horas dadas
        if(strtotime($v->hora_visita) < strtotime($parqueo[0]->hora_apertura)){
            echo '<script type="text/javascript">
                            alert("El parqueo abre a las: '.$parqueo[0]->hora_apertura.' cambie la hora de visita e intente de nuevo");
                            </script>';
            $gg=1;
        }
        if(strtotime($v->hora_visita) > strtotime($parqueo[0]->hora_cierre)){
            echo '<script type="text/javascript">
                            alert("El parqueo cierra a las: '.$parqueo[0]->hora_cierre.' cambie la hora de visita e intente de nuevo");
                            </script>';
            $gg=1;
        }
        date_default_timezone_set('America/La_Paz');
        if($v->dia_reserva == date("Y-m-d") && strtotime($v->hora_visita) < strtotime(date("H:i"))){
            echo '<script type="text/javascript">
                            alert("Ya son mas de las: '.$v->hora_visita.' cambie la hora de inicio de reserva e intente de nuevo");
                            </script>';
            $gg=1;
        }

        //algoritmo para determinar la validez de los dias habiles del parqueo
        $dias_habiles = DB::table('precios_alquiler')
            ->select('*')
            ->where('id_parqueos', $v->id_parqueos)
            ->where('estado', false)
            ->get();

        $hoje = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        //echo date('D', strtotime($v->dia_reserva));
        foreach($dias_habiles as $dias){
            //echo $dias->id_dias;
            if($hoje[$dias->id_dias-1] == date('D', strtotime($v->dia_visita))){
                echo '<script type="text/javascript">
                            alert("El parqueo no funciona el dia '.$v->dia_visita.' cambie la fecha de reserva e intente de nuevo");
                            </script>';
                $gg=1;
            }
        }

        if($gg==0){
            $v->save();

            return redirect('validacion')->with('success','La visita fue añadida');
        }else{
            return $this->edit($v->id_parqueos);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function show(ReservaValidacion $reservaValidacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vh = Parqueo::find($id);
        $dias = DB::table('precios_alquiler')
            ->select('dias.nombre')
            ->join('dias', 'dias.id_dias', '=', 'precios_alquiler.id_dias')
            ->where('id_parqueos', $id)
            ->where('estado', true)
            ->get();
        $d2 = DB::table('users')
            ->select('*')
            ->where('id', $id)
            ->orderBy('id')
            ->get();

        return view('validacion.reserva_validacion',compact('vh', 'dias','d2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cliente = auth()->user()->id;
        date_default_timezone_set('America/La_Paz');
        $fecha=date("Y-m-d");
        $this->validate($request,[
            'hora_inicio'=>'required',
            'hora_fin'=>'required'
        ]);
        //dd($request->input('id_parqueos'));
        $request->input('id_parqueos');
        $v = new Reserva();
        $v->id_user= $cliente;
        $v->id_parqueos= 1;
        $v->dia_reserva = $fecha;
        $v->h_inicio_reserva = $request->input('hora_inicio');
        $v->h_fin_reserva=$request->input('hora_fin');
        $v->estado_reserva = 1;
        $v->estado_espacio = 1;
        $v->save();


        return redirect('reservas')->with('success','Reserva Exitosa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserva = \App\Reserva::find($id);
        $reserva->delete();
        return redirect('reservas')->with('success','Information has been  deleted');
    }

    public function lista_estado(){


        $l = DB::table('reserva')
            ->join('users','users.id','=','reservas.id_user')
            ->join('parqueos','parqueos.id_parqueos','=','reservas.id_parqueos')
            ->orderBy('id_reservas','desc')
            ->paginate(5);

        return view('cliente.lista_reservas', compact('l'));


    }
}
