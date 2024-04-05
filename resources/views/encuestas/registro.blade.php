@extends('appExterna')
@section('main')
    <main>
        <fieldset>
            <legend>Formulario de registro <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$c['id']) }}">Regresar</a></legend>
            @foreach ($c['campos'] as $campo)
                <button type="button" class="badge badge-pill badge-secondary bntcmp" data-tipo="{{$campo['id']}}" data-campo="{{$campo['campo']}}" data-nombre="{{$campo['name']}}" title="Mantener presionado 3 segundos para eliminar" >{{$campo['texto']}}</button>
            @endforeach
            <button type="button" class="badge badge-pill badge-secondary" data-toggle="modal" data-target="#addCampoModal">Agregar otro</button>
            <hr>
            <div class="container" style="width: 700px">
                <form id="formTemplate">
                    @foreach ($c['registro'] as $campo)
                        @if ($campo->campo == 1)
                        <div class="form-group" registro="{{$campo->tipo}}*1">
                            <label for="{{$campo->name}}">{{$campo->texto}}</label>
                            <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                            <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                            <input type="text" class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                            </div>
                        @endif
                        @if ($campo->campo == 2)
                            <div class="form-group" registro="{{$campo->tipo}}*1">
                                <label for="{{$campo->name}}">{{$campo->texto}}</label>
                                <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                                <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                                <input type="number" class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                            </div>
                        @endif
                        @if ($campo->campo == 3)
                        <div class="form-group" registro="{{$campo->tipo}}*1">
                            <label for="{{$campo->name}}">{{$campo->texto}}</label>
                            <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                            <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                            <input type="email" class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                            </div>
                        @endif
                        @if ($campo->campo == 4)
                            {{-- <div class="form-group">
                            <label for="{{$campo['name']}}">{{$campo['texto']}}</label>
                            <input type="email" class="form-control" name="{{$campo['name']}}" id="{{$campo['name']}}">
                            </div> --}}
                        @endif
                        @if ($campo->campo == 5)
                        <div class="form-group" registro="{{$campo->tipo}}*1">
                            <label for="{{$campo->name}}">{{$campo->texto}}</label>
                            <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                            <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                            <textarea name="{{$campo->name}}" id="{{$campo->name}}" class="form-control" cols="30" rows="3" {{ !empty($campo->obligatorio)?'required':''}}></textarea>
                            </div>
                        @endif
                        @if ($campo->campo == 6)
                        <div class="form-group" registro="{{$campo->tipo}}*1">
                            <label for="{{$campo->name}}">{{$campo->texto}}</label>
                            <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                            <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                            <select class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                                <option>Seleccionar</option>
                                @foreach ($c['area'] as $area)
                                    <option value="{{$area['area']}}">{{$area['area']}}</option>
                                @endforeach
                            </select>
                            </div>
                        @endif
                        @if ($campo->campo == 7)
                        <div class="form-group" registro="{{$campo->tipo}}*1">
                            <label for="{{$campo->name}}">{{$campo->texto}}</label>
                            <button type="button" class="badge badge-pill badge-danger dltcmp">eliminar</button>
                            <div class="form-check form-check-inline m-1"><label class="tag form-check-label text-capitalize badge badge-info" for="{{$campo->name}}x"><input type="checkbox" class="form-check-input chko" id="{{$campo->name}}x" {{!empty($campo->obligatorio)?'checked':''}}>Obligatorio</label></div>
                            <select class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                            <option>Seleccionar</option>
                            @foreach ($c['nivel'] as $nivel)
                                    <option value="{{$nivel['nivel']}}">{{$nivel['nivel']}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    @endforeach
                </form>
                <hr>
                <form action="{{ route('encuesta.registro.template.saveUpdate') }}" method="POST" id="send-template-registro">
                    @csrf
                    <input type="hidden" name="encuesta" value="{{ $c['id'] }}">
                    <input type="hidden" name="template" id="template">
                    <button type="button" id="generarRegistro" class="btn btn-success btn-lg btn-block">Guardar formulario</button>
                </form>
            </div>            
        </fieldset>
    </main>
    <!-- Modal agregar campo-->
<div class="modal fade" id="addCampoModal" tabindex="-1" role="dialog" aria-labelledby="addCampoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCampoLabel">Nuevo campo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="newfield" action="{{ route('registro.agregar.campo') }}" method="POST">
            <input type="hidden" name="encuesta" value="{{$c['id']}}">
            <div class="form-group">
              <label for="texto">Texto del campo</label>
              <input type="text" class="form-control" name="texto" id="texto" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre del campo (sin espacios y en miniscula)</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="segundo_nombre" required>
            </div>
            <div class="form-group">
                <label for="campo">Tipo de campo</label>
                <select class="form-control" name="campo" id="campo" required>
                    <option value="1">Texto corto</option>
                    <option value="5">Texto largo</option>
                    <option value="2">Campo numerico</option>
                </select>
            </div>
            @csrf
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button form="newfield" type="submit" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </div>
  </div>
@endsection