@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Listado de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3"><i class="fa fa-user-plus"></i> Nuevo Usuario</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>RUT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->rut ?? '--' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay usuarios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
