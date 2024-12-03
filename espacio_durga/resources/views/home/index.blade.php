@extends('templates.master')

@section('contenido-pagina')

<div class="row mb-3">
    <x-cards-inicio :color="'primary'" :titulo="'Alumnos'" :icono="'people'" :cantidad="$alumnos"/>
    <x-cards-inicio :color="'secondary'" :titulo="'Contratos Activos'" :icono="'task'" :cantidad="$contratos"/>
    <x-cards-inicio :color="'info'" :titulo="'Contratos Finalizados'" :icono="'assignment'" :cantidad="$contratosFinalizados"/>
    <x-cards-inicio :color="'dark'" :titulo="'Ingresos del mes'" :icono="'paid'" :cantidad="$totalContratos"/>
</div>

<div class="row h-100">
    {{-- PERFIL DE ALUMNOS --}}
    <div class="col-lg-5">
        <div class="h-100">
            <div class="card border-dark h-100">
                <div class="card-header bg-dark text-white">
                    <b>Perfil de alumnos</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- POR RANGO DE EDAD --}}
                        <div class="col-lg-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <h6 class="card-title m-0 fw-bold">ALUMNOS</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons text-dark me-2" style="font-size: 1.5rem;">groups</i>
                                        <span class="text-muted me-2">por Rango de Edad</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex justify-content-end">
                                    <div class="row">                                           
                                        <div class="col-lg-12"><h6 class="card-title m-0 fw-bold">PROMEDIO</h6></div>
                                        <div class="col-lg-12"><p class="card-text text-body-secondary">Edad</p></div>
                                    </div>
                                </div>
                                <div class="col-lg-2 d-flex align-items-end">
                                    <h3 class="m-0 fw-bold text-body-secondary">{{$promedioEdad}}</h3>   
                                </div>
                            </div>
                            <div class="row"><canvas id="chartEdadAlumnos" style="width: 100%; height: 100%; display: block;"></canvas></div>
                        </div>
                        <hr>

                        {{-- POR GENERO --}}
                        <div class="col-lg-12 mb-3">
                            <div class="col-lg-6">
                                <h6 class="card-title m-0 fw-bold">ALUMNOS</h6>
                                <div class="d-flex align-items-center">
                                    <i class="material-icons text-dark me-2" style="font-size: 1.5rem;">groups</i>
                                    <span class="text-muted me-2">por Género</span>
                                </div>
                            </div>
                            <canvas id="chartGeneroContratos" style="width: 100%; height: 100%; display: block;"></canvas>
                        </div>
                        <hr>

                        {{-- POR NACIONALIDAD --}}
                        <div class="col-lg-12 mb-3">
                            <row class=" row mb-3">
                                <div class="col-lg-6">
                                    <h6 class="card-title m-0 fw-bold">ALUMNOS</h6>
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons text-dark me-2" style="font-size: 1.5rem;">groups</i>
                                        <span class="text-muted me-2">por Nacionalidad</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-between align-items-end">
                                    <span class="text-primary fw-bold">Extranjeros</span>
                                    <span class="fw-bold text-muted">{{ $extranjeroCount }}</span>
                                    <span class="text-secondary fw-bold"">/</span>
                                    <span class="text-dark fw-bold"">Chilenos</span>
                                    <span class="fw-bold text-muted">{{ $noExtranjeroCount }}</span>
                                </div>
                            </row>
                            <div class="progress" style="height: 10px; border-radius: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $extranjeroPercentage }}%;" aria-valuenow="{{ $extranjeroPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $noExtranjeroPercentage }}%;" aria-valuenow="{{ $noExtranjeroPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('alumnos.index')}}" class="btn btn-info btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Gestionar alumnos">
                        <i class="material-icons text-white" style="font-size: 1.1em">search</i>
                    </a>
                    <a href="{{route('personas.index',['from'=>'alumnos'])}}" class="btn btn-success btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Crear alumno nuevo">
                        <i class="material-icons text-white" style="font-size: 1.1em">add</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- PLANES CONTRATADOS/ASISTENCIAS MENSUALES --}}
    <div class="col-lg-7 d-flex flex-column">
        {{-- ASISTENCIAS MENSUALES --}}
        <div class="card text-dark mb-3 border-dark flex-grow-1">
            <div class="card-header bg-dark text-white">
                <b>Asistencias Mensuales</b>
            </div>
            <div class="card-body">
                <canvas id="asistenciasChart" style="width: 100%; height: 100%; display: block;"></canvas>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{route('asistencia.index')}}" class="btn btn-info btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Ver historial de asistencias">
                    <i class="material-icons text-white" style="font-size: 1.1em">search</i>
                </a>
                <a href="{{route('asistencia.create')}}" class="btn btn-success btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Tomar asistencia">
                    <i class="material-icons text-white" style="font-size: 1.1em">add</i>
                </a>
            </div>
        </div>
        {{-- PLANES CONTRATADOS ACTIVOS --}}
        <div class="card text-dark border-dark flex-grow-1">
            <div class="card-header bg-dark text-white">
                <b>Planes Contratados Activos</b>
            </div>
            <div class="card-body">
                <canvas id="contratosChart" style="width: 100%; height: 100%; display: block;"></canvas>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{route('contratos.index')}}" class="btn btn-info btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Ver lista de planes contratados">
                    <i class="material-icons text-white" style="font-size: 1.1em">search</i>
                </a>
                <a href="{{route('contratos.create')}}" class="btn btn-success btn-sm pb-0" data-bs-toggle="tooltip" title="Crear un nuevo contacto">
                    <i class="material-icons text-white" style="font-size: 1.1em">add</i>
                </a>
            </div>
        </div>

    </div>
</div>


@endsection
{{-- SCRIPTS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- LINE CHART | ASISTENCIAS MENSUALES --}}
<script>
    const ctxLine = document.getElementById('asistenciasChart').getContext('2d');

    // Etiquetas de los meses (usando la variable $labels desde el controlador)
    const labelsLine = {!! json_encode($labels) !!};

    // Datos de asistencias por mes (usando la variable $data desde el controlador)
    const dataLine = {
        labels: labelsLine,
        datasets: [{
            label: 'Asistencias Mensuales',
            data: {!! json_encode($data) !!},
            fill: false,
            borderColor: 'rgba(255, 71, 22, 0.5) ', // Color de la línea
            backgroundColor: 'rgba(255, 71, 22, 0.5) ', // Color de la línea
            tension: 0.1 // Curvatura de la línea
        }]
    };

    const configLine = {
        type: 'line',
        data: dataLine,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,  // Para que solo muestre enteros
                        precision: 0   // Eliminar los decimales
                    }
                }
            }
        }
    };

    // Crear el gráfico de líneas
    const asistenciasChart = new Chart(ctxLine, configLine);
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- BAR CHART | CANTIDAD DE PLANES CONTRATADOS ACTIVOS --}}
<script>
    const ctxBar = document.getElementById('contratosChart').getContext('2d');

    // Datos de planes enviados desde el backend
    const planes = @json($planes);

    // Preparar las etiquetas (nombres de los planes) y los datos (cantidad de contratos activos)
    const labelsBar = planes.map(plan => plan.nombre ?? 'Plan mensual eliminado');
    const dataBarValues = planes.map(plan => plan.cant_contratos_activos);

    const dataBar = {
        labels: labelsBar, // Nombres de los planes
        datasets: [{
            label: 'Cantidad de Planes Contratados Activos',
            data: dataBarValues, // Cantidad de contratos activos por plan
            backgroundColor: ['#FF4716', '#F95E9C', '#17A2B8', '#5600A8'], // Colores de las barras
            borderColor: ['#FF4716', '#F95E9C', '#17A2B8', '#5600A8'],
            borderWidth: 1
        }]
    };

    // Configuración del gráfico de barras
    const configBar = {
        type: 'bar',
        data: dataBar,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1, // Hacer que los ticks sean enteros
                        precision: 0 // Eliminar los decimales
                    }
                }
            },
            plugins: {
                legend: {
                    display: false, // Ocultar la leyenda
                }
            }
        }
    };

    // Crear el gráfico de barras
    const contratosChart = new Chart(ctxBar, configBar);
</script>

{{-- LINE CHART | ASISTENCIAS MENSUALES --}}
<script>
    const ctxLine = document.getElementById('asistenciasChart').getContext('2d');

    // Etiquetas de los meses (usando la variable $labels desde el controlador)
    const labelsLine = {!! json_encode($labels) !!};

    // Datos de asistencias por mes (usando la variable $data desde el controlador)
    const dataLine = {
        labels: labelsLine,
        datasets: [{
            label: 'Asistencias Mensuales',
            data: {!! json_encode($data) !!},
            fill: false,
            borderColor: 'rgba(255, 71, 22, 0.5) ', // Color de la línea
            backgroundColor: 'rgba(255, 71, 22, 0.5) ', // Color de la línea
            tension: 0.1 // Curvatura de la línea
        }]
    };

    const configLine = {
        type: 'line',
        data: dataLine,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,  // Para que solo muestre enteros
                        precision: 0   // Eliminar los decimales
                    }
                }
            },
            plugins: {
                legend: {
                    display: false, // Ocultar la leyenda
                }
            }
        }
    };

    // Crear el gráfico de líneas
    const asistenciasChart = new Chart(ctxLine, configLine);
</script>
{{-- SCRIPT PERFIL ALUMNO->GENERO --}}
<script>
    // Datos para géneros de todos los contratos
    const dataGenerosContratos = {
        labels: {!! json_encode($generoAlumnos->keys()) !!}, // Géneros
        datasets: [{
            label: 'Género de los alumnos del espacio',
            data: {!! json_encode($generoAlumnos->values()) !!}, // Conteo de cada género
            backgroundColor: [ '#FF4716','#F95E9C', '#17A2B8'], // Colores
            hoverOffset: 4
        }]
    };
    const configGenerosContratos = {
        type: 'bar', // Tipo de gráfico
        data: dataGenerosContratos,
        options: {
            indexAxis: 'y', // Hacer las barras horizontales
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,  // Hacer que los ticks sean enteros
                        precision: 0   // Eliminar los decimales
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' alumnos';
                        }
                    }
                }
            }
        }
    };
    new Chart(document.getElementById('chartGeneroContratos'), configGenerosContratos);
</script>
{{-- PERFIL ALUMNO EDAD --}}
<script>
    const dataEdadAlumnos = {
        labels: {!! json_encode(['Menores de 18 años', '18-29 años', '30-39 años', '40-49 años', '50+ años']) !!}, // Rango de edades en orden
        datasets: [{
            label: 'Distribución por edad de los alumnos',
            data: {!! json_encode([ 
                $edadAlumnos['Menores de 18 años'] ?? 0, 
                $edadAlumnos['18-29 años'] ?? 0, 
                $edadAlumnos['30-39 años'] ?? 0, 
                $edadAlumnos['40-49 años'] ?? 0, 
                $edadAlumnos['50+ años'] ?? 0 
            ]) !!}, // Conteo de alumnos por edad
            backgroundColor: ['#5600A8', '#FF4716', '#F95E9C', '#FF9F40', '#17A2B8'], // Colores para cada grupo de edad
            hoverOffset: 4
        }]
    };

    const configEdadAlumnos = {
        type: 'bar',
        data: dataEdadAlumnos,
        options: {
            indexAxis: 'x',
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' alumnos';
                        }
                    }
                }
            }
        }
    };

    new Chart(document.getElementById('chartEdadAlumnos'), configEdadAlumnos);
</script>
@endpush

