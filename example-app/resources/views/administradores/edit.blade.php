@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Editar Administrador</h2>
            <form action="{{ route('administradores.update', $admin) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" @if($admin->user_id == $usuario->id) selected @endif>{{ $usuario->rut ? strtoupper($usuario->rut) . ' - ' . $usuario->name : $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="caracteristicasJSON" class="form-label">Características (JSON)</label>
                    <textarea name="caracteristicasJSON" id="caracteristicasJSON" class="form-control" rows="3">{{ $admin->caracteristicasJSON }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">¿Activo?</label>
                    <select name="activo" id="activo" class="form-select">
                        <option value="1" @if($admin->activo) selected @endif>Sí</option>
                        <option value="0" @if(!$admin->activo) selected @endif>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Administrador</button>
                <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
