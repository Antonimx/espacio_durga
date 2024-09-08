@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('alumnos.index')" 
:titulo="'Ficha de ' . $alumno->persona->nombre . ' ' . $alumno->persona->apellido"  
:boton="true"
:urlBoton="route('alumnos.edit', $alumno->rut)" 
:textoBoton="'Editar datos del alumno'"/>

<div class="row mb-3">
    {{-- CARD DATOS DEL ALUMNO --}}
    <div class="col-lg-6">
        <div class="card text-dark border-dark d-flex h-100">
            <div class="card-header bg-dark text-white">
                <b>Datos del alumno</b>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="rut" class="form-label text-dark">Rut</label>
                            <input type="text" class="form-control" id="rut" name="rut" value="{{$alumno->rut}}" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="nombre" class="form-label text-dark">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{$alumno->persona->nombre}}" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="apellido" class="form-label text-dark">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="{{$alumno->persona->apellido}}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="fecha_nac" class="form-label text-dark">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="{{$alumno->persona->fecha_nac}}" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="direccion" class="form-label text-dark">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="{{$alumno->persona->direccion}}" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="fono" class="form-label text-dark">Número de contacto</label>
                            <input type="text" class="form-control" id="fono" name="fono" value="{{$alumno->persona->fono}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="observaciones" class="form-label text-dark">Observaciones</label>
                            <textarea rows="2" class="form-control" id="observaciones" maxlength="200" name="observaciones">{{$alumno->observaciones}}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ASISTENCIAS --}}
    <div class="col-lg-6">
        <div class="card text-dark border-secondary h-100 d-flex flex-column">
            <div class="card-header bg-secondary text-white">
                <b>Asistencias</b>
            </div>
            <div class="card-body">
                @if($asistencias->isEmpty())
                    <h5 class="card-title">No hay registro de asistencias</h5>
                @else
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <input type="text" id="search-fecha" class="form-control mb-2" placeholder="Buscar por fecha u hora...">
                    </div>
                    <div class="col-lg-6">
                        <input type="text" id="search-plan" class="form-control" placeholder="Buscar por tipo de plan...">
                    </div>
                </div>
                
                <div class="table-responsive" style="max-height: 250px;">
                    <table id= "asistenciasTable"class="table table-stripped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Fecha y hora</th>
                                <th>Tipo de Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $index=>$asistencia)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$asistencia->fecha_hora_formateada}}</td>
                                <td>{{$asistencia->contratoPlan->planMensual->nombre}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<div class="row">
    {{-- CARD PLANES CONTRATADOS --}}
    <div class="col-lg-12">
        <div class="card text-dark border-primary">
            <div class="card-header bg-primary text-white">
                <b>Planes Contratados</b>
            </div>
            <div class="card-body">
            {{-- CONTRATOS ACTIVOS --}}
                @if($contratoVigente !== null)
                <h5 class="card-title">Plan activo</h5>
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo de Plan</th>
                                <th>Inicio mensualidad</th>
                                <th>Fin mensualidad</th>
                                <th>N° de clases disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$contratoVigente->planMensual->nombre}}</td>
                                <td>{{$contratoVigente->inicio_mensualidad_formateada}}</td>
                                <td>{{$contratoVigente->fin_mensualidad_formateada}}</td>
                                <td>{{$contratoVigente->n_clases_disponibles}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="card-title">No hay planes activos</h5>

                @endif
                <hr>
                {{-- CONTRATOS PASADOS --}}
                @if ($contratos->isNotEmpty())
                <h5 class="card-title">Planes pasados</h5>
                <div class="table-responsive style="max-height: 400px">
                    <table class="table table-stripped table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tipo de Plan</th>
                                <th>Inicio mensualidad</th>
                                <th>Fin mensualidad</th>
                                <th>Clases asistidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $index=>$contrato)
                            <tr>
                                <td>{{$contrato->planMensual->nombre}}</td>
                                <td>{{$contrato->inicio_mensualidad_formateada}}</td>
                                <td>{{$contrato->fin_mensualidad_formateada}}</td>
                                <td>{{$contrato->planMensual->n_clases - $contrato->n_clases_disponibles}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                @else
                <h5 class="card-title">No hay planes pasados</h5>
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
        "search": "Buscar por fecha:",
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "_START_ a _END_ de _TOTAL_",
        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "zeroRecords": "No se encontraron registros coincidentes",
        "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
      }
    });
    $('#search-fecha').on('keyup', function() {
        table.columns(1).search(this.value).draw();
    });
    $('#search-plan').on('keyup', function() {
        table.columns(2).search(this.value).draw();
    });

  });
</script>
@endpush
@endsection