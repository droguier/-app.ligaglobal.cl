@php
    $pageTitle = 'Login con Google | Liga Global';
@endphp

@extends('LigaGlobal::layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <a href="https://doodles.google/doodle/lelia-gonzalezs-85th-birthday/" target="_blank" rel="noopener">
                            <img src="{{ asset('img/google/doodles/lelia-gonzalezs-85th-birthday-6753651837108278-2x.png') }}" alt="Lélia Gonzalez's 85th Birthday Doodle" style="max-width:100%;height:auto;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                        </a>
                    </div>
                    @guest
                        <a href="{{ url('auth/google') }}" class="btn btn-lg border border-[#FF2D20] bg-white text-[#FF2D20] font-bold px-4 py-2 d-inline-flex align-items-center" style="box-shadow:0 2px 8px rgba(255,45,32,0.08);">
                            <img src="{{ asset('img/google/g-logo.png') }}" alt="Google" style="width:24px; margin-right:8px; vertical-align:middle;">
                            Iniciar sesión con Google
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
