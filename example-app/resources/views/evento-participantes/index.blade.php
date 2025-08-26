@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Participantes</h2>
    <a href="{{ route('evento-participantes.create') }}" class="btn btn-primary mb-3">Registrar Participante</a>
    <form method="GET" action="{{ route('evento-participantes.index') }}" class="row g-3 mb-4">
        <div class="col-md-2">
            <select name="evento_id" class="form-select">
                <option value="">-- Evento --</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}" @if(request('evento_id') == $evento->id) selected @endif>{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="evento_sub_evento_id" class="form-select">
                <option value="">-- Sub-Evento --</option>
                @foreach($subeventos as $subevento)
                    <option value="{{ $subevento->id }}" @if(request('evento_sub_evento_id') == $subevento->id) selected @endif>{{ $subevento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="user_id" class="form-select">
                <option value="">-- Usuario --</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" @if(request('user_id') == $usuario->id) selected @endif>{{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="activo" class="form-select">
                <option value="" @if(!request()->has('activo')) selected @endif>-- Estado --</option>
                <option value="1" @if((request()->has('activo') && request('activo')==='1') || !request()->has('activo')) selected @endif>Activo</option>
                <option value="0" @if(request('activo')==='0') selected @endif>No Activo</option>
            </select>
        </div>
        <div class="col-md-2">
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
                <th>Sub-Evento</th>
                <th>Usuario</th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participantes as $participante)
                <tr>
                    <td>{{ $participante->id }}</td>
                    <td>{{ $participante->evento->nombre ?? '-' }}</td>
                    <td>{{ $participante->subEvento->nombre ?? '-' }}</td>
                    <td>{{ $participante->usuario->name ?? '-' }}</td>
                    <td>{{ $participante->descripcion }}</td>
                    <td>{{ $participante->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('evento-participantes.edit', $participante) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('evento-participantes.destroy', $participante) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay participantes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
