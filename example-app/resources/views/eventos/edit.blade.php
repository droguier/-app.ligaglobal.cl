@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
    <h2>Editar Evento</h2>
    <form action="{{ route('eventos.update', $evento) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $evento->nombre }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $evento->descripcion }}</textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_evento" class="form-label">Fecha del Evento</label>
            <input type="date" name="fecha_evento" id="fecha_evento" class="form-control" value="{{ $evento->fecha_evento }}" required>
        </div>
        <div class="mb-3">
            <label for="activo" class="form-label">¿Activo?</label>
            <select name="activo" id="activo" class="form-select">
                <option value="1" @if($evento->activo) selected @endif>Sí</option>
                <option value="0" @if(!$evento->activo) selected @endif>No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Evento</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
        </div>
    </div>
</div>
@endsection
