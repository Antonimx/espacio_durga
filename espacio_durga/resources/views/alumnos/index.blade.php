@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('home.index')" :titulo="'Gestión de alumnos'" :boton="true" :urlBoton="route('alumnos.create')" :textoBoton="'Agregar nuevo alumno'"/>

<div class="row ">
    <div class="col-12 mb-3">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white" style="font-weight: bold;">
                <h5 class="m-0">Listado de alumnos</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-12 ">
                    <input type="text" id="search-alumno" class="form-control mb-2" placeholder="Buscar por rut, nombre o apellido">
                </div>
                <div class="table-responsive">
                    <table id="alumnosTable" class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nº</th>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $index=>$alumno)
                            <tr>
                                <td class="small text-center">{{ $index+1 }}</td>
                                <td class="small">{{ $alumno->rut }}</td>
                                <td class="small">{{ $alumno->persona->nombre }}</td>
                                <td class="small">{{ $alumno->persona->apellido }}</td>
                                <td class="small text-center">
                                  <a href="{{ route('alumnos.show', $alumno->rut) }}" class="btn btn-sm btn-primary pb-0" data-bs-toggle="tooltip" title="Ver ficha del alumno">
                                      <i class="material-icons text-white" style="font-size: 1.1em">manage_search</i>
                                  </a>
                                  <a title="Borrar alumno" class="btn btn-danger btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#borrarModal{{ $alumno->rut }}">
                                    <i class="material-icons text-white" style="font-size: 1.1em">person_off</i>
                                  </a>   
                                </td>
                            </tr>
                            <x-modal-borrado 
                            :url="'alumnos.destroy'"
                            :id="$alumno->rut" 
                            :nombre="$alumno->persona->nombre" 
                            :textoBoton="'Borrar alumno'" 
                            />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
    var table = $('#alumnosTable').DataTable({
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
        var searchTerm = $('#search-alumno').val().toLowerCase();
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
    $('#search-alumno').on('keyup', function() {
      table.draw();
    });

  });
</script>
@endpush

@endsection
