<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reservascliente = DB::table('reservas')
                                ->select('*')
                                ->where('id_user', Auth::id())
                                ->orderBy('h_inicio_reserva')
                                ->get();
        $parqueo = DB::table('parqueos')
                    ->select('*')
                    ->join('reservas', 'reservas.id_parqueos', '=', 'parqueos.id_parqueos')
                    ->get();
        $pq3 = DB::table('zonas')
                    ->select('*')
                    ->orderBy('id_zonas')
                    ->get();
        return view('reservacliente.index',compact('reservascliente','parqueo','pq1','pq3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $reservascliente = DB::table('reservas')
                                ->select('*')
                                ->where('id_user', Auth::id())
                                ->orderBy('h_inicio_reserva')
                                ->get();
        $parqueo = DB::table('parqueos')
                    ->select('*')
                    ->join('reservas', 'reservas.id_parqueos', '=', 'parqueos.id_parqueos')
                    ->get();
        $pq3 = DB::table('zonas')
                    ->select('*')
                    ->orderBy('id_zonas')
                    ->get();
        return view('reservacliente.historia',compact('reservascliente','parqueo','pq1','pq3'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //
        $reserva = \App\Reserva::find($id);
        //volver a subir el numero
        $parqueo = DB::table('parqueos')
                    ->select('*')
                    ->where('id_parqueos', $reserva->id_parqueos)
                    ->get();
        DB::table('parqueos')
            ->where('id_parqueos', $reserva->id_parqueos)
            ->update(['cantidad_actual'=>$parqueo[0]->cantidad_actual+1]);
        
        $reserva->delete();
        return redirect('reservacliente')->with('success','Information has been  deleted');
    }
}
