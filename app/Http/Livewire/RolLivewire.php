<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class RolLivewire extends Component
{
    // notificacion
    public $notifi = 0;
    // evento para agregar u eliminar sin resfresh
    protected $listeners = ['agregaroeliminar'];
    // renderizar pagina
    public function render()
    {
        $usuarios = Http::get(env('PRODUCTION_URL').'/callcenter/?token=ef77106b7f7662a1f39396df80c6e8e6');
        $usuarios = json_decode($usuarios);
        // dd($usuarios);
        return view('livewire.rol-livewire',compact('usuarios'));
    }
    // api eliminar o agregar
    public function agregaroeliminar($id,$estado)
    {
     Http::get(env('PRODUCTION_URL').'/callcenter/agregarpermiso?token=ef77106b7f7662a1f39396df80c6e8e6&id_usuario='.$id.'&estado='.$estado);
    }
}
