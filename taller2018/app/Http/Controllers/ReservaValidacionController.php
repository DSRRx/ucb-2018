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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReservaValidacion  $reservaValidacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservaValidacion $reservaValidacion)
    {
        //
    }
}
