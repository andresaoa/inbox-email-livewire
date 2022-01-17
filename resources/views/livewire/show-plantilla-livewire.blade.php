<div>
    <table class="table bg-white">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Asunto</th>
                <th scope="col">Cuerpo</th>
                <th scope="col" colspan="2">Operaciones</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($plantillas as $plantilla)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $plantilla->asunto_base }}</td>
                    <td>{!! $plantilla->cuerpo_base !!}</td>
                    <td><a href="{{route('plantillas.edit',$plantilla->id)}}" class="btn btn-primary"><i
                                class="fa fa-pencil" aria-hidden="true"></i></a></td>
                    <td><a wire:click="$emit('seguro',{{$plantilla->id}})" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('seguro', plantillaId => {
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
                        Livewire.emitTo('show-plantilla-livewire', 'delete',plantillaId);
                        Swal.fire(
                        'Eliminado!',
                        'Se ha eliminado con exito.',
                        'success'
                        )
                    }
                })
            })
        </script>
    @endpush
</div>
