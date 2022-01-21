<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class CorreoLivewire extends Component
{
    // variables globales (se usan en las vistan y en el controlador)
    public $entrada=1,$cuerpo,$usuario,$email,$asunto="",$verasunto,$nombre,$siniestro,$adjunto=[];
    // escuchador para el modal si esta seguro enviar el email
    protected $listeners = ['save'];
    // reglas , requeridos , minimos y email
    protected $rules = [
        'asunto' => 'required|min:6',
        'email' => 'required|email',
        'cuerpo' => 'required|min:20',
        'usuario' => 'required|numeric',
    ]; 
    // modificar los textos de error prederterminados
    protected $messages = [
        'email.required' => 'El Correo no puede estar vacio.',
        'asunto.required' => 'El Asunto no puede estar vacio.',
        'email.email' => 'El Correo debe ser valido.',
        'cuerpo.required' => 'El Cuerpo no puede estar vacio.',
        'usuario.required' => 'El Usuario no puede estar vacio.'
    ];
    
    // render
    public function render()
    {
        if (Session::get('key') != null) {
            $plantillas = Http::get('http://127.0.0.1:8000/api/callcenter/plantillas?token='.Session::get('key')->token);
            $plantillas = json_decode($plantillas);
            $correos = Http::get('http://127.0.0.1:8000/api/callcenter/correos?token='.Session::get('key')->token.'&id_user='.Session::get('key')->id);
            $correos = json_decode($correos);
            return view('livewire.correo-livewire',compact('plantillas','correos'));
        }
        else {
            return view('login');
        }
    }
    // Cambio de vista a nuevo correo donde esta el formulario
    public function NuevoCorreo()
    {
       $this->entrada = 1;
    }
    // ver correo, llama la api de show y pasa los datos a la vista
    public function VerCorreo($id)
    {
        $this->entrada = 2;
        $ver = Http::get('http://127.0.0.1:8000/api/callcenter/correos/{correo}?token='.Session::get('key')->token.'&id='.$id);
        $ver = json_decode($ver);
        $this->verasunto = $ver;
    }
    // plantillas por defecto al hacer click cambiara el textarea
    public function PlantillaRelleno($asunto_base,$cuerpo_base)
    {
        $this->asunto = $asunto_base;
        $this->cuerpo = strip_tags($cuerpo_base);
    }
    // al aceotar el modal de guardar se emitira la api post para insertar y se actualizara sin recargar la vista
    public function save()
    {
        $asunto = $this->asunto;
        $cuerpo_mensaje = $this->cuerpo;
        $email = $this->email;
        $usuario = $this->usuario;
        $adjunto = $this->adjunto;
        $this->resetExcept('entrada');
        $response = Http::post('http://127.0.0.1:8000/api/callcenter/correos/recive', [
            'usuario' => Session::get('key')->id,
            'cuerpo_mensaje' => $cuerpo_mensaje,
            'email'=> $email,
            'asunto'=> $asunto,
            'siniestro' => $usuario,
            'adjunto' => $adjunto == [] ? null : $adjunto,
            'token' => Session::get('key')->token
        ]);
        // $response = json_decode($response);
        // dd($response);
    }
    // valida las rules y emite el modal
    public function seguro()
    {
        $this->validate();
        $this->emit('seguroenviar');
    }
    // cuando salen los mensajes de error se reinicia cuando modifica un input
    public function updated($propertyName)
    {
        $this->resetErrorBag();
    }
    // api para la consulta de siniestro
    public function siniestro($usuario)
    {
        $siniestro = Http::get('http://127.0.0.1:8000/api/siniestro/{siniestro}?token=427a903c0256cc73f7d2367f41e3236a220108162855&id='.$usuario);
        $siniestro = json_decode($siniestro);
        if ($siniestro != null) {
            $this->nombre = $siniestro->declarante_nombre;
            $this->email = $siniestro->declarante_email;
        }
    }
    // cerrar session
    public function cerrarsession()
    {
        Session::forget('key');
        return view('login');
    }
}
