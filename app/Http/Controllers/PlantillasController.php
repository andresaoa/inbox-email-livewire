<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlantillasController extends Controller
{
    public function index()
    {
        return view('plantillas.index');
    }
    public function create()
    {
        return view('plantillas.create');
    }
    public function store(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/callcenter/plantillas/crearplantillas?token=7764c426ede8405071b17710b1759e6a', [
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
        $response = Http::get('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}/editar?token=7764c426ede8405071b17710b1759e6a&id='.$id);
        $response = json_decode($response);
        $id = $response->datos;
        return view('plantillas.edit',compact('id'));
        
    }
    public function update(Request $request,$id)
    {
        $response = Http::put('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}?token=7764c426ede8405071b17710b1759e6a', [
            'asunto' => $request->asunto,
            'cuerpo_base' => $request->cuerpo,
            'id' => $id,
        ]);
        return redirect()->route('plantillas.index');
    }
}
