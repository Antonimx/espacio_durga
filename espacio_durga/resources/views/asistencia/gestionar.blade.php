@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('asistencia.index')" :titulo="'Gestionar asistencia'" :boton="false" :urlBoton="'#'" :textoBoton="'#'"/>

<div class="row mb-3">
    {{-- ASISTENCIAS --}}
    <div class="col-lg-12">
        <div class="card text-dark border-dark h-100 d-flex flex-column">
            <div class="card-header bg-dark text-white">
                <b>Historial de asistencias</b>
            </div>
            <div class="card-body">
                @if($asistencias->isEmpty())
                    <h5 class="card-title">No hay registro de asistencias</h5>
                @else
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <input type="text" id="search-asistencia" class="form-control mb-2" placeholder="Buscar por rut...">
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table id= "asistenciasTable"class="table table-stripped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Rut alumno</th>
                                <th>Tipo de plan</th>
                                <th>Fecha y hora</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $index=>$asistencia)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$asistencia->rut_alumno}}</td>
                                <td>{{$asistencia->contratoPlan->planMensual->nombre}}</td>
                                <td>{{$asistencia->fecha_hora_formateada}}</td>
                                <td class="small text-center">
                                    <a href="#" class="btn btn-danger btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#borrarModal{{$asistencia->id}}">
                                      <i class="material-icons text-white" style="font-size: 1.1em">delete</i>
                                    </a>  
                                </td>
                            </tr>
                            <x-modal-borrado 
                            :url="'asistencia.destroy'"
                            :id="$asistencia->id" 
                            :nombre="$asistencia->rut_alumno . ' | ' . $asistencia->fecha_hora_formateada"
                            :textoBoton="'Borrar registro de asistencia'" 
                              />
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
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
                var columnToSearch = 1; 
                if (data[columnToSearch].toLowerCase().indexOf(searchTerm) !== -1) {
                    return true; 
                }
                return false; 
            }
        );

        // Aplicar el filtro personalizado al escribir en el campo de búsqueda
        $('#search-asistencia').on('keyup', function() {
            table.draw();
        });
    });
</script>
@endpush
@endsection