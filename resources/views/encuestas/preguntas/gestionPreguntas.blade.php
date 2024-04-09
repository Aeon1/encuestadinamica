@extends('appExterna')
@section('main')
@php
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}
@endphp
<main>
  <input type="hidden" name="id_encuesta" id="id_encuesta" value="{{ $encuesta['encuesta']['id']}}">
  <fieldset>
    <legend>Preguntas encuesta <a class="btn btn-lg btn-info" href="{{ route('encuesta.gestion',$encuesta['encuesta']['id']) }}">Regresar</a></legend>
    <fieldset>
      <legend>Preguntas</legend>
      <button type="button" class="btn btn-info" id="addSection">Agregar sección</button>
      <ul class="nav nav-tabs" id="tabs" role="tablist">
        @if (!empty($encuesta['secciones']))
          @foreach ($encuesta['secciones'] as $seccion)                
            <li class="nav-item"><a href="#tab{{$seccion['seccion']}}" class="nav-link {!! $seccion['seccion']==count($encuesta['secciones'])?'active':'' !!}" role="tab" aria-selected="true" data-toggle="tab">Seccion {{$seccion['seccion']}}</a></li>
          @endforeach
        @endif
      </ul>
      <div class="tab-content">
        @if (!empty($encuesta['secciones']))
          @foreach ($encuesta['secciones'] as $seccion)
            <div class="tab-pane cpe {!! $seccion['seccion']==count($encuesta['secciones'])?'active':'' !!}" id="tab{{$seccion['seccion']}}">
              <br>
              <button type="button" class="btn btn-info modalx" data-toggle="modal" data-target="#addQuestion" data-seccion="{{$seccion['seccion']}}" onclick="openModelQuestion({{$seccion['seccion']}})">Agregar Pregunta</button>
              <hr>
              <button type="button" class="badge badge-pill badge-info modificarSeccion" data-texto="{{$seccion['texto']}}" data-seccion="{{$seccion['seccion']}}">Modificar título</button>
                <button type="button" class="badge badge-pill badge-danger eliminarSeccion" data-seccion="{{$seccion['seccion']}}" >Eliminar sección</button>
              <fieldset>
                
                <legend>{{$seccion['texto']}}</legend>
                <form action="">
                  @foreach ($encuesta['preguntas'] as $pregunta)
                    @if ($pregunta['seccion']== $seccion['seccion'])
                      @if ($pregunta['tipo'] == 1)
                        @if ($pregunta['asignacion'] == 0)
                          <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                            <select class="form-control" {!! !empty($pregunta['obligatorio'])?'required':'' !!}>
                              <option value="">Seleccionar</option>
                              @foreach ($encuesta['opciones'] as $opcion)
                                  @if ($pregunta['id'] == $opcion['pregunta'])
                                      <option value="">{{$opcion['opcion']}}</option>
                                  @endif
                              @endforeach
                            </select>
                          </div>
                        @else
                        <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{generate_string($permitted_chars, 15)}}">
                          <label for="">{{$pregunta['pregunta']}}</label><br>
                          <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                          <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                          <span>Áreas:</span>
                          @if ($pregunta['area'] == "0")
                              <span class="badge badge-pill badge-success">Todas la áreas</span>
                            @else
                            @php($ar = explode(',',$pregunta['area']))
                              @foreach ($encuesta['areas'] as $area)
                                @if (in_array($area['id'],$ar))
                                  <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                @endif                              
                              @endforeach
                            @endif
                            <span>Nivel jerárquico:</span>
                          @if ($pregunta['nivel'] == "0")
                              <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                            @else
                            @php($arn = explode(',',$pregunta['nivel']))
                              @foreach ($encuesta['nivel'] as $nivel)
                                @if (in_array($nivel['id'],$arn))
                                  <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                @endif                              
                              @endforeach
                            @endif
                          <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                          <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                          <select class="form-control" name="" id="" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!}>
                            <option value="">Seleccionar</option>
                            @foreach ($encuesta['opciones'] as $opcion)
                                @if ($pregunta['id'] == $opcion['pregunta'])
                                    <option value="">{{$opcion['opcion']}}</option>
                                @endif
                            @endforeach
                          </select>
                        </div>
                        @endif
                      @endif
                      @if ($pregunta['tipo'] == 2)
                        @if ($pregunta['asignacion'] == 0)
                          <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                            <input type="text" class="form-control" {!! !empty($pregunta['obligatorio'])?'required':'' !!}>
                          </div>
                        @else
                          <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{generate_string($permitted_chars, 15)}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                            <input type="text" class="form-control" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!}>
                          </div>
                        @endif
                      @endif
                      @if ($pregunta['tipo'] == 3)
                        @if ($pregunta['asignacion'] == 0)
                          <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatoria':''}}</span>
                            <textarea name="" id="" class="form-control" {!! !empty($pregunta['obligatorio'])?'required':'' !!}></textarea>
                          </div>
                        @else
                        <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" data id="{{generate_string($permitted_chars, 15)}}">
                          <label for="">{{$pregunta['pregunta']}}</label><br>
                          <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                          <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                          <span>Áreas:</span>
                          @if ($pregunta['area'] == "0")
                              <span class="badge badge-pill badge-success">Todas la áreas</span>
                            @else
                            @php($ar = explode(',',$pregunta['area']))
                              @foreach ($encuesta['areas'] as $area)
                                @if (in_array($area['id'],$ar))
                                  <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                @endif                              
                              @endforeach
                            @endif
                            <span>Nivel jerárquico:</span>
                          @if ($pregunta['nivel'] == "0")
                              <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                            @else
                            @php($arn = explode(',',$pregunta['nivel']))
                              @foreach ($encuesta['nivel'] as $nivel)
                                @if (in_array($nivel['id'],$arn))
                                  <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                @endif                              
                              @endforeach
                            @endif
                          <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                          <textarea name="" id="" class="form-control" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!}></textarea>
                        </div>
                        @endif
                      @endif
                      @if ($pregunta['tipo'] == 4)
                        @if ($pregunta['asignacion'] == 0)
                          <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                            <select class="form-control mostrar" name="" id="" {!! !empty($pregunta['obligatorio'])?'required':'' !!}>
                              <option value="">Seleccionar</option>
                              <option value="1">Si</option>
                              <option value="2">No</option>
                            </select>
                          </div>
                        @else
                          <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{generate_string($permitted_chars, 15)}}">
                            <label for="">{{$pregunta['pregunta']}}</label><br>
                            <button type="button" class="badge badge-pill badge-info" onclick="openModelQuestion({{$seccion['seccion']}},{{$pregunta['id']}})">Modificar</button>
                            <button type="button" class="badge badge-pill badge-danger dltqt" data-delete="{{$pregunta['id']}}">eliminar</button>
                            <span>Áreas:</span>
                            @if ($pregunta['area'] == "0")
                                <span class="badge badge-pill badge-success">Todas la áreas</span>
                              @else
                              @php($ar = explode(',',$pregunta['area']))
                                @foreach ($encuesta['areas'] as $area)
                                  @if (in_array($area['id'],$ar))
                                    <span class="badge badge-pill badge-success">{{$area['area']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                              <span>Nivel jerárquico:</span>
                            @if ($pregunta['nivel'] == "0")
                                <span class="badge badge-pill badge-success">Todos los niveles jerárquicos</span>
                              @else
                              @php($arn = explode(',',$pregunta['nivel']))
                                @foreach ($encuesta['nivel'] as $nivel)
                                  @if (in_array($nivel['id'],$arn))
                                    <span class="badge badge-pill badge-success">{{$nivel['nivel']}}</span>
                                  @endif                              
                                @endforeach
                              @endif
                            <span class="badge badge-pill badge-success">{{ !empty($pregunta['obligatorio'])?'Obligatorio':''}}</span>
                            <select class="form-control mostrar" name="" id="" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!}>
                              <option value="">Seleccionar</option>
                              <option value="1">Si</option>
                              <option value="2">No</option>
                            </select>
                          </div>
                        @endif
                      @endif
                    @endif
                  @endforeach
                </form>
              </fieldset>
            </div>
          @endforeach
        @endif          
      </div>
    </fieldset>
  </fieldset>
  <br><br><br>
</main>
<!-- Modal agregar seccion-->
<div class="modal fade" id="addSeccionModal" tabindex="-1" role="dialog" aria-labelledby="addSeccionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSeccionLabel">Titulo de la sección</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formseccion" action="{{ route('encuesta.seccion.saveUpdate') }}" method="POST">
          <div class="form-group">
            <label for="txtx">Nombre de la sección</label>
            <textarea autofocus='autofocus' name="texto" id="txtx" class="form-control" cols="30" rows="3" required></textarea>
          </div>
          <input type="hidden" id="vorigina" value="{{ count($encuesta['secciones'])+1 }}">
          <input type="hidden" name="encuesta" value="{{ $encuesta['encuesta']['id']}}" required>
          <input type="hidden" name="seccion" value="" required>
          @csrf
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button form="formseccion" type="submit" class="btn btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal agregar seccion-->
<div class="modal fade" id="deleteSeccionModal" tabindex="-1" role="dialog" aria-labelledby="deleteSeccionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteSeccionLabel">Eliminar sección</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formsecciondelete" action="{{ route('encuesta.seccion.eliminar') }}" method="POST">
          <input type="hidden" name="encuesta" value="{{ $encuesta['encuesta']['id'] }}" required>
          <input type="hidden" name="seccion" value="" required>
          @csrf
        </form>
        <p>La eliminación de la sección eliminara las preguntas que contenga, ¿está seguro de eliminarla? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button form="formsecciondelete" type="submit" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal agregar pregunta -->
<div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button form="formQuestion" type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

@endsection