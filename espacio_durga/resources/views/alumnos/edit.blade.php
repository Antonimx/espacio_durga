@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('alumnos.show', $alumno->rut)" :titulo="'Editar datos de ' . $alumno->persona->nombre . ' ' . $alumno->persona->apellido" :boton="false" :urlBoton="'route(alumnos.create)'" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">
    @if($errors->any())
    <div class="alert alert-danger">
        <p>Por favor solucione los siguientes problemas:</p>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card text-dark border-dark">
        <div class="card-header bg-dark text-white">
            <b>Datos del alumno</b>
        </div>
        <div class="card-body">
            <form action="{{route('alumnos.update',$alumno->rut)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="rut" class="form-label text-dark">Rut</label>
                        <input type="text" class="form-control" id="rut" name="rut" value="{{$alumno->rut}}" readonly>
                    </div>
                    <div class="col-lg-4">
                        <label for="nombre" class="form-label text-dark">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{$alumno->persona->nombre}}">
                        @error('nombre')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror                    
                    </div>
                    <div class="col-lg-4">
                        <label for="apellido" class="form-label text-dark">Apellido</label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ $alumno->persona->apellido }}" >
                        @error('apellido')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="gecha_nac" class="form-label text-dark">Fecha de nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror" id="fecha_nac" name="fecha_nac" value="{{$alumno->persona->fecha_nac}}">
                        @error('fecha_nac')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="direccion" class="form-label text-dark">Dirección</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$alumno->persona->direccion}}">
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="fono" class="form-label text-dark">Número de contacto</label>
                        <input type="tel" class="form-control @error('fono') is-invalid @enderror" id="fono" name="fono" value="{{$alumno->persona->fono}}">
                        @error('fono')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="row">
                            <label for="genero" class="form-label">Género</label>
                            <div class="col-lg-4">
                                <input type="radio" id="generoF" name="genero" value="F" class="form-check-input" {{ $alumno->persona->genero == 'F' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoF">Femenino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoM" name="genero" value="M" class="form-check-input" {{ $alumno->persona->genero == 'M' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoM">Masculino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoO" name="genero" value="O" class="form-check-input" {{ $alumno->persona->genero == 'O' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoO">Otro</label>
                            </div>
                        </div>
                        @error('genero')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-8">
                        <label for="observaciones" class="form-label text-dark">Observaciones</label>
                        <textarea rows="2" class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" maxlength="200" name="observaciones">{{$alumno->observaciones}}</textarea>
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
