@extends('appExterna')
@section('main')
<fieldset>
    <legend>Encuestas activas</legend>
    <table id="activas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($e as $encuesta)
                <tr>
                    <td>
                        <a href="{{ route('dashboard.resultados',$encuesta['hash']) }}" class="btn btn-link" title="Ver resultados">{{$encuesta['nombre']}}</a>                        
                    </td>
                    <td>
                        <a href="https://dgesui.ses.sep.gob.mx/pruebaencuestas/{{$encuesta['contexto']}}" class="btn btn-link" title="Ir a encuesta">https://dgesui.ses.sep.gob.mx/pruebaencuestas/{{$encuesta['contexto']}}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</fieldset>
<fieldset>
    <legend>Encuestas finalizadas</legend>
    <table id="finalizadas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($f as $encuesta)
                <tr>
                    <td>
                        <a href="{{ route('dashboard.resultados',$encuesta['hash']) }}" class="btn btn-link" title="Ver resultados">{{$encuesta['nombre']}}</a>                        
                    </td>
                    <td>
                        <a href="https://dgesui.ses.sep.gob.mx/pruebaencuestas/{{$encuesta['contexto']}}" class="btn btn-link" title="Ir a encuesta">https://dgesui.ses.sep.gob.mx/pruebaencuestas/{{$encuesta['contexto']}}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</fieldset>
@endsection