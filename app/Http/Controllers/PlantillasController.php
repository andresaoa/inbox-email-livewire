<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PlantillasController extends Controller
{
    public function index()
    {
        if (Session::get('key') != null) {
            if (Session::get('permiso')) {
                return view('plantillas.index');
            }
            return back();
        }
        else {
            return view('login');
        }
        
    }
    public function create()
    {
        if (Session::get('key') != null) {
            if (Session::get('permiso')) {
            return view('plantillas.create');
            }
            return back();
        }
        else {
            return view('login');
        }
        
    }
    public function store(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/callcenter/plantillas/crearplantillas?token='.Session::get('key')->token, [
            'asunto' => $request->asunto,
            'cuerpo_base' => $request->cuerpo,
        ]);
         if($response['Msj'] == "Insertado"){
            return redirect()->route('plantillas.index'); 
         }
        // dd($request->asunto);
    }
    public function edit(Request $request,$id)
    {
        if (Session::get('key') != null) {
            if (Session::get('permiso')) {
            $response = Http::get('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}/editar?token='.Session::get('key')->token.'&id='.$id);
            $response = json_decode($response);
            $id = $response->datos;
            return view('plantillas.edit',compact('id'));
        }
        return back();
    }
    else {
        return view('login');
    }
        
    }
    public function update(Request $request,$id)
    {
        $response = Http::put('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}?token='.Session::get('key')->token, [
            'asunto' => $request->asunto,
            'cuerpo_base' => $request->cuerpo,
            'id' => $id,
        ]);
        return redirect()->route('plantillas.index');
    }
}
