<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espacio Durga</title>

    <link rel="icon" href="{{ Storage::url('images/logo_durga.ico') }}" type="image/x-icon">

    <!-- Enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/custom-bs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <!-- JS de jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- JS de Bootstrap -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand me-2" href="{{ route('home.index') }}">
                <img src="{{ Storage::url('images/logo_durga.ico') }}" alt="Logo durga" width="54" height="44">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @if(Route::current()->getName() == 'home.index') active @endif" aria-current="page" href="{{ route('home.index') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::current()->getName() == 'asistencia.index') active @endif" href="{{route('asistencia.index')}}">Tomar asistencia</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(Route::current()->getName(), ['alumnos.index', 'alumnos.create', 'alumnos.edit','alumnos.show'])) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Alumnos
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light bg-light">
                            <li><a class="dropdown-item @if(in_array(Route::current()->getName(), ['alumnos.index','alumnos.edit','alumnos.show'])) active @endif" href="{{route('alumnos.index')}}">Gestionar alumnos</a></li>
                            <li><a class="dropdown-item @if(in_array(Route::current()->getName(), ['alumnos.create','personas.index'])) active @endif" href="{{route('personas.index',['from' => 'alumnos'])}}">Agregar nuevo alumno</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(Route::current()->getName(), ['contratos.index', 'contratos.create'])) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Contratos planes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light bg-light">
                            <li><a class="dropdown-item @if(in_array(Route::current()->getName(), ['contratos.index'])) active @endif" href="{{route('contratos.index')}}">Lista de contratos</a></li>
                            <li><a class="dropdown-item @if(in_array(Route::current()->getName(), ['contratos.create'])) active @endif" href="{{route('contratos.create')}}">Crear nuevo contrato</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Planes mensuales</a>
                    </li>
                    @if(Gate::allows('admin-gestion'))
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Usuarios del sistema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Personas</a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="manageUsuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @auth
                            {{ Auth::user()->persona->nombre }} {{ Auth::user()->persona->apellido }} <i class="material-icons ms-2">person</i>
                            @endauth
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light bg-light dropdown-menu-end" aria-labelledby="manageUsuarioDropdown">
                            <li><a class="dropdown-item disabled" href="#">Administrar cuenta</a></li>
                            <li><a class="dropdown-item" href="{{ route('usuarios.logout') }}">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- /NAVBAR --}}

    {{-- CONTENIDO PAGINA --}}
    <div class="container p-3 bg-light">
        @yield('contenido-pagina')
    </div>
    {{-- /CONTENIDO PAGINA --}}
      
    <!-- JS de DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>
</html>
