@extends('appExterna')
@section('main')
<main>
    <fieldset>
        <legend>Gestionar encuesta: {{ $encuesta['nombre'] }} ({{ !empty($encuesta['estatus'])?'Activa':'Inactiva' }})</legend>
        @if ($encuesta['institucional'])
            <span class="badge badge-pill badge-success">Institucional</span>
        @endif
        {{-- <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Nombre de la encuesta</label>
                    <input type="text" class="form-control" value="{{ $encuesta['nombre'] }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Contexto de la encuesta</label>
                    <input type="text" class="form-control" value="{{ $encuesta['contexto'] }}" disabled>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a class="btn btn-lg btn-primary" href="{{ route('encuesta.modificar',$encuesta['id']) }}">Modificar</a>
        </div>
        <hr>  --}}
        <div class="table-responsive-md">
            <table class="table  table-striped table-hover">
                <thead class="bg-info">
                    <tr>
                        <th>Sección</th>
                        <th>Acción</th>
                    </tr>                
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h6>Encuesta</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.modificar',$encuesta['id']) }}">Modificar nombre/contexto</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Página de inicio</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.inicio',$encuesta['id']) }}">Ver/Modificar página de inicio</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Instrucciones (Opcional)</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.instrucciones',$encuesta['id']) }}">Ver/Modificar instrucciones</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Datos de registro</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.registro',$encuesta['id']) }}">Ver/Modificar registro</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Preguntas</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.preguntas',$encuesta['id']) }}">Ver/Modificar preguntas</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Página de fin</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.fin',$encuesta['id']) }}">Ver/Modificar página de fin</a> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Encuesta cerrada</h6>
                        </td>
                        <td>
                            <a class="btn btn-link" href="{{ route('encuesta.Cerrada',$encuesta['id']) }}">Ver/Modificar encuesta cerrada</a>
                        </td>
                    </tr>
                </tbody>
            </table>  
        </div>     
    </fieldset>
    <fieldset>
        <legend>Probar y/o publicar</legend>
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('encuesta.pruebas.contexto',$encuesta['contexto']) }}" class="btn btn-primary btn-block btn-lg" target="_blank" rel="noopener noreferrer">Probar</a>
            </div>
            <div class="col-md-6">
                {{-- <a href="http://" class="btn btn-success btn-block btn-lg" target="_blank" rel="noopener noreferrer">Publicar</a> --}}
                <button type="button" class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#publicacion" title="Publicar encuesta">Publicar</button>
            </div>
        </div>
    </fieldset>
    <div class="modal fade" id="publicacion" tabindex="-1" role="dialog" aria-labelledby="publicacionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="publicacionLabel">Publicar encuesta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="formpublicacion" action="{{ route('encuesta.publicar') }}" method="POST">
                <h5>Realizar la publicación, generará una nueva tabla para las preguntas que haya agregado a la encuesta, por lo que si se modifica, tendra que ser publicada de nuevo y los datos contenidos seran borrados</h5>                
                <h5>¿Desea continuar?</h5>
                <input type="hidden" name="encuesta" value="{{ $encuesta['id'] }}" required>
                @csrf
                
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button form="formpublicacion" type="submit" class="btn btn-success">Publicar</button>
            </div>
          </div>
        </div>
      </div>
</main>
@endsection