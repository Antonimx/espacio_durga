@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('personas.index',['from' => 'alumnos'])" :titulo="'Agregar nuevo alumno'" :boton="false" :urlBoton="route('home.index')" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">

    <div class="card text-dark border-dark d-flex h-100">
        <div class="card-header bg-dark text-white">
            <b>Datos del alumno y plan a contratar</b>
        </div>
        <div class="card-body">
            <form action="@if($persona->rut == null){{route('alumnos.store')}}@else {{route('alumnos.store-persona-existente')}}@endif" method="POST">
                @csrf
                {{-- DATOS ALUMNO --}}
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-1">
                                <label for="rut" class="form-label text-dark">Rut</label> 
                            </div>
                            @if($persona->rut == null) 
                            <div class="col-lg-11"> 
                                <input class="form-check-input" type="checkbox" value="" id="extranjero" name="extranjero">
                                <label class="form-check-label ms-1 mt-1" style="font-size: 0.75rem; color: gray;" for="extranjero">
                                    Extranjero
                                </label>
                            </div>
                            @endif
                            <div class="col-lg-12">
                                @if($persona->rut !== null)
                                <input type="text" class="form-control" id="rut" name="rut" value="{{$persona->rut}}" readonly>
                                @else
                                <input type="text" class="form-control  @error('rut') is-invalid @enderror" id="rut" name="rut" value="{{old('rut')}}">
                                @endif
                                <small class="form-text text-muted">Sin puntos con guión</small>
                                @error('rut')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="nombre" class="form-label text-dark">Nombre</label>
                        @if($persona->rut !== null)
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$persona->nombre}}" readonly>
                        @else
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{old('nombre')}}">
                        @endif
                        @error('nombre')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="apellido" class="form-label text-dark">Apellido</label>
                        @if($persona->rut !== null)
                        <input type="text" class="form-control" id="apellido" name="apellido" value="{{$persona->apellido}}" readonly>
                        @else
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{old('apellido')}}" >
                        @endif
                        @error('apellido')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="fecha_nac" class="form-label text-dark">Fecha de nacimiento</label>
                        @if($persona->rut !== null)
                        <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="{{$persona->fecha_nac}}" readonly>
                        @else
                        <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror" id="fecha_nac" name="fecha_nac" value="{{old('fecha_nac')}}">
                        @endif
                        @error('fecha_nac')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="direccion" class="form-label text-dark">Dirección</label>
                        @if($persona->rut !== null)
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{$persona->direccion}}" readonly>
                        @else
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{old('direccion')}}">
                        @endif
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="fono" class="form-label text-dark">Número de contacto</label>
                        @if($persona->rut !== null)
                        <input type="tel" class="form-control" id="fono" name="fono" value="{{$persona->fono}}">
                        @else
                        <input type="tel" class="form-control @error('fono') is-invalid @enderror" id="fono" name="fono" value="{{old('fono')}}">
                        @endif
                        @error('fono')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <label for="observaciones" class="form-label text-dark">Observaciones</label>
                        <textarea rows="2" class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" maxlength="200" name="observaciones">{{old('observaciones')}}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <label for="plan_mensual_id" class="form-label text-dark">Plan Mensual</label>
                        <select class="form-select @error('plan_mensual_id') is-invalid @enderror" aria-label="Plan Mensual" id="plan_mensual_id" name="plan_mensual_id">
                            <option  value="0">Seleccionar</option>
                            @foreach ($planes as $plan)
                            <option value="{{$plan->id}}">{{$plan->nombre}}</option>
                            @endforeach
                        </select>
                        @error('plan_mensual_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        <div class="card-footer d-flex justify-content-end">
            <a href= "{{ route('personas.index',['from' => 'alumnos']) }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
            <button type="submit" class="text-white btn btn-success">Agregar</button>
        </div>
        </form>
    </div>
</div>
@endsection