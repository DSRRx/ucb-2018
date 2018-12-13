<?php

namespace App\Http\Controllers;

use App\Parqueo;

use App\ReservaValidacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservaValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $parqueos = DB::table('parqueos')
            ->select('*')
            ->orderBy('id_parqueos')
            ->get();

        $zona = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();

        $reserva_validacions=\App\ReservaValidacion::paginate(10);
        $reserva_validacions = \App\ReservaValidacion::where('id_user',Auth::id())->orderBy('id_reserva_validacions')->get();


        return view('reservaValidacion.index',compact('reserva_validacions','parqueos','zona'));
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
        $v->descripcion_notificacion=$request->input('descripcion_notificacion');

        $parqueo = DB::table('parqueos')
            ->select('*')
            ->where('id_parqueos', $v->id_parqueos)
            ->get();

        $p= \App\Parqueo::find($v->id_parqueos);
        $p->estado_funcionamiento = 'Visita';


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
            $p->save();
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
    public function show($id)
    {

        $vh2 = \App\ReservaValidacion::find($id);

        $d2 = DB::table('users')
            ->select('*')

            ->orderBy('id')
            ->get();
        $vh = DB::table('parqueos')
            ->select('*')

            ->orderBy('id_parqueos')
            ->get();

        return view('reservaValidacion.edit',compact('vh', 'd2','vh2'));
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
            ->where('id', $vh->id_users)
            ->orderBy('id')
            ->get();

        return view('reservaValidacion.reserva_validacion',compact('vh', 'dias','d2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $v = ReservaValidacion::find($id);
        $v->id_user= $request->input('id_user');
        $v->id_parqueos= $request->input('id_parqueos');
        $v->dia_visita = $request->input('dia_visita');
        $v->hora_visita = $request->input('hora_visita');
        $v->tipo_notificacion=$request->input('tipo_notificacion');
        $v->descripcion_notificacion=$request->input('descripcion_notificacion');
        $v->estado_reserva_visita= $request->input('estado_reserva_visita');
        $v->save();
        return redirect()->action('ReservaValidacionController@index')->with('success','La visita fue modificada');

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
