@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('alumnos.index')" 
@if($nombreRuta == 'alumnos.index')
:titulo=" 'Agregar alumno'"
@elseif ($nombreRuta == 'usuarios.index') 
:titulo="'Agregar usuario'"
@else :titulo="'Listado de personas'" @endif
:boton="@if(in_array($nombreRuta, ['alumnos.index','usuarios.index'])) true @else false @endif"
:urlBoton="@if($nombreRuta == 'alumnos.index') 'route(alumnos.create)' @elseif ($nombreRuta == 'usuarios.index') 'route('usuarios.create')' @endif" 
:textoBoton="Crear nuevo"/>

<div class="card border-dark">
    <div class="card-header bg-dark text-white" style="font-weight: bold;">
        <h5 class="m-0">Listado de personas @if($nombreRuta == 'alumnos.index') que no son alumnos @elseif ($nombreRuta == 'usuarios.index') que no son usuarios @endif </h5>
    </div>
    <div class="card-body">
        <div class="col-lg-12 ">
            <input type="text" id="search-persona" class="form-control mb-2" placeholder="Buscar por rut, nombre o apellido">
        </div>
        <div class="table-responsive">
            <table id="personasTable" class="table table-striped table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nº</th>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        @if(in_array($nombreRuta, ['alumnos.index','usuarios.index']))
                        <th>Añadir</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($personas as $index=>$persona)
                    <tr>
                        <td class="small text-center">{{ $index+1 }}</td>
                        <td class="small">{{ $persona->rut }}</td>
                        <td class="small">{{ $persona->nombre }}</td>
                        <td class="small">{{ $persona->apellido }}</td>
                        @if(in_array($nombreRuta, ['alumnos.index','usuarios.index']))
                        <td class="small text-center">
                        @if($nombreRuta == 'alumnos.index')
                            <a href="{{route('alumnos.create')}}" class="btn btn-sm btn-primary pb-0" data-bs-toggle="tooltip" title="Añadir a alumnos">
                                <i class="material-icons text-white" style="font-size: 1.1em">person_add</i>
                            </a>
                        @elseif($nombreRuta == 'usuarios.index')
                            <a href="{{route('usuarios.create')}}" class="btn btn-sm btn-primary pb-0" data-bs-toggle="tooltip" title="Añadir a usuarios">
                                <i class="material-icons text-white" style="font-size: 1.1em">person_add</i>
                            </a>
                        @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection