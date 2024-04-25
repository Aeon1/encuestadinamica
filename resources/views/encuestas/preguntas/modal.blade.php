<form id="formQuestion" action="{{ route('encuesta.preguntas.saveUpdate') }}" method="POST">
  @csrf
  @php($p = !empty($datos['pregunta'])?$datos['pregunta']:'')
  <input type="hidden" name="seccion" id="seccion" value="{{ $datos['seccion'] }}">
  <input type="hidden" name="encuesta" id="encuesta" value="{{ $datos['id'] }}">
  <input type="hidden" name="id" id="id" value="{{ !empty($p['id'])?$p['id']:'' }}">
  <div class="form-group">
    <label for="asignacion">Asignar a pregunta (opcional)</label>
    <select class="form-control" name="asignacion" id="asignacion">
      <option value="0">Seleccionar</option>
      @foreach ($datos['asignaciones'] as $asignacion)
          <option value="{{ $asignacion['id'] }}" data-level="{{ $asignacion['subnivel']}}" data-orden = '{{ $asignacion['orden']}}' {{ !empty($p['asignacion'])?$p['asignacion'] ==$asignacion['id']?'selected':'':''}}>{{ $asignacion['pregunta']}}</option>
      @endforeach
    </select>
  </div>
  <input type="hidden" name="subnivel" id="subnivel" value="0">
  <div class="form-group {{empty($p['asignacion'])?'d-none':''}}" id="timeShowWhen">
    <label for="momneto">Se muestra cuando selecciona:</label>
    <select class="form-control" name="momento" id="momento">
      <option value="0" {{!empty($p['momento'])?$p['momento'] == 0?'selected':'':''}}>visible siempre</option>
      <option value="1" {{!empty($p['momento'])?$p['momento'] == 1?'selected':'':''}}>Si</option>
      <option value="2" {{!empty($p['momento'])?$p['momento'] == 2?'selected':'':''}}>No</option>
      <option value="3" {{!empty($p['momento'])?$p['momento'] == 3?'selected':'':''}}>Cualquiera</option>
    </select>
  </div>                
  <div class="form-group">
    <label for="pregunta" class="col-form-label">Pregunta:</label>
    <textarea name="pregunta" id="pregunta" class="form-control" style="width: 100%;height: 100px;" required>{{!empty($p['pregunta'])?$p['pregunta']:''}}</textarea>
  </div>
  <fieldset>
    <legend>Tipo de pregunta</legend>
    <div class="custom-control custom-radio">
      <input type="radio" id="typeQuestion1" data-option='1' name="tipo" class="custom-control-input" value="1" {{!empty($p['tipo'])?$p['tipo']==1?'checked':'':''}} required>
      <label class="custom-control-label"  for="typeQuestion1">Opción multiple (personalizado)</label>
    </div>
    <fieldset class="d-none oqf" id="oq1">
      <legend style="font-size: 12px">Opción multiple</legend>
      <h5>Agregar las opciones</h5>
      <div id="oqc">
          <div class="form-group">
            <input type="text" class="form-control" name="oqp[]">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="oqp[]">
          </div>
      </div>
      <button type="button" id="addOptionQuestion" class="btn btn-info"><i class="bi bi-node-plus-fill"></i></button>
      <hr>
    </fieldset>
    <div class="custom-control custom-radio">
      <input type="radio" id="typeQuestion2" data-option='2' name="tipo" class="custom-control-input" value="2" {{!empty($p['tipo'])?$p['tipo']==2?'checked':'':''}}>
      <label class="custom-control-label" for="typeQuestion2">Abierta (input)</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="typeQuestion3" data-option='3' name="tipo" class="custom-control-input" value="3" {{!empty($p['tipo'])?$p['tipo']==3?'checked':'':''}}>
      <label class="custom-control-label" for="typeQuestion3">Abierta (text)</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="typeQuestion4" data-option='4' name="tipo" class="custom-control-input" value="4" {{!empty($p['tipo'])?$p['tipo']==4?'checked':'':''}}>
      <label class="custom-control-label" for="typeQuestion4">Si/No (select)</label>
    </div>
    <hr>
    <div class="form-group">
      <label for="area">Área:</label>
      <select class="form-control" name="area[]" id="area" multiple="multiple">
        <option value="0">Todas</option>
        @foreach ($datos['areas'] as $area)
          <option value="{{ $area['id'] }}" {{!empty($p['area'])?$p['area'] == $area['id']?'selected':'':''}}>{{ $area['area'] }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="nivel">Nivel jerárquico:</label>
      <select class="form-control" name="nivel[]" id="nivel" multiple="multiple">
        <option value="0">Todos</option>
        @foreach ($datos['niveles'] as $nivel)
          <option value="{{ $nivel['id'] }}" {{!empty($p['nivel'])?$p['nivel'] == $nivel['id']?'selected':'':''}}>{{ $nivel['nivel'] }}</option>
        @endforeach
      </select>
    </div>
    <div class="custom-control custom-checkbox">
      <input class="custom-control-input" type="checkbox" name="obligatorio" id="obligatorio" value="1" {{!empty($p['obligatorio'])?$p['obligatorio'] == 1?'checked':'':'checked'}} >
      <label class="custom-control-label" for="obligatorio">Obligatorio</label>
    </div>
  </fieldset>
</form>

