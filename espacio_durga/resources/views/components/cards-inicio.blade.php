<div class="col-lg-3 mb-3 d-flex justify-content-center">
    <div class="card text-dark border-dark" style="width: 18rem;">
        <div class="card-header bg-dark text-white">
            <b>{{$tituloCard}}</b>
        </div>
        <div class="card-body">
            <p class="card-text">{{$descripcion}}</p>
        </div>
        <div class="card-footer">
            <a href="{{route($url)}}" class="btn btn-primary text-white w-100">{{$textoBoton}}</a>
        </div>
    </div>
</div>
  