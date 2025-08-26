@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Registrar Participante</h2>
            <form action="{{ route('evento-participantes.store') }}" method="POST">
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
                    <label for="evento_sub_evento_id" class="form-label">Sub-Evento</label>
                    <select name="evento_sub_evento_id" id="evento_sub_evento_id" class="form-select">
                        <option value="">Seleccione un sub-evento</option>
                        @foreach($subeventos as $subevento)
                            <option value="{{ $subevento->id }}">{{ $subevento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">
                                {{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">¿Activo?</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Guardar Participante</button>
                <a href="{{ route('evento-participantes.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
