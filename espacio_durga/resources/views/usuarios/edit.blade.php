@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('usuarios.index')" :titulo="'Editar datos de ' . $usuario->persona->nombre . ' ' . $usuario->persona->apellido" :boton="false" :urlBoton="'route(alumnos.create)'" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">
    <div class="card text-dark border-dark">
        <div class="card-header bg-dark text-white">
            <b>Datos del alumno</b>
        </div>
        <div class="card-body">
            <form action="{{route('usuarios.update',$usuario->rut)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <input type="hidden" name="rut" value="{{$usuario->rut}}">
                        <label for="rut" class="form-label text-dark">Rut</label>
                        <input type="text" class="form-control" id="rut" name="rut" value="{{$usuario->rut}}" disabled>
                    </div>
                    <div class="col-lg-4">
                        <label for="nombre" class="form-label text-dark">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{$usuario->persona->nombre}}">
                        @error('nombre')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror                    
                    </div>
                    <div class="col-lg-4">
                        <label for="apellido" class="form-label text-dark">Apellido</label>
                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ $usuario->persona->apellido }}" >
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
                        <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror" id="fecha_nac" name="fecha_nac" value="{{$usuario->persona->fecha_nac}}">
                        @error('fecha_nac')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="direccion" class="form-label text-dark">Dirección</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{$usuario->persona->direccion}}">
                        @error('direccion')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="fono" class="form-label text-dark">Número de contacto</label>
                        <input type="tel" class="form-control @error('fono') is-invalid @enderror" id="fono" name="fono" value="{{$usuario->persona->fono}}">
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
                                <input type="radio" id="generoF" name="genero" value="F" class="form-check-input" {{ $usuario->persona->genero == 'F' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoF">Femenino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoM" name="genero" value="M" class="form-check-input" {{ $usuario->persona->genero == 'M' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoM">Masculino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoO" name="genero" value="O" class="form-check-input" {{ $usuario->persona->genero == 'O' ? 'checked' : '' }}>
                                <label class="form-check-label" for="generoO">Otro</label>
                            </div>
                        </div>
                        @error('genero')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-8">
                        <label for="nivel" class="form-label text-dark">Nivel de acceso</label>
                        
                        @if(Auth::user()->rut == $usuario->rut)
                        <input type="hidden" name="nivel_acceso" value="{{$usuario->nivel_acceso}}">
                        <select class="form-select @error('nivel_acceso') is-invalid @enderror" aria-label="Nivel de Acceso" id="nivel_acceso" name="nivel_acceso" disabled>
                                <option value="{{ $usuario->nivel_acceso }}">{{ $usuario->rol->nombre }}</option>
                        </select>
                        @else
                        <select class="form-select @error('nivel_acceso') is-invalid @enderror" aria-label="Nivel de Acceso" id="nivel_acceso" name="nivel_acceso">
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->nivel_acceso }}"
                                    {{ old('nivel_acceso', $usuario->nivel_acceso ?? 0) == $rol->nivel_acceso ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @endif
                        @error('nivel_acceso')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href= "{{ route('alumnos.show', $usuario->rut) }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="text-white btn btn-success">Confirmar cambios</button>
            </div>
        </div>
    </form>
</div>

@endsection
