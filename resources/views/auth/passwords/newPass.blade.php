@extends('appLogin')
@section('main')
    {{-- <body class="antialiased"> --}}
    <div class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Cambiar contraseña</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('reset.new') }}">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{$usuario->id}}">
                    <div class="form-group input-group-lg">
                        <label for="password1">Contraseña nueva</label>
                        <input type="password" id="password1" class="form-control" aria-describedby="sizing-addon1" minlength="6" name="password1" required>
                        @if ($errors->has('password1'))
                        @endif
                    </div>
                    <div class="form-group input-group-lg">
                        <label for="password2">Repetir contraseña</label>
                        <input type="password" id="password2" class="form-control" aria-describedby="sizing-addon1" minlength="6" name="password2" required>
                        @if ($errors->has('password2'))
                        @endif
                    </div>
                    <br>
                    <button type="submit" class="btn btn-block btn-success">Enviar</button>
                    <br>
                    <p class="text-center"><a href="/">Regresar</a></p>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
