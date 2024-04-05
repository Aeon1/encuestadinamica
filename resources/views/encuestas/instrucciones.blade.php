@extends('appExterna')
@section('main')
    <main>
        <fieldset>
            <legend>Pagina de instrucciones <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$encuesta['encuesta']['id']) }}">Regresar</a></legend>
            <form action="{{ route('encuesta.instrucciones.saveUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="encuesta" id="encuesta" value="{{$encuesta['encuesta']['id']}}">
                <textarea name="instrucciones" id="instrucciones" cols="30" rows="20">{{ $encuesta['pagina']['instrucciones'] }}</textarea>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-lg btn-success btn-block">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-lg btn-info btn-block"  data-toggle="modal" data-target="#instruccionModal">Vista previa</button>
                    </div>
                </div>
            </form>
        </fieldset>
        <!-- modal de instrucciones -->
        <div class="modal fade" id="instruccionModal" role="dialog" aria-labelledby="instruccionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="instruccionModalLabel">Instrucciones para responder la encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
    </main>
@endsection