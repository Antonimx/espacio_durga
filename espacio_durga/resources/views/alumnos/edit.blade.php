@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('alumnos.show', $alumno->rut)" :titulo="'Editar datos de ' . $alumno->persona->nombre . ' ' . $alumno->persona->apellido" :boton="false" :urlBoton="'route(alumnos.create)'" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">
    <div class="card text-dark border-dark">
        <div class="card-header bg-dark text-white">
            <b>Datos del alumno</b>
        </div>
        <div class="card-body">
            <form action="{{route('alumnos.update',$alumno->rut)}}" method='post'>
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="rut" class="form-label text-dark">Rut</label>
                        <input type="text" class="form-control" id="rut" name="rut" value="{{$alumno->rut}}" readonly>
                    </div>
                    <div class="col-lg-4">
                        <label for="nombre" class="form-label text-dark">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$alumno->persona->nombre}}" >
                    </div>
                    <div class="col-lg-4">
                        <label for="apellido" class="form-label text-dark">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="{{$alumno->persona->apellido}}" >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="gecha_nac" class="form-label text-dark">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nac" name="fecha_nac"  class="form-control" value="{{$alumno->persona->fecha_nac}}" >
                    </div>
                    <div class="col-lg-4">
                        <label for="direccion" class="form-label text-dark">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{$alumno->persona->direccion}}" >
                    </div>
                    <div class="col-lg-4">
                        <label for="fono" class="form-label text-dark">Número de contacto</label>
                        <input type="text" class="form-control" id="fono" name="fono" value="{{$alumno->persona->fono}}" >
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="observaciones" class="form-label text-dark">Observaciones</label>
                        <textarea rows="2" class="form-control" id="observaciones" maxlength="300" name="observaciones">{{$alumno->observaciones}}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href= "{{ route('alumnos.show', $alumno->rut) }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="text-white btn btn-success">Confirmar cambios</button>
            </div>
        </div>
    </form>
</div>

@endsection
