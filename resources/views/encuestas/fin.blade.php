@extends('appExterna')
@section('main')
    <main>
        <fieldset>
            <legend>Pagina de finalización <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$encuesta['encuesta']['id']) }}">Regresar</a></legend>
            <form action="{{ route('encuesta.fin.saveUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="encuesta" id="encuesta" value="{{$encuesta['encuesta']['id']}}">
                <textarea name="fin" id="fin" cols="30" rows="20">{{ $encuesta['pagina']['fin'] }}</textarea>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-lg btn-success btn-block">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('encuesta.fin.vista.previa',$encuesta['encuesta']['id']) }}" class="btn btn-lg btn-info btn-block" target="blank">Vista previa</a>
                    </div>
                </div>
            </form>
        </fieldset>
    </main>
@endsection