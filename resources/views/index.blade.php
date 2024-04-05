@extends('appLogin')
@section('main')
    <div class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Encuestas dinamicas</h3>
            </div>
            <div class="panel-body">
                <h3 class="text-center">Iniciar sesión</h3>
                <form method="POST" action="{{ route('login.custom') }}">
                    @csrf
                    <div class="form-group input-group-lg">
                        <label for="email">Nombre de usuario</label>
                        <input type="text" id="email" class="form-control" placeholder="Email" aria-describedby="sizing-addon1" name="email" required autofocus value='administrador@encuestas.com'>
                    </div>
                    <div class="form-group input-group-lg">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" class="form-control" placeholder="Contraseña" aria-describedby="sizing-addon1" name="password" required value="password">
                    </div>
                    <a href="{{ route('reset') }}">¿Olvidaste tu contraseña?</a>
                    <br><br>
                    <button type="submit" class="btn btn-success active btn-md btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
