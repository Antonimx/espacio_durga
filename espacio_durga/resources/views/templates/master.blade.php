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
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <!-- JS de jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- JS de Bootstrap -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

    </style>
</head>

<body>
    <main>
        <div class="sidebar p-3 bg-light" style="width: 280px;">
            <a href="{{route('home.index')}}" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <img class="bi me-2" width="45" height="37" src="{{ Storage::url('images/logo_durga.ico') }}" alt="Logo durga">
                <span class="fs-5 fw-semibold">Espacio Durga</span>
            </a>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#asistencia-collapse" aria-expanded="true">
                        Asistencia
                    </button>
                    <div class="collapse show" id="asistencia-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('asistencia.index')}}" class="link-dark rounded">Tomar asistencia</a></li>
                            <li><a href="{{route('asistencia.gestionar')}}" class="link-dark rounded">Gestionar asistencia</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#alumnos-collapse" aria-expanded="true">
                        Alumnos
                    </button>
                    <div class="collapse show" id="alumnos-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('alumnos.index')}}" class="link-dark rounded">Gestionar alumnos</a></li>
                            <li><a href="{{route('personas.index',['from'=>'alumnos'])}}" class="link-dark rounded">Crear un nevo alumno</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#contratos-collapse" aria-expanded="true">
                        Planes Contratados
                    </button>
                    <div class="collapse show" id="contratos-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{ route('contratos.index') }}" class="link-dark rounded">Lista de planes contratados</a></li>
                            <li><a href="{{ route('contratos.create') }}" class="link-dark rounded">Crear un nuevo contrato</a></li>
                        </ul>
                    </div>
                </li>

                @if(Gate::allows('admin-gestion'))
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#planes-collapse" aria-expanded="false">
                        Planes
                    </button>
                    <div class="collapse" id="planes-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('planes.index')}}" class="link-dark rounded">Gesionar planes</a></li>
                            <li><a href="{{route('planes.create')}}" class="link-dark rounded">Crear un nuevo plan mensual</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#usuarios-collapse" aria-expanded="false">
                        Usuarios
                    </button>
                    <div class="collapse" id="usuarios-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('usuarios.index')}}" class="link-dark rounded">Gestionar usuarios</a></li>
                            <li><a href="{{route('personas.index',['from'=>'usuarios'])}}" class="link-dark rounded">Crear un nuevo usuario</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#personas-collapse" aria-expanded="false">
                        Personas
                    </button>
                    <div class="collapse" id="personas-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('personas.gestion')}}" class="link-dark rounded">Gestionar personas</a></li>
                        </ul>
                    </div>
                </li>
                @endauth
            </ul>
            <div class="dropdown dropdown-light mt-auto">
                <hr>
                <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="material-icons me-2" style="font-size: 1.1em">person</i>
                    <strong>
                        @auth
                        {{ Auth::user()->persona->nombre }} {{ Auth::user()->persona->apellido }}
                        @endauth
                    </strong>
                </a>
                <ul class="dropdown-menu bg-light text-small shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item text-dark" href="{{route('usuarios.create')}}">Administrar cuenta</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-dark" href="{{route('usuarios.logout')}}">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
        
    </main>

    {{-- CONTENIDO PAGINA --}}
    <div class="content">
        @yield('contenido-pagina')
    </div>
    {{-- /CONTENIDO PAGINA --}}
    </main>
    <!-- JS de DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>
</html>
