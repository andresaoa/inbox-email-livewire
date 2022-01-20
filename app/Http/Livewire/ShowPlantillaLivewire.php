<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ShowPlantillaLivewire extends Component
{
    public $modal=0;
    protected $listeners = ['delete'];
    public function render()
    {
        $plantillas = Http::get('http://127.0.0.1:8000/api/callcenter/plantillas?token='.Session::get('key')->token);
        $plantillas = json_decode($plantillas);
        return view('livewire.show-plantilla-livewire',compact('plantillas'));
    }
    public function delete($id)
    {
        $response = Http::delete('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}?token='.Session::get('key')->token.'&id='.$id);
    }
}
