<div class="mail-box">
    <aside class="sm-side h-100">
        <div class="user-head">
            <h2 class="text-center">AOA EMAIL</h2>
            <div class="user-name">
                <h5><a href="#">{{ Session::get('key')->nombre }}</a></h5>
                <span><a href="#">{{ Session::get('key')->email }}</a></span>
                <br>
                @if (Session::get('permiso'))
                    <a href="{{ route('plantillas.index') }}" class="text-white">
                        Configuracion Plantillas
                    </a>
                    <br>
                @endif

                <span type="button" data-toggle="modal" data-target="#exampleModal">
                    Cerrar Sesion
                </span>

            </div>
        </div>
        <div class="inbox-body">
            <a title="Compose" class="btn w-100 btn-primary" wire:click="NuevoCorreo">
                Nuevo Correo
            </a>
            <div class="anyClass">
                @foreach ($correos as $correo)
                    <div class="bg-white p-3 mt-2 d-flex mouse-hover " wire:click="VerCorreo({{ $correo->id }})">
                        <div class="flex-grow-1">{{ Str::limit($correo->asunto, 10) }}</div>
                        <small>{{ $correo->fecha_envio }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </aside>
    @if ($entrada == 1)
        <div class="container mt-4">
            <form wire:submit.prevent="seguro">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Siniestro: </label>
                        <div class="input-group mb-3">
                            <input type="number" wire:model="usuario" class="form-control"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    wire:click="siniestro('{{ $usuario }}')">Buscar</button>
                            </div>
                        </div>
                        @error('usuario') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Nombre:</label>
                        <input type="text" wire:model="nombre" readonly disabled class="form-control" id="name" />
                    </div>
                </div>
                {{--  --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Correo Cliente:</label>
                        <input type="text" wire:model="email" readonly disabled class="form-control" id="email" />
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Asunto:</label>
                        <input type="text" wire:model="asunto" class="form-control" id="asunto" />
                        @error('asunto') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputState">Plantillas:</label>
                        <select class="custom-select" multiple>
                            @foreach ($plantillas as $index => $plantilla)
                                <option
                                    wire:click="PlantillaRelleno('{{ $plantilla->asunto_base }}','{{ $plantilla->cuerpo_base }}')">
                                    {{ $index + 1 }} -
                                    {{ $plantilla->asunto_base }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputState">Adjuntos:</label>
                        <p>
                            <input type="checkbox" wire:model="adjunto" value="assets/carro.pdf"> 
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="{{$adjunto == "assets/carro.pdf" ? '#007bff' : 'none'}}" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Carro Automotriz</span></a>
                            <input type="checkbox" wire:model="adjunto" value="assets/carro1.pdf">
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="{{$adjunto == 1 ? '#007bff' : 'none'}}" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Adjudicacion Monetaria</span></a>
                            <input type="checkbox" wire:model="adjunto" value="assets/carro2.pdf">
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="{{$adjunto == 1 ? '#007bff' : 'none'}}" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Carro Prestamo</span></a>
                        </p>
                    </div>
                </div>
                <div class="form-group" wire:ignore>
                    <label for="inputAddress2">Cuerpo:</label>
                    <textarea class="form-control" wire:model="cuerpo" id="editor" cols="30"
                        rows="6">{{ $cuerpo }}</textarea>
                    @error('cuerpo') <span class="error">{!! $message !!}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Enviar Correo</button>
            </form>
        </div>

    @else
        <div class="container mt-4">
            <div class="row inbox-wrapper">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($verasunto as $variable => $item)
                                    <div class="container">
                                        <div class="email-body">
                                            <p>Hola,</p>
                                            <br />
                                            <p> Nombre : {{ $item->usuario }}</p>
                                            <p>Email : {{ $item->email }}</p>
                                            <p>CC email : {{ $item->cc_email }}</p>
                                            @php
                                                $template = str_ireplace(":usuario",$item->usuario,$item->cuerpo_mensaje);
                                                echo $template;
                                            @endphp
                                            
                                            <br />
                                            <p><strong>Enviado</strong><br />{{ $item->fecha_envio }}</p>
                                        </div>
                                        {{-- @if ($item->adjunto)
                                            <div class="email-attachments">
                                                <div class="title">Archivos
                                                    <span>({{ count($item->adjunto) }})</span>
                                                </div>
                                                <ul>
                                                    <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-file">
                                                                <path
                                                                    d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                                </path>
                                                                <polyline points="13 2 13 9 20 9"></polyline>
                                                            </svg> {{ $item->adjunto }} <span
                                                                class="text-muted tx-11">(5.10
                                                                MB)</span></a></li>
                                                </ul>
                                            </div>
                                        @endif --}}
                                    </div>
                                @endforeach
                            </div>
                            <address style="font-size:8px">
                                <img class="w-100" alt=""
                                    src="https://www.aoacolombia.com/wp-content/uploads/2019/09/cropped-logotipo-aoa-colombia-1.png"
                                    width="250px"><br>
                                <p> ADMINISTRACIÓN OPERATIVA AUTOMOTRIZ </p>
                                <p>NIT.: 900.174.552-5</p>
                                <p>Carrera 69B 98A-10 Bogotá D.C.</p>
                                <p>Pbx: (057) 1 7560510 Fax (057) 1 7560512 </p>
                                <p>www.aoacolombia.com</p>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('js')
        {{-- <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then(function(editor){
                editor.model.document.on('change:data',()=>{
                    @this.set('cuerpo',editor.getData());
                })
            })
            .catch( error => {
                console.error( error );
            } );
            
    </script> --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('seguroenviar', () => {
                Swal.fire({
                    title: '¿Esta seguro de enviar el correo?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo enviarlo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('correo-livewire', 'save');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Enviando Correo...',
                            showConfirmButton: false,
                            timer: 2500,
                            allowOutsideClick: false
                        })
                    }
                })
            })
        </script>
    @endpush
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h2>¿Estas seguro?</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="cerrarsession()"
                        data-dismiss="modal">Cerrar Session</button>
                </div>
            </div>
        </div>
    </div>
</div>
