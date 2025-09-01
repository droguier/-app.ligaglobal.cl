@php
    $pageTitle = 'Login con Google | Liga Global';
@endphp

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2 class="mb-4">Iniciar sesión con Google</h2>
                    @guest
                        <a href="{{ url('auth/google') }}" class="btn btn-danger btn-lg">
                            Iniciar sesión con <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="width:24px; margin-right:8px;">
                        </a>
                    @else
                        <script>window.location.href = '{{ url('/home') }}';</script>
                        <div class="alert alert-success mt-4">Ya estás autenticado. Redirigiendo al Home...</div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
