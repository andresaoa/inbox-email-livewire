@extends('layouts.guest')

<div class="container">
    <h2 class="text-center mt-4 mb-4">Crear plantillas</h2>
    <button class="btn btn-success" onclick="history.back()">Volver</button>
    <form method="post" action="{{route('plantillas.store')}}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Asunto</label>
            <input type="text" class="form-control" name="asunto" id="exampleFormControlInput1">
        </div>

        {{-- <p>Si deseas que la plantilla reconozca nombre del usuario, email y siniestro, pon con las siguientes directivas. :nombre | :email | :siniestro </p> --}}
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Cuerpo</label>
            <textarea class="form-control" id="editor" name="cuerpo" rows="3" placeholder="Si deseas que la plantilla reconozca nombre del usuario, email y siniestro, pon con las siguientes directivas. :nombre | :email | :siniestro"></textarea>
            <div class="ck-reset ck-editor..." ...>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" style="background-color: #003057;">Crear</button>
    </form>
    
</div>
