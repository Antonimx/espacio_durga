@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('usuarios.index')" :titulo="'Administrar cuenta'" :boton="true" :urlBoton="route('usuarios.passwd',$usuario->rut)" :textoBoton="'Cambiar contraseña'"/>

<div class="col-lg-12">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card text-dark border-dark">
        <div class="card-header bg-dark text-white">
            <b>Mis datos</b>
        </div>
        <div class="card-body">
            <form action="{{route('usuarios.administrar-cuenta',$usuario->rut)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-lg-4">
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
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="text-white btn btn-success">Confirmar cambios</button>
            </div>
        </div>
    </form>
</div>

@endsection
