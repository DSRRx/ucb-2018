<?php

namespace App\Http\Controllers;

use App\ReservaValidacion;
use Illuminate\Http\Request;

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
        pq2 = DB::table('users')
            ->select('*')
            ->orderBy('id')
            ->get();
        $pq1 = DB::table('parqueos')
            ->select('*')
            ->orderBy('id_parqueos')
            ->get();
        $date = '==';
        $reservas=\App\Reserva::paginate(10);
        $reservas = \App\Reserva::orderBy('h_inicio_reserva')->get();
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
            'hora_inicio'=>'required',
            'hora_fin'=>'required'
        ]);
        //dd($request->input('id_parqueos'));
        //$request->input('id_parqueos');
        $v = new Reserva();
        $v->id_user= $cliente;
        $v->id_parqueos= $request->input('id_parqueos');
        $v->dia_reserva = $request->input('dia_reserva');
        $v->h_inicio_reserva = $request->input('hora_inicio');
        $v->h_fin_reserva=$request->input('hora_fin');
        //
        $parqueo = DB::table('parqueos')
            ->select('*')
            ->where('id_parqueos', $v->id_parqueos)
            ->get();

        //ifs que determinan la validez de las horas dadas
        if(strtotime($v->h_inicio_reserva) < strtotime($parqueo[0]->hora_apertura)){
            echo '<script type="text/javascript">
                            alert("El parqueo abre a las: '.$parqueo[0]->hora_apertura.' cambie la hora de inicio de reserva e intente de nuevo");
                            </script>';
            $gg=1;
        }
        if(strtotime($v->h_fin_reserva) > strtotime($parqueo[0]->hora_cierre)){
            echo '<script type="text/javascript">
                            alert("El parqueo cierra a las: '.$parqueo[0]->hora_cierre.' cambie la hora de fin de reserva e intente de nuevo");
                            </script>';
            $gg=1;
        }
        date_default_timezone_set('America/La_Paz');
        if($v->dia_reserva == date("Y-m-d") && strtotime($v->h_inicio_reserva) < strtotime(date("H:i"))){
            echo '<script type="text/javascript">
                            alert("Ya son mas de las: '.$v->h_inicio_reserva.' cambie la hora de inicio de reserva e intente de nuevo");
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
            if($hoje[$dias->id_dias-1] == date('D', strtotime($v->dia_reserva))){
                echo '<script type="text/javascript">
                            alert("El parqueo no funciona el dia '.$v->dia_reserva.' cambie la fecha de reserva e intente de nuevo");
                            </script>';
                $gg=1;
            }
        }

        //condicional para ver si ya no hay espacios disponibles
        if($parqueo[0]->cantidad_actual == 0){
            echo '<script type="text/javascript">
                            alert("El parqueo se encuentra lleno.");
                            </script>';
            $gg=1;
        }

        //condicional para ver si es success o fail
        if($gg==0){
            $v->save();
            //actualizar cantidad espacios disponibles parqueo
            DB::table('parqueos')
                ->where('id_parqueos', $v->id_parqueos)
                ->update(['cantidad_actual'=>$parqueo[0]->cantidad_actual-1]);
            return redirect('reservas')->with('success','Reserva Exitosa');
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
    public function edit(ReservaValidacion $reservaValidacion)
    {
        $vh = Parqueo::find($id);
        $dias = DB::table('precios_alquiler')
            ->select('dias.nombre')
            ->join('dias', 'dias.id_dias', '=', 'precios_alquiler.id_dias')
            ->where('id_parqueos', $id)
            ->where('estado', true)
            ->get();

        return view('cliente.reserva_parqueo',compact('vh', 'dias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservaValidacion $reservaValidacion)
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


        $l = DB::table('reservas')
            ->join('users','users.id','=','reservas.id_user')
            ->join('parqueos','parqueos.id_parqueos','=','reservas.id_parqueos')
            ->orderBy('id_reservas','desc')
            ->paginate(5);

        return view('cliente.lista_reservas', compact('l'));


    }
}
