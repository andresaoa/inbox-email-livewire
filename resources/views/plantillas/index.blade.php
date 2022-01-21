@extends('layouts.guest')
{{-- @if ('message')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Actualizado</strong> con exito.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif --}}
<div class="container mb-4">
    <h2 class="text-center mt-4 mb-4">Listado de plantillas</h2>
    <div class="m-2">

    </div>
    <div class="d-flex flex-row-reverse bd-highlight">
        <div class="p-2 bd-highlight">
          <a href="{{ route('aoacall') }}" class="ml-2 btn text-white" style="background-color: #003057;">Volver a la vista principal</a>
          <a href="{{ route('plantillas.create') }}" class="ml-2 btn btn-success">Crear nuevo</a>  
        </div>
    </div>
    @livewire('show-plantilla-livewire')

    {{-- @if (Session::get('plantilla') == null)
        @push('js')
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: 'Submit your Github username',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: false,
                    confirmButtonText: 'Look up',
                    showLoaderOnConfirm: false,
                    allowOutsideClick: false,
                    preConfirm: (login) => {
                        return fetch(`//api.github.com/users/${login}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: `${result.value.login}'s avatar`,
                            imageUrl: result.value.avatar_url
                        })
                    }
                })
            </script>
        @endpush
    @endif --}}

</div>
