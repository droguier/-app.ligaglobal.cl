@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Crear Nuevo Sub-Evento</h2>
            <form action="{{ route('sub-eventos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="evento_id" class="form-label">Evento</label>
                    <select name="evento_id" id="evento_id" class="form-select" required>
                        <option value="">Seleccione un evento</option>
                        @foreach($eventos as $evento)
                            <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="fecha_evento" class="form-label">Fecha y Hora del Sub-Evento</label>
                    <input type="datetime-local" name="fecha_evento" id="fecha_evento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">¿Activo?</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Guardar Sub-Evento</button>
                <a href="{{ route('sub-eventos.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
