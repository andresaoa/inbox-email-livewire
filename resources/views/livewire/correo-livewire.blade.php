<div class="mail-box">
    <style>
        .ck-editor__editable {
            min-height: 270px !important;
        }

    </style>
    {{-- barra izquierda bienvenida aoacall y sus datos --}}
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
                <br>
                <span type="button" data-toggle="modal" data-target="#fecha">
                    Filtrar
                </span>

            </div>
        </div>
        <div class="inbox-body">
            <a @if ($entrada == 2) href="/" @endif title="Compose" class="btn w-100 aoa-btn text-white" wire:click="NuevoCorreo">
                Nuevo Correo
            </a>
            <div class="anyClass">
                
                <input type="text" wire:keydown="letra" wire:model="let" @if ($entrada == 2) disabled @endif
                    class="form-control mb-2" placeholder="Seleccione el asunto que busca">
                    <div wire:loading class="">
                        <div class="list-item">Cargando...</div>
                    </div>
                {{-- <div id="cargando">Cargando</div> --}}
                <table id="example" class="table table-striped">
                    <tbody>
                        @if ($correosbus)
                            @foreach ($correosbus->paginate(10) as $correo)
                                <tr class="mouse-hover" wire:click="VerCorreo({{ $correo->id }})">
                                    <th scope="row">{{ $correo->id }}</th>
                                    <td>{{ Str::limit($correo->asunto, 10) }}</td>
                                    <td class="font-weight-light">
                                        {{ \Carbon\Carbon::parse($correo->fecha_envio)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (count($correosbus) >= 9 and $entrada == 1)
                    <div class="d-flex justify-content-center mb-4">{{ $correos->links() }}</div>
                @endif

            </div>

        </div>
    </aside>
    {{-- condicional de donde esta situado, si viendo correo o enviando correos --}}
    @if ($entrada == 1)
        {{-- formulario y registro de correos --}}
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
                                    {{ $plantilla->asunto_base }} - <b
                                        >{{ $plantilla->cuerpo_base }}</b> </option>
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
                <div class="form-group">
                    <label for="inputAddress2">Cuerpo:</label>
                    <section class="">
                        {{-- <div class="flex-box">
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
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="flex-box" wire:ignore>
                                    <textarea wire:model="cuerpo" id="editor" class="form-control" name="name"
                                        rows="10" cols="100" placeholder="Escriba su cuerpo Aca"></textarea>
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
        {{-- plantilla correo enviado --}}

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <meta name="x-apple-disable-message-reformatting">
            <style>
                @media screen and (max-width: 530px) {
                    .unsub {
                        display: block;
                        padding: 8px;
                        margin-top: 14px;
                        border-radius: 6px;
                        background-color: #103156;
                        text-decoration: none !important;
                        font-weight: bold;
                    }

                    .col-lge {
                        max-width: 100% !important;
                    }
                }

                @media screen and (min-width: 531px) {
                    .col-sml {
                        max-width: 27% !important;
                    }

                    .col-lge {
                        max-width: 73% !important;
                    }
                }

                #shadow {
                    box-shadow: 0px 10px 10px black;
                }

            </style>
        </head>

        <div role="article" aria-roledescription="email" lang="en"
            style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#">
            <table role="presentation" style="width:100%;border:none;border-spacing:0; ">
                <tr>
                    <td align="center" style="padding:0;">

                        <table role="presentation"
                            style="margin-top:20px;width:94%;max-width:600px;border-top:10px solid rgb(168,173,0);border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;"
                            id="shadow">
                            <tr>
                                <td
                                    style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                                    <a href="http://www.example.com/" style="text-decoration:none;"><img
                                            src="https://www.aoacolombia.com/wp-content/uploads/2019/09/cropped-logotipo-aoa-colombia-1.png"
                                            width="165" alt="Logo"
                                            style="width:405px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:30px;background-color:#ffffff;">
                                    <h1
                                        style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;text-align:center">
                                        CORREO AOA</h1>
                                    {{-- {{dd($verasunto[0])}} --}}
                                    <p>Para: {{ $verasunto[0]->email }}</p>
                                    @php
                                        $data = [
                                            'email' => $verasunto[0]->email,
                                            'usuario' => $verasunto[0]->to,
                                            'siniestro' => $verasunto[0]->siniestro,
                                        ];
                                        foreach ($data as $variable => $value) {
                                            $verasunto[0]->cuerpo_mensaje = str_ireplace(":$variable", $value, $verasunto[0]->cuerpo_mensaje);
                                        }
                                    @endphp
                                    {!! $verasunto[0]->cuerpo_mensaje !!}
                                    <p>AOA en alianza con las aseguradoras pone a disposición del asegurado un
                                        vehículo
                                        de reemplazo por un período
                                        determinado de tiempo.Puede disponer de su vehículo en caso de cualquier
                                        siniestro una vez sea aprobado por la compañía aseguradora.</p>
                                    <p>La tranquilidad de movilizarse de forma fácil y segura, una ventaja que
                                        ofrecen
                                        los vehículos en alquiler de AOA.
                                        Solicite las múltiples soluciones de Renta de Vehículo en tamaño, capacidad
                                        y
                                        uso, desde un día hasta un año de servicio.</h6>
                                        @if ($verasunto[0]->adjunto != null)
                                            @php
                                                $explode = explode(',', $verasunto[0]->adjunto);
                                                $if = count($explode);
                                            @endphp
                                            @if ($if >= 1)
                                                <p style="margin:10;"><a
                                                        href="{{ config('url') . asset($explode[0]) }}"
                                                        download="newfilename"
                                                        style="background: #103156; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;">
                                                        <span style="mso-text-raise:10pt;font-weight:bold; ">DESCARGAR
                                                            PDF 1</span>
                                                    </a></p>
                                            @endif
                                            @if ($if >= 2)
                                                <p style="margin:10;"><a
                                                        href="{{ config('url') . asset($explode[0]) }}"
                                                        download="newfilename"
                                                        style="background: #103156; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;">
                                                        <span style="mso-text-raise:10pt;font-weight:bold; ">DESCARGAR
                                                            PDF 2</span>
                                                    </a></p>
                                            @endif
                                            @if ($if >= 3)
                                                <p style="margin:10;"><a
                                                        href="{{ config('url') . asset($explode[0]) }}"
                                                        download="newfilename"
                                                        style="background: #103156; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;">
                                                        <span style="mso-text-raise:10pt;font-weight:bold; ">DESCARGAR
                                                            PDF 3</span>
                                                    </a></p>
                                            @endif
                                        @endif
                                        <a style="text-decoration:none;"><img
                                                src="https://app.aoacolombia.com/imgemail/Logos.png" width="600" alt=""
                                                style="width:100%;height:100px;display:block;border:none;text-decoration:none;color:#363636;"></a>

                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="padding:30px;text-align:center;font-size:12px;background-color:#103156;color:#cccccc;">
                                    <p style="margin:0 0 8px 0;"><a
                                            href="https://www.facebook.com/Administraci%C3%B3n-Operativa-Automotriz-SAS-100961215687318"
                                            style="text-decoration:none;"><img
                                                src="https://app.aoacolombia.com/imgemail/md_5b01251200ff5-removebg-preview(1).png"
                                                width="40" height="40" alt="f"
                                                style="display:inline-block;color:#cccccc;"></a> <a
                                            href="https://www.linkedin.com/company/aoa-colombia"
                                            style="text-decoration:none;"><img
                                                src="https://app.aoacolombia.com/imgemail/linkedin-blanco.png"
                                                width="40" height="40" alt="t"
                                                style="display:inline-block;color:#cccccc;"></a></p>
                                    <div id="mover2" style="inline-box-align: 0;">
                                        <h6 id="parrafo1"><strong>Carrera 69B 98A-10 Morato, Bogota D.C</strong>
                                        </h6>
                                        <h6 id="parrafo2"><strong>PBX: (057) 1 7560512 Fax (057) 7560512</strong>
                                        </h6>
                                        <h6 id="parrafo3"><strong>www.aoacolombia.com</strong></h6>
                                        <h6 id="parrafo4"><strong>NIT: 900.174.552-5</strong></h6>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>
            </table>
        </div>
    @endif
    {{-- modal cerrar session --}}
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
    {{-- modal filtro por fecha --}}
    <div class="modal fade" id="fecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h2>Filtrar por fecha</h2>
                </div>
                <div class="form-row p-4">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">DESDE:</label>
                        <input id="fecha_ini" type="date" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">HASTA:</label>
                        <input id="fecha_fin" type="date" class="form-control" />
                    </div>
                    <button id="filtrar" data-dismiss="modal" class="btn aoa-btn text-white">FILTRAR</button>
                </div>
            </div>
        </div>
    </div>
    {{-- javascript añadidos --}}
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
                        $('form :input').val('');
                        $('.ck-editor__editable').html( '' );
                    }
                })
            })
        </script>
        <script>
            document.addEventListener('livewire:load', function() {
                $("#filtrar").click(function() {
                    let fecha_ini = $('#fecha_ini').val();
                    let fecha_fin = $('#fecha_fin').val();
                    @this.fecha_inicio = fecha_ini;
                    @this.fecha_fin = fecha_fin;
                    console.log(fecha_ini);
                    // $('#cargando').show;
                });
            })
        </script>
        <script>
            document.addEventListener('livewire:load', function() {
                ClassicEditor
                    .create(document.getElementById('editor'),{
                        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            @this.set('cuerpo', editor.getData());
                        });
                        $("#pla").click(function() {
                            let asunto = $('#pla').val();
                            // console.log(asunto[0]);
                            editor.setData(asunto[0]);
                        });


                    })
                    .catch(error => {
                        console.error(error);
                    });
            })
        </script>
    @endpush
</div>
