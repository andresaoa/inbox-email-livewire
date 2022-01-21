<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class RolLivewire extends Component
{
    public $notifi = 0;
    protected $listeners = ['agregaroeliminar'];
    
    public function render()
    {
        $usuarios = Http::get('http://127.0.0.1:8000/api/callcenter/?token=ef77106b7f7662a1f39396df80c6e8e6');
        $usuarios = json_decode($usuarios);
        // dd($usuarios);
        return view('livewire.rol-livewire',compact('usuarios'));
    }
    public function agregaroeliminar($id,$estado)
    {

     Http::get('http://127.0.0.1:8000/api/callcenter/agregarpermiso?token=ef77106b7f7662a1f39396df80c6e8e6&id_usuario='.$id.'&estado='.$estado);
     
    }
}
