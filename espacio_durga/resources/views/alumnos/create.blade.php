@extends('templates.master')

@section('contenido-pagina')
<x-titulo-gestion :urlVolver="route('alumnos.index')" 
:titulo="'Agregar nuevo alumno'"  
:boton="false"
:urlBoton="''" 
:textoBoton="'Editar datos del alumno'"/>

@endsection
