@extends('appExterna')
@section('main')
    <main>
        <fieldset>
            <legend>Pagina de cierre <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$encuesta['encuesta']['id']) }}">Regresar</a></legend>
            <form action="{{ route('encuesta.cerrada.saveUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="encuesta" id="encuesta" value="{{$encuesta['encuesta']['id']}}">
                {{-- <input type="hidden" name="contexto" id="contexto" value="{{$encuesta['encuesta']['contexto']}}"> --}}
                <h4>Programar o cerrar encuesta</h4>
                <hr>
                {{date("Y-m-d H:i:s")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_inicio">Inciar encuesta</label>
                            <input type="datetime-local" name="inicio" id="fecha_inicio" value="{{ !empty($encuesta['config']['fecha_inicio'])?$encuesta['config']['fecha_inicio']:'' }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_fin">Cerrar encuesta</label>
                            <input type="datetime-local" name="fin" id="fecha_fin" value="{{ !empty($encuesta['config']['fecha_fin'])?$encuesta['config']['fecha_fin']:'' }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <textarea name="cerrada" id="cerrada" cols="30" rows="20">{{ $encuesta['pagina']['cerrada'] }}</textarea>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-lg btn-success btn-block">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('encuesta.cerrada.vista.previa',$encuesta['encuesta']['id']) }}" class="btn btn-lg btn-info btn-block" target="blank">Vista previa</a>
                    </div>
                </div>
            </form>
        </fieldset>
    </main>
@endsection