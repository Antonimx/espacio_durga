@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('contratos.index')" :titulo="'Crear nuevo contrato'" :boton="false" :urlBoton="'#'" :textoBoton="'#'"/>

<div class="row ">
    <div class="col-12 mb-3">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white" style="font-weight: bold;">
                <h5 class="m-0">Listado de alumnos sin plan contratado</h5>
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
                                <th>Agregar contrato plan</th>
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
                                  <a href="#" class="btn btn-success btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#agregarModal{{$alumno->rut}}">
                                    <i class="material-icons text-white" style="font-size: 1.1em">add</i>
                                  </a>  
                                </td>
                            </tr>
                            {{-- MODAL AGREGAR CONTRATO --}}
                            <div class="modal fade" id="agregarModal{{$alumno->rut}}" tabindex="-1" aria-labelledby="Modal{{$alumno->rut}}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5 text-dark text-bold" id="agregarModal{{$alumno->rut}}Label">¿Crear contrato para {{$alumno->persona->nombre}} {{$alumno->persona->apellido}}?</h1>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{route('contratos.store')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rut_alumno" value="{{$alumno->rut}}">
                                        <div class="mb-3">
                                            <label for="plan_mensual_id" class="form-label text-dark">Plan Mensual</label>
                                            <select class="form-select" aria-label="Plan Mensual" id="plan_mensual_id" name="plan_mensual_id">
                                                <option  value="0">Seleccionar</option>
                                                @foreach ($planes as $plan)
                                                <option value="{{$plan->id}}">{{$plan->nombre}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="d-flex justify-content-end "> 
                                          <button type="button" class="btn btn-danger text-white me-2" data-bs-dismiss="modal">Cancelar</button>
                                          <button type="submit" class="btn btn-success text-white">Aceptar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </div>
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

