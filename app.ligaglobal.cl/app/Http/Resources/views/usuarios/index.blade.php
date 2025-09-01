@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Registrar Usuario</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->rut ?? '-' }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->lastname ?? '-' }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro de desactivar?')">Desactivar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay usuarios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
