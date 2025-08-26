<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Inicio</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('eventos.index') }}">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('evento-sub-eventos.index') }}">Sub-Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('evento-participantes.index') }}">Participantes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('administradores.index') }}">Administradores</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('camara') }}">Cámara</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('qr.upload') }}">QR Backend</a></li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <span class="navbar-text fw-bold text-primary">
                                Bienvenido Mr(s) '{{ Auth::user()->name }}'
                            </span>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <main class="container">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
