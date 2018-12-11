<?php

namespace App\Http\Controllers;

use App\Validacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = DB::table('parqueos')
            ->where('estado_funcionamiento', 'LIKE', 'Observar' )
            ->get();
        $pq2 = DB::table('zonas')
            ->select('*')
            ->orderBy('id_zonas')
            ->get();
        $parqueos=\App\Parqueo::paginate(10);
        //$parqueos = \App\Parqueo::where('id_users',Auth::id())->orderBy('id_parqueos')->get();
        return view('validacion.index',compact('parqueos','pq2','locations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Validacion  $validacion
     * @return \Illuminate\Http\Response
     */
    public function show(Validacion $validacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Validacion  $validacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $parqueo = \App\Parqueo::find($id);

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

        $d2 = DB::table('users')
            ->select('*')
            ->where('id', $id)
            ->orderBy('id')
            ->get();

        return view('validacion.edit',compact('parqueo','id','pq2','validado','dias','d2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Validacion  $validacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if($request->hasfile('filename'))
        {
            $file = $request->file('filename');
            $name=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
        }

        $parqueo= \App\Parqueo::find($id);
        //$parqueo->id_users = Auth::id();
        $parqueo->id_zonas = $request->input('id_zonas');
        $parqueo->direccion = $request->input('direccion');
        $parqueo->latitud_x = $request->input('latitud_x');
        $parqueo->longitud_y = $request->input('longitud_y');
        $parqueo->cantidad_p = $request->input('cantidad_p');
        $parqueo->telefono_contacto_1 = $request->input('telefono_contacto_1');
        $parqueo->telefono_contacto_2 = $request->input('telefono_contacto_2');
        $parqueo->hora_apertura = $request->input('hora_apertura');
        $parqueo->hora_cierre = $request->input('hora_cierre');
        $parqueo->tarifa_hora_normal = $request->input('tarifa_hora_normal');
        $parqueo->estado_funcionamiento = $request->input('estado_funcionamiento');
        $parqueo->cat_estado_parqueo = $request->input('cat_estado_parqueo');
        $parqueo->cat_validacion = $request->input('cat_validacion');
        $parqueo->observaciones_validacion = $request->input('observaciones_validacion');
        $parqueo->foto_validacion = $name;
        $parqueo->save();

        $myCheckboxes = $request->input('servi');

        DB::table('precios_alquiler')
            ->where('id_parqueos', $id)
            ->delete();

        echo count($myCheckboxes);
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

        return redirect('validacion');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Validacion  $validacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Validacion $validacion)
    {
        //
    }
}
