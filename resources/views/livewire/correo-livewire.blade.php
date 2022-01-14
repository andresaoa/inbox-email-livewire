<div class="mail-box">
    <aside class="sm-side h-100">
        <div class="user-head">
            <h2 class="text-center">AOA EMAIL</h2>
            <div class="user-name">
                <h5><a href="#">Alireza Zare</a></h5>
                <span><a href="#">Info.Ali.Pci@Gmail.com</a></span>
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
        <aside class="lg-side">
            <form>
                <div class="inbox-head">

                    <div class="form-group row">
                        <label for="siniestro" class="col-sm-2 col-form-label">Siniestro: </label>
                        <div class="col-sm-10">
                            <input type="number" wire:model="usuario" class="form-control" id="siniestro"
                                placeholder="111222" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Correo Cliente:</label>
                        <div class="col-sm-10">
                            <input type="text" wire:model="email" class="form-control" id="email" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="asunto" class="col-sm-2 col-form-label">Asunto:</label>
                        <div class="col-sm-10">
                            <input type="text" wire:model="asunto" class="form-control" id="asunto"
                                placeholder="Caso Adjudicado" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col-sm-10">
                            <input type="text" readonly disabled class="form-control" id="name"
                                placeholder="Usuario Prueba" />
                        </div>
                    </div>

                </div>
                <div class="container-fluid mt-4">
                    <div class="row">
                        <div class="col-sm" wire:ignore>
                            <textarea wire:model="cuerpo" id="editor" cols="60" rows="10">

                            {{-- {{$cuerpo}} --}}
                        </textarea>
                        </div>
                        <div class="col-sm">
                            <ul class="list-group">
                                <li class="list-group-item">Plantilla predefinidas</li>
                                @foreach ($plantillas as $index => $plantilla)
                                    <li class="list-group-item mouse-hover"
                                        wire:click="PlantillaRelleno('{{ $plantilla->asunto_base }}')">
                                        {{ $index + 1 }} -
                                        {{ $plantilla->asunto_base }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <a wire:click="$emit('seguroenviar')" class="btn btn-primary ml-4">Enviar</a>
            </form>
        </aside>
    @else
        <div class="container mt-4">
            <div class="row inbox-wrapper">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($verasunto as $item)
                                    <div class="container">
                                        <div class="email-body">
                                            <p>Hola,</p>
                                            <br />
                                            <p> Nombre : {{ $item->usuario }}</p>
                                            <p>Email : {{ $item->email }}</p>
                                            <p>CC email : {{ $item->cc_email }}</p>

                                            <br />
                                            <p>{{ $item->cuerpo_mensaje }}</p>
                                            <br />
                                            <p><strong>Envaido</strong><br />{{$item->fecha_envio}}</p>
                                        </div>
                                        @if ($item->adjunto)
                                            <div class="email-attachments">
                                                <div class="title">Archivos <span>({{count($item->adjunto)}})</span>
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
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('seguroenviar', () => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('correo-livewire', 'save');

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        </script>
        {{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(function(editor) {
                    editor.model.document.on('change:data', () => {
                        @this.set('cuerpo_mensaje', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script> --}}
    @endpush
</div>
