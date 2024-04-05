@extends('appExterna')
@section('main')
    {{-- <body class="antialiased"> --}}
    <div class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Recuperar cuenta</h3>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('reset.custom') }}">
                    @csrf
                    <div class="form-group input-group input-group-lg">
                        <label for="password">Correo electrónico</label>
                        <input type="text" id="email" class="form-control" placeholder="Email" aria-describedby="sizing-addon1" name="email" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-block btn-success">Enviar</button>
                    <br>
                    <p class="text-center"><a href="{{url('/')}}">Regresar</a></p>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
