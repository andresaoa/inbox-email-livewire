<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PlantillasController extends Controller
{
    // inicio
    public function index()
    {
        // si no esta logueado
        if (Session::get('key') != null) {
            // si no tiene permido
            if (Session::get('permiso')) {
                // si cuenta con todo que lo deje pasar
                return view('plantillas.index');
            }
            // que lo rediriga aatras
            return back();
        }
        else {
            // que se loguee
            return view('login');
        }
    }
    // funcion crear
    public function create()
    {
        // si no esta logueado
        if (Session::get('key') != null) {
            // si no tiene permido
            if (Session::get('permiso')) {
                // si cuenta con todo que lo deje pasar
            return view('plantillas.create');
            }
            // que lo rediriga aatras
            return back();
        }
        else {
            // que se loguee
            return view('login');
        }
        
    }
    // guardar
    public function store(Request $request)
    {
        // api guardar plantilla
        $response = Http::post(env('PRODUCTION_URL').'/callcenter/plantillas/crearplantillas?token='.Session::get('key')->token, [
            'asunto' => $request->asunto,
            'cuerpo_base' => $request->cuerpo,
        ]);
        // si inserto que lo redirija a principio
         if($response['Msj'] == "Insertado"){
            return redirect()->route('plantillas.index'); 
         }
    }
    // funcion editar
    public function edit(Request $request,$id)
    {
        // valida logueado
        if (Session::get('key') != null) {
                // valida permiso
                if (Session::get('permiso')) {
                // api para consultar la vista editar
                $response = Http::get(env('PRODUCTION_URL').'/callcenter/plantillas/{plantilla}/editar?token='.Session::get('key')->token.'&id='.$id);
                $response = json_decode($response);
                $id = $response->datos;
                // enviar datos a la vista
                return view('plantillas.edit',compact('id'));
            }
            // regresar
            return back();
        }
        else {
            // volver al inicio
            return view('login');
            }
        
    }
    // funcion actualizar
    public function update(Request $request,$id)
    {
        // api para actualizar
        $response = Http::put(env('PRODUCTION_URL').'/callcenter/plantillas/{plantilla}?token='.Session::get('key')->token, [
            'asunto' => $request->asunto,
            'cuerpo_base' => $request->cuerpo,
            'id' => $id,
        ]);
        // redireccione al inicio
        return redirect()->route('plantillas.index');
    }
}
