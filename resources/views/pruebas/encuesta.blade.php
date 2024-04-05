@extends('appPruebas')
@section('main')
  <nav class="navbarx">
    <div class='container'>
        <div class='barras'>
            <div class="progress" id="bp">
                <div id='pbini' class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="99" style="width: 0%;">
                    <span class="show">Avance general 0%</span>
                </div>
            </div>
            <div class="progress" id="bs">
                <div id='sb' class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    <span class="show">0%</span>
                </div>
            </div>
        </div>
    </div>
  </nav>
  <input type="hidden" id="idstorage" value="pruebas{{ $encuesta['encuesta']['id'] }}">
  <div class="container cpe" style="padding-top:120px; background: whitesmoke;">
    @if (!empty($encuesta['instrucciones']))
      <a href="#" class="btn-flotante" data-toggle="modal" data-target="#instruccionesModal" title="Ver Instrucciones"><i class='bi bi-info-circle-fill'></i></a>
    @endif
    <a class="btn-flotante-save" id="savex" title="Guardar avance, para retomar después"><i class='bi bi-floppy-fill'></i></a>
    <fieldset id="tab0" class="collapse">
      <legend>Datos de registro</legend>
      <form class="needs-validation" id="{{App\Helpers::generate_string(20)}}" novalidate data-envio="{{ !empty($encuesta['secciones'])?'Continuar':'Finalizar'}}">
        @foreach ($encuesta['registro'] as $campo)
            @if ($campo->campo == 1)
              <div class="form-group">
                <label for="{{$campo->name}}">{{$campo->texto}}</label>
                <input type="text" class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
              </div>
            @endif
            @if ($campo->campo == 2)
              <div class="form-group">
                <label for="{{$campo->name}}">{{$campo->texto}}</label>
                <input type="number" class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
              </div>
            @endif
            @if ($campo->campo == 3)
              <div class="form-group">
                <label for="{{$campo->name}}">{{$campo->texto}}</label>
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
              <div class="form-group">
                <label for="{{$campo->name}}">{{$campo->texto}}</label>
                <textarea name="{{$campo->name}}" id="{{$campo->name}}" class="form-control" cols="30" rows="3" {{ !empty($campo->obligatorio)?'required':''}}></textarea>
              </div>
            @endif
            @if ($campo->campo == 6)
              <div class="form-group">
                <label for="{{$campo->name}}">{{$campo->texto}}</label>
                <select class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                  <option value="">Seleccionar</option>
                  @foreach ($encuesta['area'] as $area)
                      <option value="{{$area['id']}}">{{$area['area']}}</option>
                  @endforeach
                </select>
              </div>
            @endif
            @if ($campo->campo == 7)
            <div class="form-group">
              <label for="{{$campo->name}}">{{$campo->texto}}</label>
              <select class="form-control" name="{{$campo->name}}" id="{{$campo->name}}" {{ !empty($campo->obligatorio)?'required':''}}>
                <option value="">Seleccionar</option>
                @foreach ($encuesta['nivel'] as $nivel)
                      <option value="{{$nivel['id']}}">{{$nivel['nivel']}}</option>
                  @endforeach
              </select>
            </div>
          @endif
        @endforeach
        <br><br>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-lg ">Continuar</button>
        </div>
        <br><br><br>
      </form>
    </fieldset>    
    @if (!empty($encuesta['secciones']))
      @foreach ($encuesta['secciones'] as $seccion)
        <fieldset id="tab{{$seccion['seccion']}}" class="collapse">
          <legend>{{$seccion['texto']}}</legend>
          <form class="needs-validation" id="{{App\Helpers::generate_string(20)}}" novalidate data-envio="{{ $seccion['seccion']==count($encuesta['secciones'])?'Finalizar':'Continuar' }}">
            @foreach ($encuesta['preguntas'] as $k=>$pregunta)
              @if ($pregunta['seccion']== $seccion['seccion'])
                @if ($pregunta['tipo'] == 1)
                  @if ($pregunta['asignacion'] == 0)
                    <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <select class="form-control" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! !empty($pregunta['obligatorio'])?'required':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}>
                        <option value="">Seleccionar</option>
                        @foreach ($encuesta['opciones'] as $opcion)
                            @if ($pregunta['id'] == $opcion['pregunta'])
                                <option value="{{$opcion['opcion']}}">{{$opcion['opcion']}}</option>
                            @endif
                        @endforeach
                      </select>
                    </div>
                  @else
                  <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{App\Helpers::generate_string(15)}}">
                    <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                    <select class="form-control" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}>
                      <option value="">Seleccionar</option>
                      @foreach ($encuesta['opciones'] as $opcion)
                        @if ($pregunta['id'] == $opcion['pregunta'])
                          <option value="{{$opcion['opcion']}}">{{$opcion['opcion']}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  @endif
                @endif
                @if ($pregunta['tipo'] == 2)
                  @if ($pregunta['asignacion'] == 0)
                    <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <input type="text" class="form-control" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! !empty($pregunta['obligatorio'])?'required':'' !!}>
                    </div>
                  @else
                    <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{App\Helpers::generate_string(15)}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <input type="text" class="form-control" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}>
                    </div>
                  @endif
                @endif
                @if ($pregunta['tipo'] == 3)
                  @if ($pregunta['asignacion'] == 0)
                    <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <textarea name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" class="form-control" {!! !empty($pregunta['obligatorio'])?'required':'' !!} data-areas ={{$pregunta['area']}}></textarea>
                    </div>
                  @else
                  <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" data id="{{App\Helpers::generate_string(15)}}">
                    <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                    <textarea name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" class="form-control" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}></textarea>
                  </div>
                  @endif
                @endif
                @if ($pregunta['tipo'] == 4)
                  @if ($pregunta['asignacion'] == 0)
                    <div class="form-group principal" data-nivel="{{$pregunta['subnivel']}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <select class="form-control mostrar" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! !empty($pregunta['obligatorio'])?'required':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}>
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                      </select>
                    </div>
                  @else
                    <div class="form-group subp {!! in_array($pregunta['momento'],[1,2,3])?'oculto':'visible' !!}" data-momento="{{$pregunta['momento']}}" data-obligatorio="{{$pregunta['obligatorio']}}" data-nivel="{{$pregunta['subnivel']}}" id="{{App\Helpers::generate_string(15)}}">
                      <label for="{{$pregunta['name']}}">{{$pregunta['pregunta']}}</label>
                      <select class="form-control mostrar" name="{{$pregunta['name']}}" id="{{$pregunta['name']}}" {!! $pregunta['momento']==0?!empty($pregunta['obligatorio'])?'required':'':'' !!} data-areas ={{$pregunta['area']}} data-niveles ={{$pregunta['nivel']}}>
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                      </select>
                    </div>
                  @endif
                @endif
              @endif
            @endforeach
            <br><br>
            <div class="text-center">
              <button type="submit" class="btn btn-primary btn-lg continue">{{ $seccion['seccion']==count($encuesta['secciones'])?'Finalizar':'Continuar' }}</button>
            </div>
            <br><br><br>
          </form>
        </fieldset>
      @endforeach
    @endif          
  </div>
   <!-- modal de instrucciones -->
   @if (!empty($encuesta['instrucciones']))
    <div class="modal fade" id="instruccionesModal" data-visible="1" role="dialog" aria-labelledby="instruccionesModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="instruccionesModalLabel">Instrucciones para responder la encuesta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              @php
                  $doc = new DOMDocument();
                  $doc->loadHTML(utf8_decode($encuesta['instrucciones']['instrucciones']));
                  echo $doc->saveHTML();
              @endphp
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
          </div>
      </div>
    </div>
  @endif
@endsection