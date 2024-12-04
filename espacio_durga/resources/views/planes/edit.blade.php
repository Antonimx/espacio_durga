@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('planes.index')" :titulo="'Editar plan '.$plan->nombre" :boton="false" :urlBoton="route('home.index')" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">

    <div class="card text-dark border-dark d-flex h-100">
        <div class="card-header bg-dark text-white">
            <b>Datos del plan mensual</b>
        </div>
        <div class="card-body">
            <form action="{{route('planes.update',$plan->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{$plan->nombre}}">
                    @error('nombre')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{$plan->valor}}">
                    @error('valor')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div> --}}

            </div>
        <div class="card-footer d-flex justify-content-end">
            <a href= "{{ route('planes.index') }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
            <button type="submit" class="text-white btn btn-success">Agregar</button>
        </div>
        </form>
    </div>
</div>
@endsection


