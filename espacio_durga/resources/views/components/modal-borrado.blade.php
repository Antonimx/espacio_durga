<div class="modal fade" id="borrarModal{{$id}}" tabindex="-1" aria-labelledby="Modal{{$id}}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-dark text-bold" id="borrarModal{{$id}}Label">¿Desea borrar a {{$nombre}}?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route($url,$id)}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex justify-content-end "> 
              <button type="button" class="btn btn-dark text-white me-2" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger text-white">{{$textoBoton}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>