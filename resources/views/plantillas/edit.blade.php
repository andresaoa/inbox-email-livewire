@extends('layouts.guest')
<div class="container">
    <h2 class="text-center mt-4 mb-4">Actualizar plantillas</h2>
    <button class="btn btn-success" onclick="history.back()">Volver</button>
    <form method="post" action="{{route('plantillas.update',$id[0]->id)}}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Asunto</label>
            <input value="{{$id[0]->asunto_base}}" type="text" class="form-control" name="asunto" id="exampleFormControlInput1">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Cuerpo</label>
            <textarea class="form-control" id="editor" name="cuerpo" rows="3">
                {!!$id[0]->cuerpo_base!!}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #003057;">Actualizar</button>
    </form>
</div>