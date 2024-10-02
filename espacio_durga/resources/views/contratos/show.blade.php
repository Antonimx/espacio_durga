@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('alumnos.show',$alumno->rut)" :titulo="'Historial de contratos de '. $alumno->persona->nombre .' '. $alumno->persona->apellido" :boton="false" :urlBoton="'#'" :textoBoton="'#'"/>

<div class="row mb-3" style="height: calc(100vh - 100px);">
    <div class="col-lg-12 d-flex flex-column" style="height: 100%;">
        @if($contratos->isEmpty())
            <h5 class="card-title">No hay registro de contratos finalizados</h5>
        @else
            <div class="row mb-3">
                <div class="col-lg-12">
                    <input type="text" id="search-contratos" class="form-control mb-2" placeholder="Buscar por fecha inicio o razón de termino...">
                </div>
            </div>
    
            <div class="table-responsive flex-grow-1">
                <table id="contratosTable" class="table table-stripped table-bordered table-hover">
                    <thead class="table-light text-white">
                        <tr>

                            <th>Nº</th>
                            <th>Tipo de plan</th>
                            <th>Fecha inicio</th>
                            <th>Fecha vencimiento</th>
                            <th>Clases asistidas</th>
                            <th>Fecha termino</th>
                            <th>Razón termino del contrato</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contratos as $i => $contrato)
                        <tr>
                            <td class="small text-center">{{ $i+1 }}</td>
                            <td class="small">{{ $contrato->planMensual->nombre }}</td>
                            <td class="small">{{ $contrato->inicio_mensualidad_formateada }}</td>
                            <td class="small">{{ $contrato->fin_mensualidad_formateada }}</td>
                            <td class="small">{{$contrato->clases_asistidas}}</td>
                            <td class="small fw-bold">{{ $contrato->fecha_termino_contrato_formateada }}</td>
                            <td class="small fw-bold">{{$contrato->razon_termino}}</td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
    var table = $('#contratosTable').DataTable({
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
        var searchTerm = $('#search-contratos').val().toLowerCase();
        var columnsToSearch = [2,6]; // Índices de las columnas a buscar
        for (var i = 0; i < columnsToSearch.length; i++) {
          if (data[columnsToSearch[i]].toLowerCase().indexOf(searchTerm) !== -1) {
            return true; // Muestra la fila si el término de búsqueda está en alguna de las columnas
          }
        }
        return false; // Oculta la fila si el término de búsqueda no está en ninguna de las columnas
      }
    );

    // Aplicar el filtro personalizado al escribir en el campo de búsqueda
    $('#search-contratos').on('keyup', function() {
      table.draw();
    });

  });
</script>
@endpush
@endsection
