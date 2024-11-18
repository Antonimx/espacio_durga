@extends('templates.master')

@section('contenido-pagina')

<div class="row mb-3">
    <div class="col-lg-6 mb-3">
        <div class="card text-dark border-dark d-flex h-100">
            <div class="card-header bg-dark text-white">
                <b>Cantidad de Planes Contratados Activos</b>
            </div>
            <div class="card-body">
                <canvas id="barChart"></canvas>
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
    
    {{-- ASISTENCIAS MENSUALES --}}
    <div class="col-lg-6">
        <div class="card text-dark border-dark d-flex h-100">
            <div class="card-header bg-dark text-white">
                <b>Asistencias Mensuales</b>
            </div>
            <div class="card-body">
                <canvas id="lineChart"></canvas>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{route('asistencia.gestionar')}}" class="btn btn-info btn-sm pb-0 me-1" data-bs-toggle="tooltip" title="Ver historial de asistencias">
                    <i class="material-icons text-white" style="font-size: 1.1em">search</i>
                </a>
            </div>
        </div>
    </div>

</div>
{{-- CANTIDAD DE PLANES CONTRATADOS ACTIVOS --}}

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- BAR CHART | CANTIDAD DE PLANES CONTRATADOS ACTIVOS --}}
<script>
    const ctxBar = document.getElementById('barChart').getContext('2d');

    // Preparar las etiquetas (solo los nombres de los planes)
    const labelsBar = [
        @foreach ($contratos as $contrato)
            "{{ $contrato->planMensual->nombre }}",
        @endforeach
    ];

    // Contar la cantidad de contratos por cada plan
    const planCounts = {};
    labelsBar.forEach(plan => {
        planCounts[plan] = (planCounts[plan] || 0) + 1;
    });

    const dataBar = {
        labels: Object.keys(planCounts), // Nombres de los planes
        datasets: [{
            label: 'Cantidad de Planes Contratados Activos',
            data: Object.values(planCounts), // Cantidad de planes por tipo
            backgroundColor: ['#FF4716', '#F95E9C', '#17A2B8', '#5600A8'], // Color de las barras
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
                        stepSize: 1,  // Hacer que los ticks sean enteros
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

    // Crear el gráfico de barras
    const barChart = new Chart(ctxBar, configBar);
</script>

{{-- LINE CHART | ASISTENCIAS MENSUALES --}}
<script>
    const ctxLine = document.getElementById('lineChart').getContext('2d');

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
    const lineChart = new Chart(ctxLine, configLine);
</script>

@endsection
