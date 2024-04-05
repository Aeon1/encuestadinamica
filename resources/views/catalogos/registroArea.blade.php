@extends('appExterna')
@section('main')
    <main class="signup-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <h3 class="card-header text-center">Agregar área</h3>
                        <div class="card-body">
                            <form action="{{ route('catalogo.area.saveUpdate') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Nombre" id="name" class="form-control" name="name"
                                        required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Guardar</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection