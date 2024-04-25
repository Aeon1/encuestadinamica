@extends('appExterna')
@section('main')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <h3 class="card-header text-center">Crear encuesta</h3>
                    <div class="card-body">
                        <form action="{{ route('encuesta.saveUpdate') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre de la encuesta</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Encuesta de control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contexto">Contexto de la encuesta</label>
                                        <input type="text" name="contexto" id="contexto" class="form-control" placeholder="Encuesta_de_control" required>
                                    </div>
                                </div>                
                            </div>
                            <div class="form-group mb-3">
                                <label>
                                    <input type="checkbox" name="institucional" value="1"> Institucional
                                </label>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-lg">Crear encuesta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection