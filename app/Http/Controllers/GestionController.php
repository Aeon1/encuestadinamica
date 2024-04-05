<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Nivel;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\pagina_inicio;
use App\Models\pagina_instruccion;
use App\Models\pagina_fin;
use App\Models\pagina_cerrada;
use App\Models\RegistroFormTemplate;
use App\Models\registroForm;
use App\Models\Secciones;
use App\Models\configuracion_encuesta;
use DB;

class GestionController extends Controller
{
    // registro de catalogo de nivel
    public function gestionArea(){
        if(Auth::check()){
            $areas = Area::select('id','area','activo')->get();
            return view('catalogos.gestionarea', compact('areas'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function registroArea(){
        if(Auth::check()){            
            return view('catalogos.registroArea');
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function guardarArea(Request $request){
        if(Auth::check()){
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'El nombre del área es obligatorio',
            ]);
            $data = $request->all();
            if (!empty($data['id'])) {
                $check = Area::where('id',$data['id'])
                ->update([
                    'area' => $data['name'],
                    'activo' => !empty($data['activo'])?1:0
                ]);
                if ($check) {
                    return redirect("Catalogo/Area")->with('success','Área actualizada correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            } else {
                $check = Area::create([
                    'area' => $data['name']
                ]);
                if ($check) {
                    return redirect("Catalogo/Area")->with('success','Área creada correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
        
    }

    public function modificarArea($id){
        if(Auth::check()){            
            $area = Area::select('id','area','activo')->where('id',$id)->firstOrFail();
            return view('catalogos.modificarArea',compact('area'));
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function eliminarArea($id){
        if(Auth::check()){            
            $area = Area::where('id',$id)->delete();
            if ($area) {
                return redirect("Catalogo/Area")->with('success','Área eliminada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
            
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    // registro de catalogo de nivel
    public function gestionNivel(){
        if(Auth::check()){
            $niveles = Nivel::select('id','nivel','activo')->get();
            return view('catalogos.gestionnivel', compact('niveles'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function registroNivel(){
        if(Auth::check()){            
            return view('catalogos.registroNivel');
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function guardarNivel(Request $request){
        if(Auth::check()){
            $request->validate([
                'name' => 'required',
            ], [
                'name.required' => 'El nombre del área es obligatorio',
            ]);
            $data = $request->all();
            if (!empty($data['id'])) {
                $check = Nivel::where('id',$data['id'])
                ->update([
                    'nivel' => $data['name'],
                    'activo' => !empty($data['activo'])?1:0
                ]);
                if ($check) {
                    return redirect("Catalogo/Nivel")->with('success','Nivel jerárquico actualizado correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            } else {
                $check = Nivel::create([
                    'nivel' => $data['name']
                ]);
                if ($check) {
                    return redirect("Catalogo/Nivel")->with('success','Nivel jerárquico creado correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function modificarNivel($id){
        if(Auth::check()){
            $nivel = Nivel::select('id','nivel','activo')->where('id',$id)->firstOrFail();
            return view('catalogos.modificarNivel',compact('nivel'));
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function eliminarNivel($id){
        if(Auth::check()){
            $nivel = Nivel::where('id',$id)->delete();
            if ($nivel) {
                return redirect("Catalogo/Nivel")->with('success','Nivel jerárquico eliminado correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
            
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    // registro de encuestas
    public function encuesta(){
        if(Auth::check()){
            $encuestas = Encuesta::select('encuestas.id','contexto','nombre','estatus','publicada')
            ->leftJoin('configuracion_encuestas','encuestas.id','=','configuracion_encuestas.encuesta')->get();
            return view('encuestas.gestionarEncuesta', compact('encuestas'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function registroEncuesta(){
        if(Auth::check()){
            return view('encuestas.crearEncuesta');
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function gestionEncuesta( $id){
        if(Auth::check()){
            $encuesta = Encuesta::select('id','contexto','nombre','institucional','estatus')->where('id',$id)->firstOrFail();
            
            return view('encuestas.gestionEncuesta', compact('encuesta'));
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarEncuesta(Request $request){
        if(Auth::check()){
            $request->validate([
                'nombre' => 'required',
                'contexto' => 'required',
            ], [
                'nombre.required' => 'El nombre de la encuesta es obligatorio',
                'contexto.required' => 'El contexto de la encuesta es obligatorio',
            ]);
            $data = $request->all();
            if (!empty($data['id'])) {
                $check = Encuesta::where('id',$data['id'])
                ->update([
                    'nombre' => $data['nombre'],
                    'contexto' => $data['contexto'],
                    'institucional' => !empty($data['institucional'])?1:0,
                    'estatus' => !empty($data['estatus'])?1:0,
                    
                ]);
                if ($check) {
                    return redirect("/Encuesta/Gestion/$data[id]")->with('success','Encuesta actualizada correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            } else {
                $check = Encuesta::create([
                    'nombre' => $data['nombre'],
                    'contexto' => $data['contexto']
                ]);
                if ($check) {
                    $c = configuracion_encuesta::create([
                        'hash' => sha1(microtime()),
                        'encuesta' => $check->id
                    ]);
                    return redirect("/Encuesta")->with('success','Encuesta creada correctamente');
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
        
    }

    public function modificarEncuesta($id){
        if(Auth::check()){
            $encuesta = Encuesta::select('id','nombre','contexto','estatus','institucional')->where('id',$id)->firstOrFail();
            return view('encuestas.modificarEncuestas',compact('encuesta'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function gestionPreguntas($id){
        if(Auth::check()){
            $encuesta['encuesta'] = Encuesta::select('id','nombre')->where('id',$id)->firstOrFail();
            $encuesta['preguntas'] = Pregunta::where('encuesta', $id)->orderBy('seccion','asc')->orderBy('orden','asc')->get();
            $encuesta['secciones'] = Secciones::select('seccion','texto')->where('encuesta', $id)->orderBy('seccion','asc')->get();
            $encuesta['opciones'] = Opcion::select('pregunta','opcion')->where('encuesta',$id)->get();
            $encuesta['areas'] = Area::select('id','area')->get();
            $encuesta['nivel'] = Nivel::select('id','nivel')->get();
            return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));
        }        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarSeccion(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
                'seccion' => 'required',
                'texto' => 'required'
            ]);
            $data = $request->all();
            $check = Secciones::updateOrCreate(
                ['encuesta' => $data['encuesta'], 'seccion' => $data['seccion']],
                ['texto' => $data['texto']]
            );
            if ($check) {
                return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Sección creada/actualizado correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function eliminarSeccion(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
                'seccion' => 'required'
            ]);
            $data = $request->all();
            $c = Pregunta::where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->count();
            if($c > 0){
                $check = Pregunta::where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->delete();
                if ($check) {
                    
                    $chk = Secciones::where('encuesta',$data['encuesta'])->where('seccion', $data['seccion'])->delete();
                    if ($chk) {
                        return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Sección creada/actualizado correctamente');
                    }else{
                        return back()->with('error','Ocurrio un error, intente de nuevo');
                    }
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }else{
                $chk = Secciones::where('encuesta',$data['encuesta'])->where('seccion', $data['seccion'])->delete();
                if ($chk) {
                    return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Sección creada/actualizado correctamente');
                }else{
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
            
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function preguntasModal($seccion,$id, $pregunta = ""){
        if(Auth::check()){
            $datos['id'] = $id;
            $datos['seccion'] = $seccion; 
            $datos['areas'] = Area::select('id','area')->get();
            $datos['niveles'] = Nivel::select('id','nivel')->get();
            $datos['asignaciones'] = Pregunta::select('id','pregunta','orden','subnivel')->where('tipo',4)->where('encuesta',$id)->where('seccion',$seccion)->get();
            if (!empty($pregunta)) {
                $datos['pregunta'] = Pregunta::where('id',$pregunta)->firstOrFail();
            }            
            return view('encuestas.preguntas.modal',compact('datos'));

        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarPregunta(Request $request){
        if(Auth::check()){
            $request->validate([
                'pregunta' => 'required',
                'tipo' => 'required',
            ], [
                'pregunta.required' => 'La pregunta es obligatorio',
                'tipo.required' => 'El tipo de pregunta es obligatorio',
            ]);
            $data = $request->all();
            if (!empty($data['id'])) {
                $pg = Pregunta::where('id',$data['id'])->firstOrFail();
                $comprobar = Pregunta::select('id')->where('asignacion',$data['id'])->get();
                if($comprobar->count() >= 1){
                    if ($pg['tipo'] == 4 && $data['tipo'] != 4) {
                        return back()->with('error','No se puede cambiar el tipo de pregunta, debe eliminar las asignaciones primero');
                    }
                    $orden = $pg['orden'];
                    $f = str_replace("*","_",$orden);
                    $check = Pregunta::where('id',$pg['id'])->
                        update(['asignacion'=>$data['asignacion'],
                                'momento'=> $data['momento'],
                                'pregunta' => $data['pregunta'],
                                'tipo' => $data['tipo'],
                                'area' => !empty($data['area'])?implode(',',$data['area']):'0',
                                'nivel' => !empty($data['nivel'])?implode(',',$data['nivel']):'0',
                                'obligatorio' => !empty($data['obligatorio'])?$data['obligatorio']:0,
                                'orden' => !empty($data['asignacion'])?$orden:$pg['orden'],
                                'subnivel' => $data['subnivel'],
                                'name' => "pregunta_".$data['seccion']."_".$f
                                ]);
                    if ($check) {
                        if ($data['tipo'] == 1) {
                            if($pg['tipo'] == 1){
                                Opcion::where('pregunta',$pg['id'])->delete();
                            }
                            foreach ($data['oqp'] as $o) {
                                Opcion::create([
                                    'encuesta' => $data['encuesta'],
                                    'pregunta' => $pg['id'],
                                    'opcion' => $o
                                ]);
                            }
                        }
                        return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Pregunta actualizada correctamente');
                    } else {
                        return back()->with('error','Ocurrio un error, intente de nuevo');
                    }
                }else{
                    if (!empty($data['asignacion']) && $pg['asignacion'] != $data['asignacion']) {
                        $ordenx = Pregunta::selectRaw('MAX(orden) as orden')->where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->where('asignacion',$data['asignacion'])->firstOrFail();
                        if (!empty($ordenx->orden)) {
                            $p = explode('*',$ordenx->orden);
                            $orden = substr($ordenx->orden, 0, -1).(end($p)+1);
                        }else{
                            $ordeny = Pregunta::select('orden')->where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->where('id',$data['asignacion'])->firstOrFail();
                            if (!empty($ordeny->orden)) {
                                $orden = $ordeny->orden.'*1';
                            }
                        }
                    }else{
                        $orden = $pg['orden'];
                    }
                    $f = str_replace("*","_",$orden);
                    $check = Pregunta::where('id',$pg['id'])->
                        update(['asignacion'=>$data['asignacion'],
                                'momento'=> $data['momento'],
                                'pregunta' => $data['pregunta'],
                                'tipo' => $data['tipo'],
                                'area' => !empty($data['area'])?implode(',',$data['area']):'0',
                                'nivel' => !empty($data['nivel'])?implode(',',$data['nivel']):'0',
                                'obligatorio' => !empty($data['obligatorio'])?$data['obligatorio']:0,
                                'orden' => !empty($data['asignacion'])?$orden:$pg['orden'],
                                'subnivel' => $data['subnivel'],
                                'name' => "pregunta_".$data['seccion']."_".$f
                                ]);
                    if ($check) {
                        if ($data['tipo'] == 1) {
                            if($pg['tipo'] == 1){
                                Opcion::where('pregunta',$pg['id'])->delete();
                            }
                            foreach ($data['oqp'] as $o) {
                                Opcion::create([
                                    'encuesta' => $data['encuesta'],
                                    'pregunta' => $pg['id'],
                                    'opcion' => $o
                                ]);
                            }
                        }
                        return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Pregunta actualizada correctamente');
                    } else {
                        return back()->with('error','Ocurrio un error, intente de nuevo');
                    }                    
                }
            } else {
                $orden = 0;
                if (!empty($data['asignacion'])) {
                    $ordenx = Pregunta::selectRaw('MAX(orden) as orden')->where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->where('asignacion',$data['asignacion'])->firstOrFail();
                    if (!empty($ordenx->orden)) {
                        $p = explode('*',$ordenx->orden);
                        $orden = substr($ordenx->orden, 0, -1).(end($p)+1);
                    }else{
                        $ordeny = Pregunta::select('orden')->where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->where('id',$data['asignacion'])->firstOrFail();
                        if (!empty($ordeny->orden)) {
                            $orden = $ordeny->orden.'*1';
                        }
                    }                    
                }else{
                    $ordenx = Pregunta::selectRaw('MAX(orden) as orden')->where('encuesta',$data['encuesta'])->where('seccion',$data['seccion'])->firstOrFail();
                    if (!empty($ordenx->orden)) {

                        $orden = explode('*',$ordenx->orden)[0]+1;
                    }else{
                        $orden = 1;
                    }                    
                }
                $f = str_replace("*","_",$orden); 
                $check = Pregunta::create([
                    'encuesta' => $data['encuesta'],
                    'seccion' => $data['seccion'],
                    'asignacion' => $data['asignacion'],
                    'momento' => $data['momento'],
                    'pregunta' => $data['pregunta'],
                    'tipo' => $data['tipo'],
                    'area' => !empty($data['area'])?implode(',',$data['area']):'0',
                    'nivel' => !empty($data['nivel'])?implode(',',$data['nivel']):'0',
                    'obligatorio' => !empty($data['obligatorio'])?$data['obligatorio']:0,
                    'orden' => $orden,
                    'subnivel' => $data['subnivel'],
                    'name' => "pregunta_".$data['seccion']."_".$f
                ]);
                if ($check) {
                    if ($data['tipo'] == 1) {
                        foreach ($data['oqp'] as $o) {
                            Opcion::create([
                                'encuesta' => $data['encuesta'],
                                'pregunta' => $check->id,
                                'opcion' => $o
                            ]);
                        }
                        
                        
                    }
                    return redirect("/Encuesta/Preguntas/$data[encuesta]")->with('success','Pregunta creada correctamente');
                    
                }else {
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
        }
        // return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function eliminarPregunta($id){
        if(Auth::check()){
            // $pg = Pregunta::where('id',$id)->firstOrFail();
            $comprobar = Pregunta::select('id')->where('asignacion',$id)->get();
            if($comprobar->count() >= 1){
                return 'No se puede eliminar la pregunta, debe eliminar las asignaciones primero';
            }else {
                $chk = Pregunta::where('id',$id)->delete();
                if ($chk) {
                    Opcion::where('pregunta',$id)->delete();
                    return 200;
                }
            }
            
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function encuestaInicio($id){
        if(Auth::check()){
            $encuesta['encuesta'] = Encuesta::select('id','nombre','contexto')->where('id',$id)->firstOrFail();
            try {
                $encuesta['pagina'] = pagina_inicio::select('encuesta','inicio')->where('encuesta',$id)->firstOrFail();
            } catch (\Throwable $th) {
                $encuesta['pagina']['inicio'] = '';
            }
            return view('encuestas.inicio',compact('encuesta'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarEncuestaInicio(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
            ], [
                'encuesta.required' => 'El ID de la encuesta es obligatorio',
            ]);
            $data = $request->all();
            $check = pagina_inicio::updateOrCreate(
                ['encuesta' => $data['encuesta']],
                ['encuesta' => $data['encuesta'], 'inicio' => $data['inicio']]
            );
            if ($check) {
                return redirect("/Encuesta/Inicio/$data[encuesta]")->with('success','Página guardada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');

    }

    public function encuestaInicioVistaPrevia($id){
        if(Auth::check()){
            try {
                // $pagina = pagina_inicio::select('encuesta','inicio')->where('encuesta',$id)->firstOrFail();
                $pagina = pagina_inicio::select('pagina_inicios.encuesta','pagina_inicios.inicio','encuestas.institucional')->where('encuesta',$id)
                ->leftJoin('encuestas', 'pagina_inicios.encuesta', '=', 'encuestas.id')->firstOrFail();
                if (empty($pagina['institucional'])) {
                    return view('encuestaPreview.inicio',compact('pagina'));
                }else{
                    return view('encuestaPreview.inicio_institucional',compact('pagina'));
                }
            } catch (\Throwable $th) {
                $pagina['inicio'] = '<h3>Debe guardar los cambios primero</h3>';
            }
            // return view('encuestaPreview.inicio',compact('pagina'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function encuestaInstrucciones($id){
        if(Auth::check()){
            $encuesta['encuesta'] = Encuesta::select('id','nombre','contexto')->where('id',$id)->firstOrFail();
            try {
                $encuesta['pagina'] = pagina_instruccion::select('encuesta','instrucciones')->where('encuesta',$id)->firstOrFail();
            } catch (\Throwable $th) {
                $encuesta['pagina']['instrucciones'] = '';
            }
            return view('encuestas.instrucciones',compact('encuesta'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function encuestaRegistro($id){
        if(Auth::check()){
            $c['id'] = $id;
            $c['campos'] = RegistroFormTemplate::where('activo',true)->get();
            $c['registro'] = registroForm::selectRaw('registro_forms.obligatorio,registro_forms.tipo,registro_form_templates.texto,registro_form_templates.campo,registro_form_templates.name')
            ->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
            ->where('encuesta',$id)
            ->get();
            $c['nivel'] = Nivel::select('nivel')->get();
            $c['area'] = Area::select('area')->get();
            return view('encuestas.registro',compact('c'));
        }        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarEncuestaRegistroTemplate(Request $request){
        if(Auth::check()){
            $data = $request->all();
            if (!empty($data)) {
                $da = explode(',',$data['template']);
                $eliminar = true;
                $con = registroForm::where('encuesta',$data['encuesta'])->count();
                if ($con >= 1) {
                    $eliminar = registroForm::where('encuesta',$data['encuesta'])->delete();
                }             
                if ($eliminar) {
                    foreach ($da as $d) {
                        if (!empty($d)) {
                            $x = explode('*',$d);
                            registroForm::Create(
                                ['encuesta'=>$data['encuesta'],
                                'tipo' => $x[0],
                                'obligatorio' => !empty($x[1])?$x[1]:0]
                            );
                        }
                    }
                    return redirect("/Encuesta/Registro/$data[encuesta]")->with('success','Formulario de registro guardado correctamente');
                }else{
                    return back()->with('error','Ocurrio un error, intente de nuevo');
                }
            }
        }        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function encuestaRegistroDatos($tipo){
        $d = "";
        if ($tipo == 1) {
            $d = Area::select('area')->get();
            return json_encode($d,true);
        }elseif ($tipo == 2) {
            $d = Nivel::select('nivel')->get();
            return json_encode($d,true);
        }
    }

    public function registroAgregarCampo(Request $request){
        if(Auth::check()){
            $request->validate([
                'texto' => 'required',
                'name' => 'required',
                'campo' => 'required',
            ], [
                'texto.required' => 'El texto a mostrar es obligatorio',
                'name.required' => 'El nombre del campo es obligatorio',
                'campo.required' => 'El tipo campo es obligatorio',
            ]);
            $data = $request->all();
            $check = RegistroFormTemplate::Create(
                [
                    'texto' => $data['texto'],
                    'name' => $data['name'],
                    'campo' => $data['campo']
                ],
                
            );
            if ($check) {
                return redirect("/Encuesta/Registro/$data[encuesta]")->with('success','Página guardada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function registroEliminarcampo($id){
        if(Auth::check()){
            $c = RegistroFormTemplate::where('id',$id)
                ->update([
                'activo' => 0
            ]);
            if($c){
                echo json_encode(['respuesta' => 1]);
            }else{
                echo json_encode(['respuesta' => 2]);
            }
        }
    }

    public function guardarEncuestaInstrucciones(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
            ], [
                'encuesta.required' => 'El ID de la encuesta es obligatorio',
            ]);
            $data = $request->all();
            $check = pagina_instruccion::updateOrCreate(
                ['encuesta' => $data['encuesta']],
                ['instrucciones' => $data['instrucciones']]
            );
            if ($check) {
                return redirect("/Encuesta/Instrucciones/$data[encuesta]")->with('success','Página guardada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');

    }

    public function encuestaFin($id=''){
        if(Auth::check()){
            $encuesta['encuesta'] = Encuesta::select('id','nombre','contexto')->where('id',$id)->firstOrFail();
            try {
                $encuesta['pagina'] = pagina_fin::select('encuesta','fin')->where('encuesta',$id)->firstOrFail();
            } catch (\Throwable $th) {
                $encuesta['pagina']['fin'] = '';
            }
            return view('encuestas.fin',compact('encuesta'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarEncuestaFin(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
            ], [
                'encuesta.required' => 'El ID de la encuesta es obligatorio',
            ]);
            $data = $request->all();
            $check = pagina_fin::updateOrCreate(
                ['encuesta' => $data['encuesta']],
                ['encuesta' => $data['encuesta'], 'fin' => $data['fin']]
            );
            if ($check) {
                return redirect("/Encuesta/Fin/$data[encuesta]")->with('success','Página guardada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');

    }

    public function encuestaFinVistaPrevia($id=''){
        if(Auth::check()){
            try {
                $pagina = pagina_fin::select('pagina_fins.encuesta','pagina_fins.fin','encuestas.institucional')->where('encuesta',$id)
                ->leftJoin('encuestas', 'pagina_fins.encuesta', '=', 'encuestas.id')->firstOrFail();
                if (empty($pagina['institucional'])) {
                    return view('encuestaPreview.fin',compact('pagina'));
                }else{
                    return view('encuestaPreview.fin_institucional',compact('pagina'));
                }
            } catch (\Throwable $th) {
                $pagina['fin'] = '<h3>Debe guardar los cambios primero</h3>';
            }
            
            
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function encuestaCerrada($id){
        if(Auth::check()){
            $encuesta['encuesta'] = Encuesta::select('id','nombre','contexto')->where('id',$id)->firstOrFail();
            try {
                $encuesta['pagina'] = pagina_cerrada::select('encuesta','cerrada')->where('encuesta',$id)->firstOrFail();
                $encuesta['config'] = configuracion_encuesta::select('fecha_inicio','fecha_fin')->where('encuesta',$id)->firstOrFail();
            } catch (\Throwable $th) {
                $encuesta['pagina']['cerrada'] = '';
                $encuesta['config']['fecha_inicio'] = '';
                $encuesta['config']['fecha_fin'] = '';
            }
            return view('encuestas.cerrada',compact('encuesta'));
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    public function guardarEncuestaCerrada(Request $request){
        if(Auth::check()){
            $request->validate([
                'encuesta' => 'required',
                'inicio' => 'required',
                'fin' => 'required'
            ], [
                'encuesta.required' => 'El ID de la encuesta es obligatorio',
                'inicio.required' => 'La fecha de inicio es obligatoria',
                'fin.required' => 'La fecha de cierre es obligatoria',
            ]);
            $data = $request->all();
            $check = pagina_cerrada::updateOrCreate(
                ['encuesta' => $data['encuesta']],
                ['cerrada' => $data['cerrada']]
            );
            if ($check) {
                $c = configuracion_encuesta::where('encuesta',$data['encuesta'])
                    ->update([
                    'fecha_inicio' => $data['inicio'],
                    'fecha_fin' => $data['fin']
                ]);
                return redirect("/Encuesta/Cerrada/$data[encuesta]")->with('success','Página guardada correctamente');
            }else {
                return back()->with('error','Ocurrio un error, intente de nuevo');
            }
        }
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');

    }

    public function encuestaCerradaVistaPrevia($id){
        if(Auth::check()){
            try {
                $pagina = pagina_cerrada::select('pagina_cerradas.encuesta','pagina_cerradas.cerrada','encuestas.institucional')->where('encuesta',$id)
                ->leftJoin('encuestas', 'pagina_cerradas.encuesta', '=', 'encuestas.id')->firstOrFail();
                if (empty($pagina['institucional'])) {
                    return view('encuestaPreview.cerrada',compact('pagina'));
                }else{
                    return view('encuestaPreview.cerrada_institucional',compact('pagina'));
                }
            } catch (\Throwable $th) {
                $pagina['fin'] = '<h3>Debe guardar los cambios primero</h3>';
            }
            
            
        }
        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    // public function encuestaPruebasContexto($contexto){
    //     $comprobar = Encuesta::select('id','institucional','estatus')->where('contexto',$contexto)->firstOrFail();
    //     if (!empty($comprobar['id']) && $comprobar['estatus'] ==1 ) {
    //         $pagina = pagina_inicio::select('encuesta','inicio')->firstOrFail();
    //             if (empty($comprobar['institucional'])) {
    //                 return view('publicacion.inicio',compact('pagina'));
    //             }else{
    //                 return view('publicacion.inicio_institucional',compact('pagina'));
    //             }
    //     }else{
    //         if (!empty($comprobar['institucional'])) {
    //             return view('publicacion.404ins');
    //         }else{
    //             return view('publicacion.404');
    //         }
            
    //     }
    // }

    // public function encuestaPruebasContextoPreguntas($contexto){
    //     $comprobar = Encuesta::select('id','institucional')->where('contexto',$contexto)->firstOrFail();
    //     if (!empty($comprobar['id'])) {
    //         $encuesta['encuesta'] = Encuesta::select('id','nombre')->where('id',$comprobar['id'])->firstOrFail();
    //         $encuesta['registro'] = DB::table('registro_forms')
    //         ->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
    //         ->selectRaw('registro_forms.obligatorio,registro_form_templates.texto,registro_form_templates.campo,registro_form_templates.name')
    //         ->get();
    //         $encuesta['preguntas'] = Pregunta::where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->orderBy('orden','asc')->get();
    //         // $encuesta['secciones'] = Pregunta::select('seccion')->where('encuesta',$comprobar['id'])->groupBy('seccion')->orderBy('seccion','asc')->get();
    //         $encuesta['secciones'] = Secciones::select('seccion','texto')->where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->get();
    //         $encuesta['opciones'] = Opcion::select('pregunta','opcion')->where('encuesta',$comprobar['id'])->get();
    //         try {
    //             $encuesta['instrucciones'] = pagina_instruccion::select('instrucciones')->where('encuesta',$comprobar['id'])->firstOrFail();
    //         } catch (\Throwable $th) {
    //             $encuesta['instrucciones'] = 0;
    //         }
            
    //         $encuesta['nivel'] = Nivel::select('nivel')->get();
    //         $encuesta['area'] = Area::select('area')->get();
    //         // return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));

    //         if (empty($comprobar['institucional'])) {
    //             return view('publicacion.encuesta',compact('encuesta'));
    //         }else{
    //             return view('publicacion.encuesta_institucional',compact('encuesta'));
    //         }
    //     }else{

    //     }
    //     // return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));
    // }

    // public function encuestaContexto($contexto){
    //     $comprobar = Encuesta::select('id','institucional','estatus')->where('contexto',$contexto)->firstOrFail();
    //     if (!empty($comprobar['id']) && $comprobar['estatus'] ==1 ) {
    //         $pagina = pagina_inicio::select('encuesta','inicio')->firstOrFail();
    //             if (empty($comprobar['institucional'])) {
    //                 return view('publicacion.inicio',compact('pagina'));
    //             }else{
    //                 return view('publicacion.inicio_institucional',compact('pagina'));
    //             }
    //     }else{
    //         if (!empty($comprobar['institucional'])) {
    //             return view('publicacion.404ins');
    //         }else{
    //             return view('publicacion.404');
    //         }
            
    //     }
    // }

    // public function encuestaContextoPreguntas($contexto){
    //     $comprobar = Encuesta::select('id','institucional')->where('contexto',$contexto)->firstOrFail();
    //     if (!empty($comprobar['id'])) {
    //         $encuesta['encuesta'] = Encuesta::select('id','nombre')->where('id',$comprobar['id'])->firstOrFail();
    //         $encuesta['registro'] = DB::table('registro_forms')
    //         ->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
    //         ->selectRaw('registro_forms.obligatorio,registro_form_templates.texto,registro_form_templates.campo,registro_form_templates.name')
    //         ->get();
    //         $encuesta['preguntas'] = Pregunta::where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->orderBy('orden','asc')->get();
    //         // $encuesta['secciones'] = Pregunta::select('seccion')->where('encuesta',$comprobar['id'])->groupBy('seccion')->orderBy('seccion','asc')->get();
    //         $encuesta['secciones'] = Secciones::select('seccion','texto')->where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->get();
    //         $encuesta['opciones'] = Opcion::select('pregunta','opcion')->where('encuesta',$comprobar['id'])->get();
    //         try {
    //             $encuesta['instrucciones'] = pagina_instruccion::select('instrucciones')->where('encuesta',$comprobar['id'])->firstOrFail();
    //         } catch (\Throwable $th) {
    //             $encuesta['instrucciones'] = 0;
    //         }
            
    //         $encuesta['nivel'] = Nivel::select('nivel')->get();
    //         $encuesta['area'] = Area::select('area')->get();
    //         // return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));

    //         if (empty($comprobar['institucional'])) {
    //             return view('publicacion.encuesta',compact('encuesta'));
    //         }else{
    //             return view('publicacion.encuesta_institucional',compact('encuesta'));
    //         }
    //     }else{

    //     }
    //     // return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));
    // }
}
