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

    <style>

    </style>
</head>

<body style="background-color: #FFEDE5">
    {{-- SIDENAV --}}
    <div class="sidenav">
        <div class="logo-container">
            <a href="{{ route('home.index') }}">
                <img src="{{ Storage::url('images/logo_durga.ico') }}" alt="Logo durga" class="logo">
            </a>
        </div>
        <a href="{{ route('home.index') }}" class="@if(Route::current()->getName() == 'home.index') active @endif">Inicio</a>
        <a href="{{route('asistencia.index')}}" class="@if(Route::current()->getName() == 'asistencia.index') active @endif">Tomar asistencia</a>

        <button class="dropdown-btn @if(in_array(Route::current()->getName(), ['alumnos.index', 'alumnos.create', 'alumnos.edit','alumnos.show'])) active @endif">
            Alumnos <i class="material-icons fa fa-caret-down">arrow_drop_down</i>
        </button>
        <div class="dropdown-container">
            <a class="@if(in_array(Route::current()->getName(), ['alumnos.index','alumnos.edit','alumnos.show'])) active @endif" href="{{route('alumnos.index')}}">Gestionar alumnos</a>
            <a class="@if(in_array(Route::current()->getName(), ['alumnos.create','personas.index'])) active @endif" href="{{route('personas.index',['from' => 'alumnos'])}}">Agregar nuevo alumno</a>
        </div>

        <button class="dropdown-btn @if(in_array(Route::current()->getName(), ['contratos.index', 'contratos.create'])) active @endif">
            Contratos planes <i class="material-icons fa fa-caret-down">arrow_drop_down</i>
        </button>
        <div class="dropdown-container">
            <a class="@if(in_array(Route::current()->getName(), ['contratos.index'])) active @endif" href="{{route('contratos.index')}}">Lista de contratos</a>
            <a class="@if(in_array(Route::current()->getName(), ['contratos.create'])) active @endif" href="{{route('contratos.create')}}">Crear nuevo contrato</a>
        </div>
        
        @if(Gate::allows('admin-gestion'))
        <a href="{{route('usuarios.index')}}" class="">Usuarios del sistema</a>
        <a href="{{route('personas.gestion')}}" class="">Personas</a>
        @endif
        
        <div class="logout-container">
            <button class="logout-button"><i class="material-icons">logout</i></button>
        </div>
    </div>
    {{-- /SIDENAV --}}

    {{-- CONTENIDO PAGINA --}}
    <div class="content">
        @yield('contenido-pagina')
    </div>
    {{-- /CONTENIDO PAGINA --}}

    <!-- JS de DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;
        
        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active-btn");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
              dropdownContent.style.display = "none";
            } else {
              dropdownContent.style.display = "block";
            }
          });
        }
    </script>

    @stack('scripts')
</body>
</html>
