@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Registrar Administrador</h2>
            <form action="{{ route('administradores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="caracteristicasJSON" class="form-label">Características (JSON)</label>
                    <textarea name="caracteristicasJSON" id="caracteristicasJSON" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">¿Activo?</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Guardar Administrador</button>
                <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
