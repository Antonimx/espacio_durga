@extends('templates.master')

@php
    use Carbon\Carbon;
@endphp
@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('home.index')" :titulo="'Toma de asistencia'" :boton="true" :urlBoton="route('asistencia.gestionar')" :textoBoton="'Gestionar asistencias'"/>
@if($errors->any())
<div class="alert alert-warning py-1">
    {{ $errors->all()[0] }}
</div>
@endif
<div class="row">
    <div class=" @if(!$errors->any() && $contratoPlan->id !== null) col-lg-8  @else  col-lg-12 @endif mb-3">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white" style="font-weight: bold;">
                <h5 class="m-0">Listado de alumnos con plan contratado</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
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
                                <th>Tomar asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratosActivos as $index=>$contrato)
                            <tr>
                                <td class="small text-center">{{ $index+1 }}</td>
                                <td class="small">{{ $contrato->rut_alumno }}</td>
                                <td class="small">{{ $contrato->alumno->persona->nombre }}</td>
                                <td class="small">{{ $contrato->alumno->persona->apellido }}</td>
                                <td class="small text-center">
                                    <form action="{{ route('asistencia.store', $contrato->rut_alumno) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm pb-0">
                                            <i class="material-icons text-white" style="font-size: 1.1em">person_check</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>         
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(!$errors->any() && $contratoPlan->id !== null)
    {{-- INFO ASISTENCIA --}}
    <div class="col-lg-4 mb-3">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white" style="font-weight: bold;">
                <h5 class="m-0">Asistencia registrada para {{$contratoPlan->alumno->persona->nombre}} {{$contratoPlan->alumno->persona->apellido}}.</h5>
            </div>
            <div class="card-body">
                <ul >
                    <li><strong class="text-dark">Plan contratado:</strong> {{ $contratoPlan->planMensual->nombre }}</li>
                    <li><strong class="text-dark">Fin mensualidad:</strong> {{ $contratoPlan->fin_mensualidad }}</li>
                    <li><strong class="text-dark">Número de clases disponibles:</strong> {{ $contratoPlan->n_clases_disponibles }}</li>
                    @if($contratoPlan->estado == 0)
                        <li><strong class="text-danger">Esta es la última clase para {{ $contratoPlan->alumno->persona->nombre }} {{ $contratoPlan->alumno->persona->apellido }}</strong></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @endif
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
