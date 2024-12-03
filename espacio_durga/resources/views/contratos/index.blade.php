@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('home.index')" :titulo="'Lista de planes contratados'" :boton="true" :urlBoton="route('contratos.create')" :textoBoton="'Crear nuevo contrato'"/>

<div class="row">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
                                <td class="small" style="color: {{ $contrato->inicio_mensualidad > \Carbon\Carbon::now() ? 'red' : 'inherit' }}">{{ $contrato->inicio_mensualidad_formateada }}</td>                                
                                <td class="small">{{ $contrato->fin_mensualidad_formateada }}</td>
                                <td class="small">{{ $contrato->n_clases_disponibles }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-danger btn-sm pb-0" data-bs-toggle="modal" data-bs-target="#borrarModal{{$contrato->id}}">
                                        <i class="material-icons text-white" style="font-size: 1.1em">clear</i>
                                      </a>  
                                    </td>
                                    <div class="modal fade" id="borrarModal{{$contrato->id}}" tabindex="-1" aria-labelledby="Modal{{$contrato->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h1 class="modal-title fs-5 text-dark text-bold" id="borrarModal{{$contrato->id}}Label">¿Desea finalizar el contrato?</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <form action="{{route('contratos.destroy',$contrato->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input" id="registros" name="registros">
                                                    <label class="form-check-label" for="registros">Marcar si NO desea que este contrato quede en los registros</label>
                                                </div>
                                                <div class="d-flex justify-content-end "> 
                                                  <button type="button" class="btn btn-dark text-white me-2" data-bs-dismiss="modal">Cancelar</button>
                                                  <button type="submit" class="btn btn-danger text-white">Finalizar Contrato</button>
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
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
                                <th>Fecha término</th>
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

