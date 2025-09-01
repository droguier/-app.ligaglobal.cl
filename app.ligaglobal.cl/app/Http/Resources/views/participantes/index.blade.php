@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Participantes</h2>
    <a href="{{ route('participantes.create') }}" class="btn btn-primary mb-3">Registrar Participante</a>
    <form method="GET" action="{{ route('participantes.index') }}" class="row g-3 mb-4">
        <div class="col-md-2">
            <select name="evento_id" class="form-select">
                <option value="">-- Evento --</option>
                @if(!empty($eventos))
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}" @if(isset($filtros['evento_id']) && $filtros['evento_id'] == $evento->id) selected @endif>{{ $evento->nombre }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <select name="sub_evento_id" class="form-select">
                <option value="">-- Sub-Evento --</option>
                @if(!empty($subeventos))
                    @foreach($subeventos as $subevento)
                        <option value="{{ $subevento->id }}" @if(isset($filtros['sub_evento_id']) && $filtros['sub_evento_id'] == $subevento->id) selected @endif>{{ $subevento->nombre }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <select name="user_id" class="form-select">
                <option value="">-- Usuario --</option>
                @if(!empty($usuarios))
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" @if(isset($filtros['user_id']) && $filtros['user_id'] == $usuario->id) selected @endif>{{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <select name="activo" class="form-select">
                <option value="" @if(!isset($filtros['activo'])) selected @endif>-- Estado --</option>
                <option value="1" @if(isset($filtros['activo']) && $filtros['activo'] === '1') selected @endif>Activo</option>
                <option value="0" @if(isset($filtros['activo']) && $filtros['activo'] === '0') selected @endif>No Activo</option>
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
                <th>Fecha registro</th>
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
                    <td>{{ $participante->created_at ? $participante->created_at->format('d/m/Y H:i') : '' }}</td>
                    <td>
                        <a href="{{ route('participantes.edit', $participante->id) }}" class="btn btn-sm btn-warning">Editar</a>                        
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay participantes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
