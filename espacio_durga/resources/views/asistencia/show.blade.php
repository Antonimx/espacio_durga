@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('alumnos.show',$alumno->rut)" :titulo="'Historial de asistencia de '. $alumno->persona->nombre .' '. $alumno->persona->apellido" :boton="false" :urlBoton="'#'" :textoBoton="'#'"/>

<div class="row mb-3" style="height: calc(100vh - 100px);"> 
    <div class="col-lg-12 d-flex flex-column" style="height: 100%;">
        @if($asistencias->isEmpty())
            <h5 class="card-title">No hay registro de asistencias</h5>
        @else
            <div class="row mb-3">
                <div class="col-lg-12">
                    <input type="text" id="search-asistencia" class="form-control mb-2" placeholder="Buscar por fecha u hora...">
                </div>
            </div>
    
            <div class="table-responsive flex-grow-1">
                <table id="asistenciasTable" class="table table-stripped table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>N°</th>
                            <th>Tipo de plan</th>
                            <th>Fecha y hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asistencias as $index => $asistencia)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$asistencia->contratoPlan->planMensual->nombre}}</td>
                            <td>{{$asistencia->fecha_hora_formateada}}</td>
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
        var table = $('#asistenciasTable').DataTable({
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
