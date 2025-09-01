<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                @auth
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Eventos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('eventos.index') }}">Buscar Evento</a></li>
                            <li><a class="dropdown-item" href="{{ route('eventos.create') }}">Crear Evento</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Sub-Eventos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('sub-eventos.index') }}">Buscar Sub-Eventos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Reportes</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('participantes.index') }}">Participantes</a></li>
                        </ul>
                    </li>

                    <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                @endauth
                <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                <li><a class="dropdown-item" href="/">Index</a></li>
                <!-- Agrega más enlaces a módulos aquí -->
            </ul>
        </div>
        <a class="navbar-brand ms-3" href="{{ route('home') }}">{{ config('app.name', 'App') }}</a>
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
</body>
<script>
    document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let submenu = this.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('show');
            }
        });
    });
</script>
</html>
