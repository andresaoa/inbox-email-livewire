<div class="mail-box">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{asset('js/jquery-ui/jquery-ui.min.css')}}">
    <!--Internal CSS start-->
    <style>
        /* textarea {
            padding: 3%;
            border-color: #957dad;
            border-width: thick;
        }

        .flex-box {
            display: flex;
            justify-content: center;
        } */

    </style>
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
                @if (Session::get('admin') == 'si')
                    <a href="{{ route('rol.index') }}" class="text-white">
                        Permisos
                    </a>
                    <br>
                @endif

                <span type="button" data-toggle="modal" data-target="#exampleModal">
                    Cerrar Sesion
                </span>

            </div>
        </div>
        <div class="inbox-body">
            <a title="Compose" class="btn w-100 aoa-btn text-white" wire:click="NuevoCorreo">
                Nuevo Correo
            </a>
            <div class="anyClass">
                <input type="text" wire:keydown="letra" wire:model="let" class="form-control mb-2" placeholder="Seleccione el asunto que busca">
                <table id="example" class="table table-striped">
                    <tbody>
                        @if ($correosbus)
                            @foreach ($correosbus->paginate(10) as $correo)
                                <tr class="mouse-hover" wire:click="VerCorreo({{ $correo->id }})">
                                    <th scope="row">{{$correo->id}}</th>
                                    <td>{{ Str::limit($correo->asunto, 10) }}</td>
                                    <td class="font-weight-light">{{ \Carbon\Carbon::parse($correo->fecha_envio)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (count($correosbus) >= 9)
                <div class="d-flex justify-content-center">{{$correos->links()}}</div>
                @endif
                
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
                        <select id="pla" class="custom-select" multiple>
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
                                    viewBox="0 0 24 24"
                                    fill="{{ $adjunto == 'assets/carro.pdf' ? '#003057' : 'none' }}"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Carro Automotriz</span></a>
                            <input type="checkbox" wire:model="adjunto" value="assets/carro1.pdf">
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="{{ $adjunto == 1 ? '#003057' : 'none' }}"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Adjudicacion Monetaria</span></a>
                            <input type="checkbox" wire:model="adjunto" value="assets/carro2.pdf">
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="{{ $adjunto == 1 ? '#003057' : 'none' }}"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                    </path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg><span>Carro Prestamo</span></a>
                        </p>
                    </div>
                </div>
                <div class="form-group" wire:ignore>
                    <label for="inputAddress2">Cuerpo:</label>
                    <section class="">
                        <div class="flex-box">
                            <div class="row">
                                <div class="col">
                                    <button type="button" onclick="f1()" class=" shadow-sm btn btn-outline-secondary"
                                        data-toggle="tooltip" data-placement="top" title="Bold Text">
                                        Bold</button>
                                    <button type="button" onclick="f2()" class="shadow-sm btn btn-outline-success"
                                        data-toggle="tooltip" data-placement="top" title="Italic Text">
                                        Italic</button>
                                    <button type="button" onclick="f3()" class=" shadow-sm btn btn-outline-primary"
                                        data-toggle="tooltip" data-placement="top" title="Left Align">
                                        <i class="fas fa-align-left"></i></button>
                                    <button type="button" onclick="f4()" class="btn shadow-sm btn-outline-secondary"
                                        data-toggle="tooltip" data-placement="top" title="Center Align">
                                        <i class="fas fa-align-center"></i></button>
                                    <button type="button" onclick="f5()" class="btn shadow-sm btn-outline-primary"
                                        data-toggle="tooltip" data-placement="top" title="Right Align">
                                        <i class="fas fa-align-right"></i></button>
                                    <button type="button" onclick="f6()" class="btn shadow-sm btn-outline-secondary"
                                        data-toggle="tooltip" data-placement="top" title="Uppercase Text">
                                        Upper Case</button>
                                    <button type="button" onclick="f7()" class="btn shadow-sm btn-outline-primary"
                                        data-toggle="tooltip" data-placement="top" title="Lowercase Text">
                                        Lower Case</button>
                                    <button type="button" onclick="f8()" class="btn shadow-sm btn-outline-primary"
                                        data-toggle="tooltip" data-placement="top" title="Capitalize Text">
                                        Capitalize</button>
                                    <button type="button" onclick="f9()" class="btn shadow-sm btn-outline-primary side"
                                        data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                        Clear Text</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="flex-box">
                                    <textarea wire:model="cuerpo" id="textarea1" class="form-control" name="name"
                                        rows="10" cols="100"
                                        placeholder="Escriba su cuerpo Aca">{!! $cuerpo !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                    @error('cuerpo') <span class="error">{!! $message !!}</span> @enderror
                </div>

                <button type="submit" class="btn aoa-btn text-white">Enviar Correo</button>
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
                                            <p> Enviado por : {{ Session::get('key')->usuario }}</p>
                                            <p>Email : {{ $item->email }}</p>
                                            <p>CC email : {{ $item->cc_email }}</p>
                                            @php
                                                $template = str_ireplace(':usuario', $item->usuario, $item->cuerpo_mensaje);
                                                echo $template;
                                            @endphp

                                            <br />
                                            <p><strong>Enviado</strong><br />{{ $item->fecha_envio }}</p>
                                        </div>
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
    @push('js')
        <script>
            function f1() {
                //function to make the text bold using DOM method
                document.getElementById("textarea1").style.fontWeight = "bold";
            }

            function f2() {
                //function to make the text italic using DOM method
                document.getElementById("textarea1").style.fontStyle = "italic";
            }

            function f3() {
                //function to make the text alignment left using DOM method
                document.getElementById("textarea1").style.textAlign = "left";
            }

            function f4() {
                //function to make the text alignment center using DOM method
                document.getElementById("textarea1").style.textAlign = "center";
            }

            function f5() {
                //function to make the text alignment right using DOM method
                document.getElementById("textarea1").style.textAlign = "right";
            }

            function f6() {
                //function to make the text in Uppercase using DOM method
                document.getElementById("textarea1").style.textTransform = "uppercase";
            }

            function f7() {
                //function to make the text in Lowercase using DOM method
                document.getElementById("textarea1").style.textTransform = "lowercase";
            }

            function f8() {
                //function to make the text capitalize using DOM method
                document.getElementById("textarea1").style.textTransform = "capitalize";
            }

            function f9() {
                //function to make the text back to normal by removing all the methods applied
                //using DOM method
                document.getElementById("textarea1").style.fontWeight = "normal";
                document.getElementById("textarea1").style.textAlign = "left";
                document.getElementById("textarea1").style.fontStyle = "normal";
                document.getElementById("textarea1").style.textTransform = "capitalize";
                document.getElementById("textarea1").value = " ";
            }

            $(document).ready(function() {

            });
        </script>
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
        {{-- <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
        <script src="{{asset('js/jquery-ui/jquery-ui.min.js')}}"></script>
        <script>
            var cursos = ['text','array','html','css'];
            $('#search').autocomplete({
                source: function(request,response) {
                    $.ajax({
                        url: "http://127.0.0.1:8000/api/callcenter/correos?token=MfNdmxEdsjeeZA43Mn49ObZXBWN1DMFhI8NdUGL2&id_user=2&asunto="+request.asunto,
                        dataType: 'json',
                        success: function(data){
                            response(data)
                        }
                    });
                }
            });
        </script> --}}
    @endpush
</div>
