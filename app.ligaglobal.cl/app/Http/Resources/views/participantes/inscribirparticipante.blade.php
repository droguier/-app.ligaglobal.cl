@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Registrar Participante por Evento</h2>
            <form action="{{ route('participantes.inscribir-guardar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>Información del Evento</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-4"><strong>ID:</strong></div>
                                <div class="col-8">{{ $evento->id ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Nombre:</strong></div>
                                <div class="col-8">{{ $evento->nombre ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Fecha:</strong></div>
                                <div class="col-8">
                                    {{ \Carbon\Carbon::parse($evento->fecha_evento ?? '')->translatedFormat('l d-m-Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="evento_sub_evento_id" class="form-label">Sub-Evento</label>
                    <select name="evento_sub_evento_id" id="evento_sub_evento_id" class="form-select">
                        <option value="">Seleccione un sub-evento</option>
                        @foreach($subeventos as $subevento)
                            <option value="{{ $subevento->id }}">
                                {{ $subevento->id . ' - ' . $subevento->nombre }}
                            </option>
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
                    <label for="descripcion" class="form-label">Observación</label>
                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Guardar Participante</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>

@endsection
