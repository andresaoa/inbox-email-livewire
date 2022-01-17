<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ShowPlantillaLivewire extends Component
{
    public $modal=0;
    protected $listeners = ['delete'];
    public function render()
    {
        $plantillas = Http::get('http://127.0.0.1:8000/api/callcenter/plantillas?token=7764c426ede8405071b17710b1759e6a');
        $plantillas = json_decode($plantillas);
        return view('livewire.show-plantilla-livewire',compact('plantillas'));
    }
    public function delete($id)
    {
        $response = Http::delete('http://127.0.0.1:8000/api/callcenter/plantillas/{plantilla}?token=7764c426ede8405071b17710b1759e6a&id='.$id);
    }
}
