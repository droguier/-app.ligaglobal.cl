@php
    $defaultActivo = $filtros['activo'];
    $defaultFechaDesde = $filtros['fecha_evento_desde'];
    $defaultFechaHasta = $filtros['fecha_evento_hasta'];
    $defaultNombre = $filtros['nombre'];
@endphp

@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Eventos</h2>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Evento</a>
    <form method="GET" action="{{ route('eventos.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $defaultNombre }}">
        </div>
        <div class="col-md-3">
                <input type="date" name="fecha_evento_desde" class="form-control" value="{{ $defaultFechaDesde }}" placeholder="Desde">
        </div>
        <div class="col-md-3">
                <input type="date" name="fecha_evento_hasta" class="form-control" value="{{ $defaultFechaHasta }}" placeholder="Hasta">
        </div>
        <div class="col-md-3">
            <select name="activo" class="form-select">
                <option value="" >-- Estado --</option>
                <option value="1" @if($defaultActivo == '1')  selected @endif>Activo</option>
                <option value="0" @if($defaultActivo == '0')  selected @endif>No Activo</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
            <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha Evento</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($eventos as $evento)
                <tr>
                    <td>{{ $evento->id }}</td>
                    <td>{{ $evento->nombre }}</td>
                    <td>{{ $evento->descripcion }}</td>
                    <td>{{ $evento->fecha_evento }}</td>
                    <td>{{ $evento->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de desactivar?')">Desactivar</button>
                        </form>
                        <a href="{{ route('participantes.inscribir', $evento->id) }}" class="btn btn-sm btn-info">Registrar Participante</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay eventos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
