@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Sub-Eventos</h2>
    <a href="{{ route('sub-eventos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Sub-Evento</a>
    <form method="GET" action="{{ route('sub-eventos.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="evento_id" class="form-select">
                <option value="">-- Evento --</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}" @if(($filtros['evento_id'] ?? '') == $evento->id) selected @endif>{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $filtros['nombre'] ?? '' }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_evento_desde" class="form-control" value="{{ $filtros['fecha_evento_desde'] ?? '' }}" placeholder="Desde">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_evento_hasta" class="form-control" value="{{ $filtros['fecha_evento_hasta'] ?? '' }}" placeholder="Hasta">
        </div>
        <div class="col-md-2">
            <select name="activo" class="form-select">
                <option value="" @if(!isset($filtros['activo']) || $filtros['activo'] === null || $filtros['activo'] === '') selected @endif>-- Estado --</option>
                <option value="1" @if(isset($filtros['activo']) && $filtros['activo'] === '1') selected @endif>Activo</option>
                <option value="0" @if(isset($filtros['activo']) && $filtros['activo'] === '0') selected @endif>No Activo</option>
            </select>
        </div>
        <div class="col-md-1 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
            <a href="{{ route('sub-eventos.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Evento</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subeventos as $subevento)
                <tr>
                    <td>{{ $subevento->id }}</td>
                    <td>{{ $subevento->evento->nombre ?? '-' }}</td>
                    <td>{{ $subevento->nombre }}</td>
                    <td>{{ $subevento->descripcion }}</td>
                    <td>{{ $subevento->fecha_evento }}</td>
                    <td>{{ $subevento->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('sub-eventos.edit', $subevento) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('sub-eventos.destroy', $subevento) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de desactivar?')">Desactivar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay sub-eventos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
