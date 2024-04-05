@extends('appExterna')
@section('main')
    <main class="signup-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <h3 class="card-header text-center">Modificar área</h3>
                        <div class="card-body">
                            <form action="{{ route('catalogo.area.saveUpdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $area['id'] }}">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Nombre" id="name" class="form-control" name="name"
                                        required autofocus value ='{{ $area['area'] }}'>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label>
                                        <input type="checkbox" name="activo" value="1" {{ !empty($area['activo'])?'checked':'' }}> Activo
                                    </label>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-block">Guardar</button>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <a class="btn btn-danger btn-block" href="{{ route('catalogo.area.delete',$area['id']) }}">Eliminar</a>
                                    </div> --}}
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection