<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Menú desplegable a la izquierda -->
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="menuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Menú
            </button>
            <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                <li><a class="dropdown-item" href="{{ route('eventos.index') }}">Eventos</a></li>
                <li><a class="dropdown-item" href="{{ route('sub-eventos.index') }}">Sub-Eventos</a></li>
                <li><a class="dropdown-item" href="{{ route('participantes.index') }}">Participantes</a></li>
                <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                <li><a class="dropdown-item" href="/">Index</a></li>
                <!-- Agrega más enlaces a módulos aquí -->
            </ul>
        </div>
        <a class="navbar-brand ms-3" href="/">{{ config('app.name', 'App') }}</a>
        <div class="ms-auto">
            <!-- Login/Usuario a la derecha -->
            @guest
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Login
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                    <li><a class="dropdown-item" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <!-- Puedes agregar registro u otros enlaces aquí -->
                </ul>
            </div>
            @else
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            @endguest
        </div>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
