@extends('app')
@section('main')


@if (!empty(session('registro_usuarios')))
    <div class="alert alert-success" role="alert">
        {{session('registro_usuarios')}}
    </div>
@endif

@endsection