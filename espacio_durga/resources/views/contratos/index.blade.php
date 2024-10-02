@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('home.index')" :titulo="'Lista de planes contratados'" :boton="true" :urlBoton="route('contratos.create')" :textoBoton="'Crear nuevo contrato'"/>

<div class="row">
    {{-- TABLA DE CONTRATOS VIGENTES --}}
    <div class="col-12 mb-3">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white" style="font-weight: bold;">
                <h5 class="m-0">Contratos activos: {{count($contratosVigentes)}}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 300px;"">
                    <table class="table table-stripped table-bordered table-hover">
                        <thead class="table-light text-white">
                            <tr>

                                <th>Nº</th>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                
                                <th>Tipo de plan</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>N° de clases disponibles</th>
                                <th>Finalizar contrato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratosVigentes as $i => $contrato)
                            <tr>
                                <td class="small text-center">{{ $i+1 }}</td>
                                <td class="small">{{ $contrato->rut_alumno }}</td>
                                <td class="small">{{ $contrato->alumno->persona->nombre }}</td>
                                <td class="small">{{ $contrato->alumno->persona->apellido }}</td>
                                <td class="small">{{ $contrato->planMensual->nombre }}</td>
                                <td class="small">{{ $contrato->inicio_mensualidad_formateada }}</td>
                                <td class="small">{{ $contrato->fin_mensualidad_formateada }}</td>
                                <td class="small">{{ $contrato->n_clases_disponibles }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-danger btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#borrarModal{{$contrato->id}}">
                                        <i class="material-icons text-white" style="font-size: 1.1em">clear</i>
                                      </a>  
                                    </td>
                                <x-modal-borrado 
                                :url="'contratos.destroy'"
                                :id="$contrato->id" 
                                :textoTitulo="'¿Desea finalizar contrato?'"
                                :textoBoton="'Finalizar contrato'" 
                                />
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- /TABLA DE CONTRATOS VIGENTES --}}

    {{-- TABLA DE CONTRATOS FINALIZADOS --}}
    <div class="col-12 mb-3">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white" style="font-weight: bold;">
                <h5 class="m-0">Contratos finalizados: {{count($contratosFinalizados)}}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 300px;"">
                    <table class="table table-stripped table-bordered table-hover">
                        <thead class="table-light text-white">
                            <tr>

                                <th>Nº</th>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                
                                <th>Tipo de plan</th>
                                <th>Fecha inicio</th>
                                <th>Fecha vencimiento</th>
                                <th>Clases asistidas</th>
                                <th>Fecha termino</th>
                                <th>Razón término de contrato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratosFinalizados as $i => $contrato)
                            <tr>
                                <td class="small text-center">{{ $i+1 }}</td>
                                <td class="small">{{ $contrato->rut_alumno }}</td>
                                <td class="small">{{ $contrato->alumno->persona->nombre }}</td>
                                <td class="small">{{ $contrato->alumno->persona->apellido }}</td>
                                <td class="small">{{ $contrato->planMensual->nombre }}</td>
                                <td class="small">{{ $contrato->inicio_mensualidad_formateada }}</td>
                                <td class="small">{{ $contrato->fin_mensualidad_formateada }}</td>
                                <td class="small">{{ $contrato->clases_asistidas}}</td>
                                <td class="small fw-bold">{{ $contrato->fecha_termino_contrato_formateada }}</td>
                                <td class="small fw-bold">{{ $contrato->razon_termino }}</td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

