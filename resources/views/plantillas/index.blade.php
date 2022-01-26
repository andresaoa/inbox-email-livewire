@extends('layouts.guest')
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
</div>
