@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('personas.index',['from' => 'usuarios'])" :titulo="'Agregar nuevo usuario'" :boton="false" :urlBoton="route('home.index')" :textoBoton="'Agregar nuevo alumno'"/>

<div class="col-lg-12">

    <div class="card text-dark border-dark d-flex h-100">
        <div class="card-header bg-dark text-white">
            <b>Datos del usuario</b>
        </div>
        <div class="card-body">
            <form action="@if($persona->rut==null){{route('usuarios.store')}}@else {{route('usuarios.store-existente')}}@endif" method="POST">
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
                                <input class="form-check-input" type="checkbox" value="1" id="extranjero" name="extranjero">
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
                        <input type="tel" class="form-control" id="fono" name="fono" value="{{$persona->fono}}" readonly>
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
                    <div class="col-lg-4">
                        @if ($persona->rut !== null)
                        <input type="hidden" name="genero" value="{{$persona->genero}}">
                        @endif
                        <div class="row">
                            <label for="genero" class="form-label">Género</label>
                            <div class="col-lg-4">
                                <input type="radio" id="generoF" name="genero" value="F" class="form-check-input"  @if($persona->rut !== null){{ $persona->genero == 'F' ? 'checked' : '' }} disabled @endif>
                                <label class="form-check-label" for="generoF">Femenino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoM" name="genero" value="M" class="form-check-input" @if($persona->rut !== null){{ $persona->genero == 'M' ? 'checked' : '' }} disabled @endif>
                                <label class="form-check-label" for="generoM">Masculino</label>
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" id="generoO" name="genero" value="O" class="form-check-input" @if($persona->rut !== null){{ $persona->genero == 'O' ? 'checked' : '' }} disabled @endif>
                                <label class="form-check-label" for="generoO">Otro</label>
                            </div>
                        </div>
                        @error('genero')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="nivel_acceso" class="form-label text-dark">Nivel de Acceso</label>
                        <select class="form-select @error('nivel_acceso') is-invalid @enderror" aria-label="Nivel de Acceso" id="nivel_acceso" name="nivel_acceso">
                            <option  value="0">Seleccionar</option>
                            @foreach ($roles as $rol)
                            <option value="{{$rol->nivel_acceso}}">{{$rol->nombre}}</option>
                            @endforeach
                        </select>
                        @error('nivel_acceso')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="password" class="form-label text-dark">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{old('password')}}">
                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        <div class="card-footer d-flex justify-content-end">
            <a href= "{{ route('personas.index',['from' => 'usuarios']) }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
            <button type="submit" class="text-white btn btn-success">Agregar</button>
        </div>
        </form>
    </div>
</div>
@endsection