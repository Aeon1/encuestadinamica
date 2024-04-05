@extends('appExterna')
@section('main')
<main>
    <fieldset>
        <legend>Gestión de catalogo de áreas</legend>
        <a href="{{ route('registro.area') }}" class="btn btn-primary">Agregar área</a>
        <br><br>
        <table id="activas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Modificar</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($areas as $area)
                <tr>
                    <td>{{$area['area']}}</td>
                    <td><a href="{{ route('modificar.area',$area['id']) }}">Modificar</a></td>
                    <td>{{!empty($area['activo'])?'Activo':'Inactivo'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
</main>
@endsection