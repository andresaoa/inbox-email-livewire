@extends('layouts.guest')

<div class="container">
    <h2 class="text-center mt-4 mb-4">Crear plantillas</h2>
    <form method="post" action="{{route('plantillas.store')}}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Asunto</label>
            <input type="text" class="form-control" name="asunto" id="exampleFormControlInput1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Cuerpo</label>
            <textarea class="form-control" id="editor" name="cuerpo" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
