@extends('appExterna')
@section('main')
<main>
    <fieldset>
        <legend>Gestión de usuarios</legend>
        <a href="{{ route('register-user') }}" class="btn btn-primary">Agregar usuario</a>
        <br><br>
        <table id="activas" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    {{-- <th>Rol</th> --}}
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($users as $user)
                <tr>
                    <td>{{$user['name']}}</td>
                    <td><a href="{{ route('user.options',['id'=>$user['id']]) }}">{{$user['email']}}</a></td>
                    {{-- <td>{{$user['tipo']}}</td> --}}
                    <td>{!! $user['activo']==1?'<span class="bi bi-check-circle-fill" style="color: green;" aria-hidden="true"></span>':'<span class="bi bi-x-circle-fill" style="color: red;" aria-hidden="true"></span>' !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
</main>
@endsection