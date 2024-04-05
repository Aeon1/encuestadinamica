@extends('appExterna')
@section('main')
    <main class="signup-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <h3 class="card-header text-center">Modificar encuesta <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$encuesta['id']) }}">Regresar</a></h3>
                        <div class="card-body">
                            <form action="{{ route('encuesta.saveUpdate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $encuesta['id'] }}">
                                <div class="form-group mb-3">
                                    <label for="numbre_encuesta">Nombre de la encuesta</label>
                                    <input type="text" placeholder="Encuesta" id="nombre" class="form-control" name="nombre"
                                        required autofocus value ='{{ $encuesta['nombre'] }}'>
                                    @if ($errors->has('nombre'))
                                    <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <label for="numbre_encuesta">Contexto de la encuesta</label>
                                    <input type="text" placeholder="Contexto" id="contexto" class="form-control" name="contexto"
                                        required autofocus value ='{{ $encuesta['contexto'] }}'>
                                    @if ($errors->has('contexto'))
                                    <span class="text-danger">{{ $errors->first('contexto') }}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>
                                                <input type="checkbox" name="estatus" value="1" {!! $encuesta['estatus']==true?'checked':'' !!}> Activo
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>
                                                <input type="checkbox" name="institucional" value="1" {!! $encuesta['institucional']==true?'checked':'' !!}> Institucional
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection