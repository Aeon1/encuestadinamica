@extends('appExterna')
@section('main')
    <main class="signup-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <h3 class="card-header text-center">Cambiar datos de usuario</h3>
                        <div class="card-body">
                            <form action="{{ route('user.options.save') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user['datos']['id'] }}">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Nombre" id="name" class="form-control" name="name"
                                        required autofocus value="{{ $user['datos']['name'] }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" placeholder="Email" id="email_address" class="form-control"
                                        name="email" required autofocus value="{{ $user['datos']['email'] }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <select name="rol" id="rol" class="form-control">
                                        @foreach ($user['roles'] as $rol)
                                            <option value="{{$rol['id']}}" {!! $user['datos']['rol'] == $rol['id']?'selected':'' !!}>{{ $rol['tipo'] }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rol'))
                                    <span class="text-danger">{{ $errors->first('rol') }}</span>
                                    @endif
                                </div> --}}
                                <div class="form-group mb-3">
                                    <label>
                                        <input type="checkbox" name="estatus" value="1" {!! $user['datos']['activo']==true?'checked':'' !!}> Activo
                                    </label>
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Actualizar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection