<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RolLivewire extends Component
{
    // notificacion
    public $notifi = 0;
    // evento para agregar u eliminar sin resfresh
    protected $listeners = ['agregaroeliminar'];
    // renderizar pagina
    public function render()
    {
        $usuarios = Http::get(env('PRODUCTION_URL').'/callcenter/?token='.Session::get('key')->token.'&usuario='.Session::get('key')->usuario);
        $usuarios = json_decode($usuarios);
        return view('livewire.rol-livewire',compact('usuarios'));
    }
    // api eliminar o agregar
    public function agregaroeliminar($id,$estado)
    {
     $agregar=Http::get(env('PRODUCTION_URL').'/callcenter/agregarpermiso?token='.Session::get('key')->token.'&usuario='.Session::get('key')->usuario.'&id_usuario='.$id.'&estado='.$estado);
    }
}
