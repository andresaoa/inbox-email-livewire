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
            <a href="{{ route('plantillas.create') }}" class="ml-2 btn btn-success">Crear nuevo</a>
        </div>
    </div>
    @livewire('show-plantilla-livewire')
</div>
