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
                    <input type="text" id="search-contratos" class="form-control mb-2" placeholder="Buscar por fecha u hora...">
                </div>
            </div>
    
            <div class="table-responsive flex-grow-1">
                <table id="contratosTable" class="table table-stripped table-bordered table-hover">
                    <thead class="table-light text-white">
                        <tr>

                            <th>Nº</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            
                            <th>Tipo de plan</th>
                            <th>Fecha termino</th>
                            <th>Fecha inicio</th>
                            <th>Fecha vencimiento</th>
                            <th>N° de clases tomadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contratos as $i => $contrato)
                        <tr>
                            <td class="small text-center">{{ $i+1 }}</td>
                            <td class="small">{{ $contrato->rut_alumno }}</td>
                            <td class="small">{{ $contrato->alumno->persona->nombre }}</td>
                            <td class="small">{{ $contrato->alumno->persona->apellido }}</td>
                            <td class="small">{{ $contrato->planMensual->nombre }}</td>
                            <td class="small fw-bold">{{ $contrato->fecha_termino_contrato_formateada }}</td>
                            <td class="small">{{ $contrato->inicio_mensualidad_formateada }}</td>
                            <td class="small">{{ $contrato->fin_mensualidad_formateada }}</td>
                            <td class="small">{{$contrato->planMensual->n_clases - $contrato->n_clases_disponibles}}</td>
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
            "pageLength":15,
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
                var searchTerm = $('#search-asistencia').val().toLowerCase();
                var columnToSearch = 2; 
                if (data[columnToSearch].toLowerCase().indexOf(searchTerm) !== -1) {
                    return true; 
                }
                return false; 
            }
        );

        $('#search-asistencia').on('keyup', function() {
            table.draw();
        });
    });
</script>
@endpush
@endsection
