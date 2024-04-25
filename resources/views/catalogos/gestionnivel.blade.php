@extends('appExterna')
@section('main')
<main>
    <fieldset>
        <legend>Gestión de catálogo de nivel jerárquico</legend>
        <a href="{{ route('registro.nivel') }}" class="btn btn-primary">Agregar nivel jerárquico</a>
        <br><br>
        <table id="activas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Nivel</th>
                    <th>Modificar</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($niveles as $nivel)
                <tr>
                    <td>{{$nivel['nivel']}}</td>
                    <td><a href="{{ route('modificar.nivel',$nivel['id']) }}">Modificar</a></td>
                    <td>{{!empty($nivel['activo'])?'Activo':'Inactivo'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
</main>
@endsection