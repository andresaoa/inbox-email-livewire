<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class CorreoLivewire extends Component
{
    public $entrada,$cuerpo,$usuario,$email,$asunto,$verasunto,$eje;
    protected $listeners = ['save'];
    
    public function mount()
    {
        $this->entrada = 1;
        $this->asunto="";
    }
    public function render()
    {
        $plantillas = Http::get('http://127.0.0.1:8000/api/plantillas?token=7764c426ede8405071b17710b1759e6a');
        $plantillas = json_decode($plantillas);
        $correos = Http::get('http://127.0.0.1:8000/api/correos?token=7764c426ede8405071b17710b1759e6a');
        $correos = json_decode($correos);
        return view('livewire.correo-livewire',compact('plantillas','correos'));
    }
    // funciones
    public function NuevoCorreo()
    {
       $this->entrada = 1;
    }
    public function VerCorreo($id)
    {
        $this->entrada = 2;
        $ver = Http::get('http://127.0.0.1:8000/api/correos/{correo}?token=7764c426ede8405071b17710b1759e6a&id='.$id);
        $ver = json_decode($ver);
        $this->verasunto = $ver;
        $this->eje = 1;
    }
    public function PlantillaRelleno($asunto_base)
    {
        $this->cuerpo = $asunto_base;
    }
    public function save()
    {
        $asunto = $this->asunto;
        $cuerpo_mensaje = $this->cuerpo;
        $email = $this->email;
        $usuario = $this->usuario;
        $response = Http::post('http://127.0.0.1:8000/api/correos/recive', [
            'usuario' => $usuario,
            'cuerpo_mensaje' => $cuerpo_mensaje,
            'email'=> $email,
            'asunto'=> $asunto,
            'token' => '7764c426ede8405071b17710b1759e6a'
        ]);
        $this->resetExcept('entrada');
    }
}
