@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Editar Participante</h2>
            <form action="{{ route('participantes.update', $participante) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="evento_id" class="form-label">Evento</label>
                    <select name="evento_id" id="evento_id" class="form-select" required>
                        @foreach($eventos as $evento)
                            <option value="{{ $evento->id }}" @if($participante->evento_id == $evento->id) selected @endif>{{ $evento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="evento_sub_evento_id" class="form-label">Sub-Evento</label>
                    <select name="evento_sub_evento_id" id="evento_sub_evento_id" class="form-select">
                        @foreach($subeventos as $subevento)
                            <option value="{{ $subevento->id }}" @if($participante->evento_sub_evento_id == $subevento->id) selected @endif>{{ $subevento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" @if($participante->user_id == $usuario->id) selected @endif>
                                {{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ $participante->descripcion }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">¿Activo?</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1" @if($participante->activo) selected @endif>Sí</option>
                        <option value="0" @if(!$participante->activo) selected @endif>No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha de registro</label>
                    <input type="text" class="form-control" value="{{ $participante->created_at ? $participante->created_at->format('d/m/Y H:i') : '' }}" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Participante</button>
                <a href="{{ route('participantes.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>

@endsection
