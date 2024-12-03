@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('home.index')" :titulo="'Gestión de planes mensuales'" :boton="true" :urlBoton="route('planes.create')" :textoBoton="'Agregar nuevo plan mensual'"/>

<div class="row ">
    <div class="col-12 mb-3">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white" style="font-weight: bold;">
                <h5 class="m-0">Listado de planes</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-12 ">
                    <input type="text" id="search-plan" class="form-control mb-2" placeholder="Buscar por nombre">
                </div>
                <div class="table-responsive">
                    <table id="planesTable" class="table table-striped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nº</th>
                                <th>Nombre</th>
                                <th>Número de clases</th>
                                <th>Valor</th>
                                <th>Cantidad de contratos activos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($planes as $index=>$plan)
                            <tr>
                                <td class="small text-center">{{ $index+1 }}</td>
                                <td class="small">{{ $plan->nombre }}</td>
                                <td class="small">{{ $plan->n_clases }}</td>
                                <td class="small">{{ $plan->valor_formateado }}</td>
                                <td class="small">{{ $plan->cant_contratos_activos }}</td>
                                <td class="small text-center">
                                  <a href="{{ route('planes.edit', $plan->id) }}" class="btn btn-sm btn-secondary pb-0" data-bs-toggle="tooltip" title="Editar datos del plan">
                                      <i class="material-icons text-white" style="font-size: 1.1em">edit</i>
                                  </a>
                                  @if($plan->estado == 1)
                                  <a href="#" class="btn btn-danger btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#borrarModal{{$plan->id}}">
                                    <i class="material-icons text-white" style="font-size: 1.1em">remove</i>
                                  </a>  
                                  @else
                                  <a href="{{ route('planes.reactivar',$plan->id) }}" class="btn btn-success btn-sm pb-0" data-bs-toggle="tooltip" title="Reactivar plan mensual">
                                    <i class="material-icons text-white" style="font-size: 1.1em">add</i>
                                  </a>  
                                  @endif
                                </td>
                            </tr>
                            <x-modal-borrado 
                            :url="'planes.destroy'"
                            :id="$plan->id" 
                            :textoTitulo="'¿Desea desactivar el plan '.$plan->nombre.'?'" 
                            :textoBoton="'Desactivar Plan Mensual'" 
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
    var table = $('#planesTable').DataTable({
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
        var searchTerm = $('#search-plan').val().toLowerCase();
        var columnsToSearch = [1]; // Índices de las columnas a buscar
        for (var i = 0; i < columnsToSearch.length; i++) {
          if (data[columnsToSearch[i]].toLowerCase().indexOf(searchTerm) !== -1) {
            return true; // Muestra la fila si el término de búsqueda está en alguna de las columnas
          }
        }
        return false; // Oculta la fila si el término de búsqueda no está en ninguna de las columnas
      }
    );

    // Aplicar el filtro personalizado al escribir en el campo de búsqueda
    $('#search-plan').on('keyup', function() {
      table.draw();
    });

  });
</script>
@endpush

@endsection
