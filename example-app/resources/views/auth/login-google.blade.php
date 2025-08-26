@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white text-center fs-5 fw-bold">
                    <i class="fab fa-google me-2"></i>Acceso seguro con Google
                </div>
                <div class="card-body text-center">
                    <p class="mb-4 fs-6 text-secondary">
                        Para acceder a la plataforma, debes iniciar sesión con tu cuenta de Google.<br>
                        <span class="text-danger">Nunca compartas tu contraseña con nadie.</span>
                    </p>
                    <a href="{{ route('login.google') }}" class="btn btn-lg btn-danger d-flex align-items-center justify-content-center gap-2 mx-auto" style="min-width: 240px; font-size: 1.15rem;">
                        <i class="fab fa-google"></i> Iniciar sesión con Google
                    </a>
                    <hr class="my-4">
                    <small class="text-muted">Serás redirigido a Google para ingresar tu correo y contraseña de forma segura.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Botón de inicio de sesión con Google
<div id="g_id_onload"
data-client_id="407435070764-eh72qg5h8beqo3soifru2uheepqhh2hi.apps.googleusercontent.com"
data-callback="handleCredentialResponse"
data-auto_prompt="false">
</div>
-->