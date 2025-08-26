@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Sub-Eventos</h2>
    <a href="{{ route('evento-sub-eventos.create') }}" class="btn btn-primary mb-3">Crear Nuevo Sub-Evento</a>
    <form method="GET" action="{{ route('evento-sub-eventos.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="evento_id" class="form-select">
                <option value="">-- Evento --</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}" @if(request('evento_id') == $evento->id) selected @endif>{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_evento" class="form-control" value="{{ request('fecha_evento') }}">
        </div>
        <div class="col-md-2">
            <select name="activo" class="form-select">
                <option value="" @if(!request()->has('activo')) selected @endif>-- Estado --</option>
                <option value="1" @if((request()->has('activo') && request('activo')==='1') || !request()->has('activo')) selected @endif>Activo</option>
                <option value="0" @if(request('activo')==='0') selected @endif>No Activo</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
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
                        <a href="{{ route('evento-sub-eventos.edit', $subevento) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('evento-sub-eventos.destroy', $subevento) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
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
