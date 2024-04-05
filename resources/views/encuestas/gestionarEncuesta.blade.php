@extends('appExterna')
@section('main')
<main>
    <fieldset>
        <legend>Gestión de encuestas</legend>
        <a href="{{ route('registro.encuesta') }}" class="btn btn-primary">Agregar Encuesta</a>
        <br><br>
        <table id="activas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Encuesta</th>
                    <th>URL</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>                
                @foreach ($encuestas as $encuesta)
                <tr>
                    <td><a href="{{ route('encuesta.gestion',$encuesta['id']) }}" title="Gestionar encuesta">{{$encuesta['nombre']}}</a></td>
                    <td>
                        @if ($encuesta['publicada'] == true)
                        <a target="_blank" href="{{!empty(getenv('PROXY_URL'))?getenv('PROXY_URL'):''}}/{{$encuesta['contexto']}}">https://dgesui.ses.sep.gob.mx/pruebaencuestas/{{$encuesta['contexto']}}</a></td>
                        @endif
                        
                    <td>{{$encuesta['estatus']==0?'Inactiva':'Activa'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
</main>
@endsection