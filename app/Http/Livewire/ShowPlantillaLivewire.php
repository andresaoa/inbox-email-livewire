<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ShowPlantillaLivewire extends Component
{
    public $modal=0;
    // modal eliminae
    protected $listeners = ['delete'];
    // evento para eliminar sin refreshi
    // funcion principal
    public function render()
    {
        $plantillas = Http::get(env('PRODUCTION_URL').'/callcenter/plantillas?token='.Session::get('key')->token);
        $plantillas = json_decode($plantillas);
        return view('livewire.show-plantilla-livewire',compact('plantillas'));
    }
    // eliminar api
    public function delete($id)
    {
        $response = Http::delete(env('PRODUCTION_URL').'/callcenter/plantillas/{plantilla}?token='.Session::get('key')->token.'&id='.$id);
    }
}
