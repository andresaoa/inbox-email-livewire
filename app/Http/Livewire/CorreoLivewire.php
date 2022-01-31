<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;
class CorreoLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'simple-bootstrap';
    // variables globales (se usan en las vistan y en el controlador)
    public $entrada=1,$cuerpo,$usuario,$email,$asunto="",$verasunto,$nombre,$siniestro,$adjunto=[],$let="",$correosbus;
    public $fecha_inicio,$fecha_fin,$cargando;
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
        'usuario.required' => 'El Siniestro no puede estar vacio.',
        'asunto.min' => 'El valor minimo es 6'
    ];
    
    // render
    public function render()
    {
        if ((Session::get('key') != null)) {
            // todas las plantillas
            $plantillas = Http::get(env('PRODUCTION_URL').'/callcenter/plantillas?token='.Session::get('key')->token);
            $plantillas = json_decode($plantillas);
            // correos del usuario logueado
            $correos = Http::get(env('PRODUCTION_URL').'/callcenter/correos?token='.Session::get('key')->token.'&id_user='.Session::get('key')->usuario)->body();
            $correos = collect(json_decode($correos));
            if ($correos == null) {
                $correos = Http::get(env('PRODUCTION_URL').'/callcenter/correos?token='.Session::get('key')->token.'&id_user='.Session::get('key')->usuario.'&asunto='.$this->let)->body();
                $correos = collect(json_decode($correos));
            }
            
            $this->letra();
            
            return view('livewire.correo-livewire',['correos' =>$correos->paginate(10),'plantillas'=>$plantillas]);
        }
        else {
            return view('login');
        }
    }
    // Cambio de vista a nuevo correo donde esta el formulario
    public function NuevoCorreo()
    {
       $this->entrada = 1;
       $this->resetPage();
       $this->resetExcept('entrada');
    }
    // ver correo, llama la api de show y pasa los datos a la vista
    public function VerCorreo($id)
    {
        $this->entrada = 2;
        $ver = Http::get(env('PRODUCTION_URL').'/callcenter/correos/{correo}?token='.Session::get('key')->token.'&id='.$id);
        $ver = json_decode($ver);
        $this->verasunto = $ver;
    }
    // plantillas por defecto al hacer click cambiara el textarea
    public function PlantillaRelleno($asunto_base,$cuerpo_base)
    {
        $this->asunto = $asunto_base;
        $this->cuerpo = $cuerpo_base;
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
        $response = Http::post(env('PRODUCTION_URL').'/callcenter/correos/recive', [
            'usuario' => Session::get('key')->usuario,
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
        $siniestro = Http::get(env('PRODUCTION_URL').'/siniestro/{siniestro}?token=427a903c0256cc73f7d2367f41e3236a220108162855&id='.$usuario);
        $siniestro = json_decode($siniestro);
        if ($siniestro != null) {
            $this->nombre = $siniestro->declarante_nombre;
            $this->email = $siniestro->declarante_email;
        }
    }
    // cerrar session
    public function cerrarsession()
    {
        Session::flush();
        return view('login');
    }
    // busqueda input correos
    public function letra()
    {
        $this->correosbus = Http::get(env('PRODUCTION_URL').'/callcenter/correos?token='.Session::get('key')->token.'&id_user='.Session::get('key')->usuario.'&asunto='.$this->let.'&fechai='.$this->fecha_inicio.'&fechaf='.$this->fecha_fin)->body();
        $this->correosbus = collect(json_decode($this->correosbus));
        // if ($this->fecha_inicio && $this->fecha_fin) {
        //     $this->resetPage();
        // }
    }
    // si se actualiza el input de buscar se reinicia las paginas
    public function updatingLet()
    {
        $this->resetPage();
        $this->entrada = 1;
    }
    // resetpage
    public function pageRest()
    {
        $this->resetPage();
    }
}
