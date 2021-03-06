<?php

namespace App\Http\Controllers;

use App\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Zona::orderBy('id_zonas') -> paginate(10);
        return view('zona.index',compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zona.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'zona'=>'required'
        ]);

        $zona = new Zona();
        $zona->zona = $request->input('zona');
        $zona->save();


        //Vehiculo::create($request->all());

        //Session::flash('message','Zona creada correctamente');

        return redirect()->action('ZonaController@index')->with('success','La zona fue añadida');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function show(Zona $zona)
    {
        //return view('parqueo.show',compact('parqueo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function edit(Zona $zona)
    {
        //$zona = Zona::find($id);
        //return view('zona.edit',compact('zona','id'));

        return view('zona.edit',compact('zona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zona $zona)
    {
        $request->validate([
            'zona'=>'required'
        ]);

        $zona->update($request->all());

       // Session::flash('message','Zona actualizado correctamente');

        return redirect()->route('zona.index')->with('success','La zona fue editada');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zona  $zona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$zona->delete();

       // Session::flash('message','Parqueo eliminado correctamente');

        //return redirect()->route('zona.index');

        $usuario = \App\Zona::find($id);
        $usuario->delete();
        return redirect()->route('zona.index')->with('success','La zona fue eliminada');

    }
}
