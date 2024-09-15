@extends('templates.master')

@section('contenido-pagina')

<div class="row d-flex justify-content-center">

    
    <x-cards-inicio :tituloCard="'Alumnos'" :descripcion="'Página para gestionar a todos los alumnos de Espacio Durga y además ver sus respectivos planes contratados y asistencia.'"  :url="'alumnos.index'"  :textoBoton="'Ir a alumnos'"/>
    <x-cards-inicio :tituloCard="'Tomar Asistencia'" :descripcion="'Página para tomar asistencia'"  :url="'asistencia.index'"  :textoBoton="'Ir a tomar asistencia'"/>
    <x-cards-inicio :tituloCard="'Contratos Planes'" :descripcion="'Página para ver todos los planes contratados y contratar uno nuevo'"  :url="'contratos.index'"  :textoBoton="'Ir a contratos'"/>
    <x-cards-inicio :tituloCard="'Planes Mensuales'" :descripcion="'Página para gestionar los planes disponibles en Espacio Durga'"  :url="'planes.index'"  :textoBoton="'Ir a planes'"/>


</div>
@endsection
