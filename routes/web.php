<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersAuthController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\GestionBDController;
use App\Http\Controllers\ResultadosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// $proxy_url    = getenv('PROXY_URL');

// if (!empty($proxy_url)) {
//    URL::forceRootUrl($proxy_url);
// }

Route::get('/', function () {
    return view('welcome');
});

// funciones de usuarios
Route::get('/Login', [UsersAuthController::class, 'index'])->name('login');
Route::post('/Custom-login', [UsersAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('/Registro', [UsersAuthController::class, 'registration'])->name('register-user');
Route::get('/Gestion', [UsersAuthController::class, 'userManagement'])->name('user.management');
Route::get('/Gestion/Opciones/{id}', [UsersAuthController::class, 'userOptions'])->name('user.options');
Route::post('/Gestion/Opciones/Save', [UsersAuthController::class, 'userOptionsSave'])->name('user.options.save');
#Route::get('/Gestion/Solicitantes', [UsersAuthController::class, 'userManagementPetitioner'])->name('user.management.petitioner');
#Route::get('/Gestion/Opciones/Solicitante/{id}', [UsersAuthController::class, 'userOptionsPetitioner'])->name('user.options.petitioner');
#Route::post('/Gestion/Opciones/Solicitante/Save', [UsersAuthController::class, 'userOptionsPetitionerSave'])->name('user.options.petitioner.save');
#Route::get('/Registro/Solicitante', [UsersAuthController::class, 'registrationPetitioner'])->name('user.register.petitioner');
#Route::post('/Registro/Solicitante/save', [UsersAuthController::class, 'registrationPetitionerSave'])->name('user.register.petitioner.save'); 
Route::post('/Custom-registracion', [UsersAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('/Reset', [UsersAuthController::class, 'resetPassword'])->name('reset');
Route::post('/Reset-login', [UsersAuthController::class, 'emailReset'])->name('reset.custom');
Route::get('/ChangePass/{token}', [UsersAuthController::class, 'emailRestablecer']);
Route::post('/Reset-new', [UsersAuthController::class, 'emailResetNew'])->name('reset.new');
Route::get('signout', [UsersAuthController::class, 'signOut'])->name('signout');


Route::view('success', 'success');
// resultado
Route::get('/Dashboard', [ResultadosController::class, 'obtenerEncuestas'])->name('dashboard');
Route::get('/Dashboard/Resultados/{hash}', [ResultadosController::class, 'obtenerresultados'])->name('dashboard.resultados');

//gestion de encuestas

Route::get('/Catalogo/Area', [GestionController::class, 'gestionArea'])->name('cArea');
Route::get('Catalogo/Area/Registro', [GestionController::class, 'registroArea'])->name('registro.area');
Route::get('Catalogo/Area/Modificar/{id}', [GestionController::class, 'modificarArea'])->name('modificar.area');
Route::post('Catalogo/Area/Guardar', [GestionController::class, 'guardarArea'])->name('catalogo.area.saveUpdate');
Route::get('Catalogo/Area/Eliminar/{id}', [GestionController::class, 'eliminarArea'])->name('catalogo.area.delete');
Route::get('/Catalogo/Nivel', [GestionController::class, 'gestionNivel'])->name('cNivel');
Route::get('Catalogo/Nivel/Registro', [GestionController::class, 'registroNivel'])->name('registro.nivel');
Route::get('Catalogo/Nivel/Modificar/{id}', [GestionController::class, 'modificarNivel'])->name('modificar.nivel');
Route::post('Catalogo/Nivel/Guardar', [GestionController::class, 'guardarNivel'])->name('catalogo.nivel.saveUpdate');
Route::get('Catalogo/Nivel/Eliminar/{id}', [GestionController::class, 'eliminarNivel'])->name('catalogo.nivel.delete');

//creacion de encuestas
Route::get('/Encuesta', [GestionController::class, 'encuesta'])->name('gEncuesta');
Route::get('/Encuesta/Registro', [GestionController::class, 'registroEncuesta'])->name('registro.encuesta');
Route::post('/Encuesta/Guardar', [GestionController::class, 'guardarEncuesta'])->name('encuesta.saveUpdate');
Route::get('/Encuesta/Gestion/{id}', [GestionController::class, 'gestionEncuesta'])->name('encuesta.gestion');
Route::get('/Encuesta/Modificar/{id}', [GestionController::class, 'modificarEncuesta'])->name('encuesta.modificar');
Route::get('/Encuesta/Preguntas/{id}', [GestionController::class, 'gestionPreguntas'])->name('encuesta.preguntas');
Route::post('/Encuesta/Seccion/Guardar', [GestionController::class, 'guardarSeccion'])->name('encuesta.seccion.saveUpdate');
Route::post('/Encuesta/Seccion/Eliminar', [GestionController::class, 'eliminarSeccion'])->name('encuesta.seccion.eliminar');
Route::get('/Modal/{seccion}/{id}/{pregunta?}', [GestionController::class, 'preguntasModal'])->name('encuesta.preguntas.modal');
Route::post('/Encuesta/Preguntas/Guardar', [GestionController::class, 'guardarPregunta'])->name('encuesta.preguntas.saveUpdate');
Route::get('/Encuesta/Preguntas/Eliminar/{id}', [GestionController::class, 'eliminarPregunta'])->name('encuesta.preguntas.delete');
// pagina de inicio de encuesta
Route::get('/Encuesta/Inicio/{id}', [GestionController::class, 'encuestaInicio'])->name('encuesta.inicio');
Route::post('/Encuesta/Inicio/Guardar', [GestionController::class, 'guardarEncuestaInicio'])->name('encuesta.inicio.saveUpdate');
Route::get('/Encuesta/Inicio/Vista/Previa/{id}', [GestionController::class, 'encuestaInicioVistaPrevia'])->name('encuesta.inicio.vista.previa');
// modal de instrucciones de la encuesta
Route::get('/Encuesta/Instrucciones/{id}', [GestionController::class, 'encuestaInstrucciones'])->name('encuesta.instrucciones');
Route::post('/Encuesta/Instrucciones/Guardar', [GestionController::class, 'guardarEncuestaInstrucciones'])->name('encuesta.instrucciones.saveUpdate');
// pagina de finalizacion de encuesta
Route::get('/Encuesta/Fin/{id}', [GestionController::class, 'encuestaFin'])->name('encuesta.fin');
Route::post('/Encuesta/Fin/Guardar', [GestionController::class, 'guardarEncuestaFin'])->name('encuesta.fin.saveUpdate');
Route::get('/Encuesta/Fin/Vista/Previa/{id}', [GestionController::class, 'encuestaFinVistaPrevia'])->name('encuesta.fin.vista.previa');
// Pagina de encuesta cerrada
Route::get('/Encuesta/Cerrada/{id}', [GestionController::class, 'encuestaCerrada'])->name('encuesta.Cerrada');
Route::post('/Encuesta/Cerrada/Guardar', [GestionController::class, 'guardarEncuestaCerrada'])->name('encuesta.cerrada.saveUpdate');
Route::get('/Encuesta/Cerrada/Vista/Previa/{id}', [GestionController::class, 'encuestaCerradaVistaPrevia'])->name('encuesta.cerrada.vista.previa');
// Pagina de registro
Route::get('/Encuesta/Registro/{id}', [GestionController::class, 'encuestaRegistro'])->name('encuesta.registro');
Route::get('/Encuesta/Registro/Datos/{tipo}', [GestionController::class, 'encuestaRegistroDatos'])->name('encuesta.registro.datos');
Route::post('/Encuesta/Registro/Guardar/template', [GestionController::class, 'guardarEncuestaRegistroTemplate'])->name('encuesta.registro.template.saveUpdate');
Route::post('/Encuesta/Registro/Agregar/Campo', [GestionController::class, 'registroAgregarCampo'])->name('registro.agregar.campo');
Route::get('/Encuesta/Registro/Eliminar/Campo/{id}', [GestionController::class, 'registroEliminarcampo'])->name('registro.eliminar.campo');
// prueba de mostrar preguntas
Route::get('/Pruebas/{contexto}', [GestionBDController::class, 'encuestaPruebasContexto'])->name('encuesta.pruebas.contexto');
Route::get('/Pruebas/{contextox}/{contexto}/Encuesta', function ($contexto) {
    return redirect()->route('encuesta.contexto.pruebas.preguntas',[$contexto]);
});
Route::get('/Pruebas/{contexto}/Encuesta', [GestionBDController::class, 'encuestaPruebasContextoPreguntas'])->name('encuesta.contexto.pruebas.preguntas');
Route::get('/Pruebas/{contexto}/Finalizada', [GestionBDController::class, 'encuestaPruebasContextoFinalizada'])->name('encuesta.contexto.pruebas.finalizada');
Route::post('Pruebas/{contexto}/Encuesta/Guardar', [GestionBDController::class, 'encuestaPruebasGuardar'])->name('encuesta.pruebas.guardar');
// publicacion
Route::get('{contexto}', [GestionBDController::class, 'encuestaContexto'])->name('encuesta.contexto');
Route::get('{contextox}/{contexto}/Encuesta', function ($contexto) {
    return redirect()->route('encuesta.contexto.preguntas',[$contexto]);
});
Route::get('/{contexto}/Encuesta', [GestionBDController::class, 'encuestaContextoPreguntas'])->name('encuesta.contexto.preguntas');

Route::post('/{contexto}/Encuesta/Guardar', [GestionBDController::class, 'encuestaGuardar'])->name('encuesta.guardar');
Route::get('/{contexto}/Finalizada', [GestionBDController::class, 'encuestaContextoFinalizada'])->name('encuesta.contexto.finalizada');


Route::post('/Encuesta/Publicar', [GestionBDController::class, 'publicar'])->name('encuesta.publicar');