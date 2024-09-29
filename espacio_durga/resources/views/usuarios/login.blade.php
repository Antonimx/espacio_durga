<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Solicitudes</title>
    <link href="{{ asset('css/custom-bs.min.css') }}" rel="stylesheet">
    <style>
        .card-body {
            position: relative;
        }
        .corner-img {
            position: absolute;
            top: 0;
            right: 0;
            width: 64px;
            height: 64px;
            margin: 5px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center">
        <div class="row w-100">
            <div class="offset-1 col-10 offset-md-3 col-md-6 d-flex justify-content-center">
                <div class="card w-100 border-primary text-dark">
                    <div class="card-body">
                        <img src="{{ Storage::url('images/logo_durga.ico') }}" alt="Logo" class="corner-img"> <!-- Imagen en la esquina -->
                        <h5 class="card-title mb-4">Iniciar Sesión</h5>
                        <form method="POST" action="{{ route('usuarios.autenticar') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="rut">Rut</label>
                                <input type="text" class="form-control" id="rut" name="rut" value="{{ old('rut') }}">
                                <small class="form-text text-muted">Sin puntos con guión</small>
                            </div>
                            <div class="mb-3">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3 d-grid gap-2 d-md-block text-end">
                                <button type="submit" class="btn btn-primary text-white">Iniciar Sesión</button>
                            </div>
                        </form>


                        @if($errors->any())
                        <div class="alert alert-warning py-1">
                            {{ $errors->all()[0] }}
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
