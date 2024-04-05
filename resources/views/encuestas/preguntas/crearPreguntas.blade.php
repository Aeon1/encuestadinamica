@extends('appExterna')
@section('main')
<fieldset>
    <legend>Crear Encuesta</legend>
    <div class="container-fluid">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numbre_encuesta">Contexto de la encuesta</label>
                        <input type="text" name="contexto" class="form-control" placeholder="Encuesta_de_control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numbre_encuesta">Nombre de la encuesta</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Encuesta de control">
                    </div>
                </div>
            </div>
            <fieldset>
                <legend>Preguntas</legend>
                    <button type="button" class="btn btn-info" id="addSection">Agregar seccion</button>
                    <ul class="nav nav-tabs" id="tabs" role="tablist"></ul>                    
                    <div class="tab-content"></div>
            </fieldset>
        </form>
    </div>

</fieldset>
<div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formQuestion">
            <input type="hidden" class="form-control" name="seccion" id="seccion">
            <div class="form-group">
                <label for="asignacion">Asignar a pregunta (opcional)</label>
                <select class="form-control" name="asignacion" id="asignacion">
                    <option value="">Seleccionar</option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                </select>
            </div>
            <div class="form-group d-none" id="timeShowWhen">
                <label for="timeShow">Se muestra cuando selecciona:</label>
                <select class="form-control" name="timeShow" id="timeShow">
                    <option value="">Seleccionar</option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                    <option value="3">Cualquiera</option>
                </select>
            </div>                
            <div class="form-group">
                <label for="pregunta" class="col-form-label">Pregunta:</label>
                <textarea name="pregunta" id="pregunta" style="width: 100%;height: 100px;"></textarea>
              </div>
            <fieldset>
                <legend>Tipo de pregunta</legend>
                <div class="custom-control custom-radio">
                    <input type="radio" id="typeQuestion1" data-option='1' name="typeQuestion" class="custom-control-input">
                    <label class="custom-control-label"  for="typeQuestion1">Opción multiple (personalizado)</label>
                </div>
                <fieldset class="d-none oqf" id="oq1">
                    <legend style="font-size: 12px">Opción multiple</legend>
                    <h5>Agregar las opciones</h5>
                    <div id="oqc">
                        <div class="form-group">
                            <input type="text" class="form-control" name="oqp1">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="oqp2">
                        </div>
                    </div>
                    <button type="button" id="addOptionQuestion" class="btn btn-info"><i class="bi bi-node-plus-fill"></i></button>
                    <hr>
                </fieldset>
                <div class="custom-control custom-radio">
                    <input type="radio" id="typeQuestion2" data-option='2' name="typeQuestion" class="custom-control-input">
                    <label class="custom-control-label" for="typeQuestion2">Abierta (chica)</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="typeQuestion3" data-option='3' name="typeQuestion" class="custom-control-input">
                    <label class="custom-control-label" for="typeQuestion3">Abierta (grande)</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="typeQuestion4" data-option='4' name="typeQuestion" class="custom-control-input">
                    <label class="custom-control-label" for="typeQuestion4">Si/No (select)</label>
                </div>
            </fieldset>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
@endsection