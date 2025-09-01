@extends('LigaGlobal::layouts.app')

@section('title', 'Página no encontrada')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="display-1">404</h1>
    <h2>Página no encontrada</h2>
    <p>La página que buscas no existe o ha sido movida.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Ir al inicio</a>
</div>
@endsection
