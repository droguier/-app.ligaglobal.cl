@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Administradores</h2>
    <a href="{{ route('administradores.create') }}" class="btn btn-primary mb-3">Registrar Administrador</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Características</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($administradores as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->usuario->rut ? strtoupper($admin->usuario->rut) . ' - ' . $admin->usuario->name : $admin->usuario->name }}</td>
                    <td><pre class="mb-0">{{ $admin->caracteristicasJSON }}</pre></td>
                    <td>{{ $admin->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('administradores.edit', $admin) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('administradores.destroy', $admin) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay administradores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
