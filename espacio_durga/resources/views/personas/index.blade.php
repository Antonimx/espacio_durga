@extends('templates.master')

@section('contenido-pagina')

@if($nombreRuta == 'alumnos')
    <x-titulo-gestion 
        :urlVolver="route('alumnos.index')" 
        :titulo="'Agregar nuevo alumno'"  
        :boton="true"
        :urlBoton="route('alumnos.create', ['rut' => 'no'])" 
        :textoBoton="'Crear nuevo'" 
    />
@elseif($nombreRuta == 'usuarios')
    <x-titulo-gestion 
        :urlVolver="route('usuarios.index')" 
        :titulo="'Agregar nuevo usuario'"  
        :boton="true"
        :urlBoton="route('usuarios.create')" 
        :textoBoton="'Crear nuevo'" 
    />
@else 
    <x-titulo-gestion 
        :urlVolver="route('home.index')" 
        :titulo="'Listado de personas'"  
        :boton="false"
        :urlBoton="route('usuarios.create')" 
        :textoBoton="'Crear nuevo'" 
    />
@endif

<div class="card border-dark">
    <div class="card-header bg-dark text-white" style="font-weight: bold;">
        <h5 class="m-0">Listado de personas @if($nombreRuta == 'alumnos') que no son alumnos @elseif ($nombreRuta == 'usuarios') que no son usuarios @endif </h5>
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
                        @if(in_array($nombreRuta, ['alumnos','usuarios']))
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
                        @if(in_array($nombreRuta, ['alumnos','usuarios']))
                        <td class="small text-center">
                        @if($nombreRuta == 'alumnos')
                            <a href="{{route('alumnos.create',$persona->rut)}}" class="btn btn-sm btn-primary pb-0" data-bs-toggle="tooltip" title="Añadir a alumnos">
                                <i class="material-icons text-white" style="font-size: 1.1em">person_add</i>
                            </a>
                        @elseif($nombreRuta == 'usuarios')
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

@push('scripts')
<script>
  $(document).ready(function() {
    var table = $('#personasTable').DataTable({
      "paging": true,
      "searching": true,
      "info": true,
      "lengthChange": false,
      "ordering": true,
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "zeroRecords": "No se encontraron registros coincidentes",
        "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
      }
    });
    $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
        var searchTerm = $('#search-persona').val().toLowerCase();
        var columnsToSearch = [1, 2, 3]; // Índices de las columnas a buscar
        for (var i = 0; i < columnsToSearch.length; i++) {
          if (data[columnsToSearch[i]].toLowerCase().indexOf(searchTerm) !== -1) {
            return true; // Muestra la fila si el término de búsqueda está en alguna de las columnas
          }
        }
        return false; // Oculta la fila si el término de búsqueda no está en ninguna de las columnas
      }
    );

    // Aplicar el filtro personalizado al escribir en el campo de búsqueda
    $('#search-persona').on('keyup', function() {
      table.draw();
    });

  });
</script>
@endpush
@endsection