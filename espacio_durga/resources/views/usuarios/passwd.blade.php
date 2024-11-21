@extends('templates.master')

@section('contenido-pagina')

<x-titulo-gestion :urlVolver="route('usuarios.show',$usuario->rut)" :titulo="'Cambiar contraseña'" :boton="false" :urlBoton="route('usuarios.passwd',$usuario->rut)" :textoBoton="'Cambiar contraseña'"/>

<div class="col-lg-12">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card text-dark border-dark">
        <div class="card-header bg-dark text-white">
            <b></b>
        </div>
        <div class="card-body">
            <form action="{{route('usuarios.change-passwd',$usuario->rut)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <input type="hidden" name="rut" value="{{$usuario->rut}}">
                    <div class="col-lg-12 mb-3">
                        <label for="current_password" class="form-label text-dark">Contraseña actual</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                        @error('current_password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror 
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label for="new_password" class="form-label text-dark">Contraseña nueva</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                        @error('new_password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror 
                    </div>
                    <div class="col-lg-12">
                        <label for="new_password_confirmation" class="form-label text-dark">Confirme contraseña nueva</label>
                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation">
                        @error('new_password_confirmation')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror 
                    </div>
                    
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href= "{{ route('usuarios.show', $usuario->rut) }}" type="button" class="text-white btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="text-white btn btn-success">Confirmar cambios</button>
            </div>
        </div>
    </form>
</div>

@endsection

