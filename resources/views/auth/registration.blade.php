@extends('appExterna')

@section('main')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <h3 class="card-header text-center">Registro de nuevo usuario</h3>
                    <div class="card-body">

                        <form action="{{ route('register.custom') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Nombre" id="name" class="form-control" name="name"
                                    required autofocus value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email_address" class="form-control"
                                    name="email" required autofocus value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Contraseña" id="password" class="form-control"
                                    name="password" required value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            {{-- <div class="form-group mb-3">
                                <select name="rol" id="rol" class="form-control">
                                    @foreach ($roles as $rol)
                                        <option value="{{$rol['id']}}">{{ $rol['tipo'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rol'))
                                <span class="text-danger">{{ $errors->first('rol') }}</span>
                                @endif
                            </div> --}}
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Registrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection