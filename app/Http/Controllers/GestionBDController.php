<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\configuracion_encuesta;
use App\Models\RegistroFormTemplate;
use App\Models\registroForm;
use App\Models\Pregunta;
use App\Models\Encuesta;
use App\Models\pagina_inicio;
use App\Models\pagina_instruccion;
use App\Models\pagina_fin;
use App\Models\pagina_cerrada;
use App\Models\Secciones;
use App\Models\Opcion;
use App\Models\Nivel;
use App\Models\Area;
use DB;

class GestionBDController extends Controller
{
    // pruebas
    public function encuestaPruebasContexto($contexto){
        $comprobar = Encuesta::select('id','institucional','estatus')->where('contexto',$contexto)->firstOrFail();
        if (!empty($comprobar['id']) ) {
            $pagina = pagina_inicio::select('encuesta','inicio')->where('encuesta',$comprobar['id'])->firstOrFail();
                if (empty($comprobar['institucional'])) {
                    return view('pruebas.inicio',compact('pagina'));
                }else{
                    return view('pruebas.inicio_institucional',compact('pagina'));
                }
        }else{
            if (!empty($comprobar['institucional'])) {
                return view('pruebas.404ins');
            }else{
                return view('pruebas.404');
            }
            
        }
    }

    public function encuestaPruebasContextoPreguntas($contexto){
        $comprobar = Encuesta::select('id','institucional')->where('contexto',$contexto)->firstOrFail();
        if (!empty($comprobar['id'])) {
            $encuesta['encuesta'] = Encuesta::select('id','nombre')->where('id',$comprobar['id'])->firstOrFail();
            $encuesta['registro'] = registroForm::selectRaw('registro_forms.obligatorio,registro_form_templates.texto,registro_form_templates.campo,registro_form_templates.name')
            ->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
            ->where('encuesta',$comprobar['id'])
            ->get();
            $encuesta['preguntas'] = Pregunta::where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->orderByRaw('CAST(orden as SIGNED INTEGER) asc')->get();
            $encuesta['secciones'] = Secciones::select('seccion','texto')->where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->get();
            $encuesta['opciones'] = Opcion::select('pregunta','opcion')->where('encuesta',$comprobar['id'])->get();
            try {
                $encuesta['instrucciones'] = pagina_instruccion::select('instrucciones')->where('encuesta',$comprobar['id'])->firstOrFail();
            } catch (\Throwable $th) {
                $encuesta['instrucciones'] = 0;
            }
            
            $encuesta['nivel'] = Nivel::select('id','nivel')->get();
            $encuesta['area'] = Area::select('id','area')->get();
            // return view('encuestas.preguntas.gestionPreguntas',compact('encuesta'));

            if (empty($comprobar['institucional'])) {
                return view('pruebas.encuesta',compact('encuesta'));
            }else{
                return view('pruebas.encuesta_institucional',compact('encuesta'));
            }
        }else{

        }
    }

    public function encuestaPruebasContextoFinalizada($contexto){
        $encuesta = Encuesta::select('id','institucional')->where('contexto',$contexto)->firstOrFail();
        // $gt = configuracion_encuesta::select('hash')->where('encuesta', $encuesta->id)->firstOrFail();
        if (!empty($encuesta['id'])) {
            $pagina = pagina_fin::select('encuesta','fin')->where('encuesta',$encuesta['id'])->firstOrFail();
                if (empty($encuesta['institucional'])) {
                    return view('pruebas.fin',compact('pagina'));
                }else{
                    return view('pruebas.fin_institucional',compact('pagina'));
                }
        }else{
            if (!empty($encuesta['institucional'])) {
                return view('pruebas.404ins');
            }else{
                return view('pruebas.404');
            }
            
        }
    }

    public function encuestaPruebasGuardar($contexto,Request $request){
        echo json_encode(['respuesta' => 1]);
    }

    // base de datos (creacion de tablas)
    public function publicar(Request $request){
        if(Auth::check()){
            $datos = $request->all();
            $campos = '';
            // obtener los campos que contendra la tabla
            $tabla = configuracion_encuesta::select('hash','publicada')->where('encuesta',$datos['encuesta'])->firstOrFail();            
            if ($tabla->publicada == 1) {
                    if(DB::statement("DROP TABLE $tabla->hash")){
                        // campos del registro
                        $registro = registroForm::selectRaw("registro_form_templates.name,registro_form_templates.campo")
                            ->leftJoin('registro_form_templates','registro_forms.tipo','=','registro_form_templates.id')
                            ->where('encuesta',$datos['encuesta'])->get();
                        $n = count($registro);
                        $c= 1;
                        foreach ($registro as $r) {
                            if (in_array($r['campo'],[1,3,4,6,7] )) {$campos .= "$r[name] VARCHAR(255) NULL";}
                            if ($r['campo'] == 2) {$campos .= "$r[name] INT(3) NULL";}
                            if ($r['campo'] == 5) {$campos .= "$r[name] TEXT NULL";}
                            $campos .= $n!=$c?',':'';
                            $c++;
                        }
                        $campos .=',';
                        // campos de las preguntas
                        $preguntas = Pregunta::select('tipo','name')->where('encuesta',$datos['encuesta'])->get();
                        $n2 = count($preguntas);
                        $c2 = 1;
                        foreach ($preguntas as $p) {
                            if (in_array($p['tipo'],[1,2] )) {$campos .= "$p[name] VARCHAR(255) NULL";}
                            if ($p['tipo'] == 3) {$campos .= "$p[name] TEXT NULL";}
                            if ($p['tipo'] == 4) {$campos .= "$p[name] INT(1) NOT NULL DEFAULT '0'";}
                            $campos .= $n2!=$c2?',':'';
                            $c2++;
                        }
                        $query = "CREATE TABLE $tabla->hash (id INT NOT NULL AUTO_INCREMENT ,$campos,fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, _token VARCHAR(255) NOT NULL, PRIMARY KEY (id))";
                        if (DB::statement($query)) {
                            $c = configuracion_encuesta::where('encuesta',$datos['encuesta'])
                            ->update([
                                'publicada' => 1
                            ]);
                            return redirect("/Encuesta/Gestion/$datos[encuesta]")->with('success','Se ha publicado correctamente');
                        }else {
                            return "error";
                        }
                    }else{
                        return back()->with('error','Ocurrio un error, intente de nuevo');
                    }            
            }else{
                // campos del registro
                $registro = registroForm::selectRaw("registro_form_templates.name,registro_form_templates.campo")
                    ->leftJoin('registro_form_templates','registro_forms.tipo','=','registro_form_templates.id')
                    ->where('encuesta',$datos['encuesta'])->get();
                $n = count($registro);
                $c= 1;
                foreach ($registro as $r) {
                    if (in_array($r['campo'],[1,3,4,6,7] )) {$campos .= "$r[name] VARCHAR(255) NULL";}
                    if ($r['campo'] == 2) {$campos .= "$r[name] INT(3) NULL";}
                    if ($r['campo'] == 5) {$campos .= "$r[name] TEXT NULL";}
                    $campos .= $n!=$c?',':'';
                    $c++;
                }
                $campos .=',';
                // campos de las preguntas
                $preguntas = Pregunta::select('tipo','name')->where('encuesta',$datos['encuesta'])->get();
                $n2 = count($preguntas);
                $c2 = 1;
                foreach ($preguntas as $p) {
                    if (in_array($p['tipo'],[1,2] )) {$campos .= "$p[name] VARCHAR(255) NULL";}
                    if ($p['tipo'] == 3) {$campos .= "$p[name] TEXT NULL";}
                    if ($p['tipo'] == 4) {$campos .= "$p[name] INT(1) NOT NULL DEFAULT '0'";}
                    $campos .= $n2!=$c2?',':'';
                    $c2++;
                }
                $query = "CREATE TABLE $tabla->hash (id INT NOT NULL AUTO_INCREMENT ,$campos,fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, _token VARCHAR(255) NOT NULL, PRIMARY KEY (id))";
                if (DB::statement($query)) {
                    $c = configuracion_encuesta::where('encuesta',$datos['encuesta'])
                    ->update([
                        'publicada' => 1
                    ]);
                    return redirect("/Encuesta/Gestion/$datos[encuesta]")->with('success','Se ha publicado correctamente');
                }else {
                    return "error";
                }
            }
        }        
        return redirect("Login")->with('error','Debe iniciar sesión para acceder a la sección');
    }

    // publicacion
    public function encuestaContexto($contexto){
        $comprobar = Encuesta::select('id','institucional','estatus')->where('contexto',$contexto)->firstOrFail();
        if (!empty($comprobar['id']) && $comprobar['estatus'] ==1 ) {
            $tabla = configuracion_encuesta::select('hash','publicada','fecha_inicio','fecha_fin')->where('encuesta',$comprobar['id'])->firstOrFail();
            if ($tabla['publicada']) {
                $time = strtotime(date("Y-m-d H:i:s"));
                if ($time > strtotime($tabla['fecha_inicio']) && $time < strtotime($tabla['fecha_fin'])) {
                    $pagina = pagina_inicio::select('encuesta','inicio')->where('encuesta',$comprobar['id'])->firstOrFail();
                    if (empty($comprobar['institucional'])) {
                        return view('publicacion.inicio',compact('pagina'));
                    }else{
                        return view('publicacion.inicio_institucional',compact('pagina'));
                    }
                }else{
                    $con = pagina_cerrada::select('encuesta','cerrada')->where('encuesta',$comprobar['id'])->count();
                    if ($con >= 1) {
                        $pagina = pagina_cerrada::select('encuesta','cerrada')->where('encuesta',$comprobar['id'])->firstOrFail();
                        if (empty($comprobar['institucional'])) {
                            return view('publicacion.cerrada',compact('pagina'));
                        }else{
                            return view('publicacion.cerrada_institucional',compact('pagina'));
                        }
                    }else{
                        if (!empty($comprobar['institucional'])) {
                            return view('publicacion.404ins');
                        }else{
                            return view('publicacion.404');
                        }            
                    }
                    
                }                    
            }else{
                if (!empty($comprobar['institucional'])) {
                    return view('publicacion.404ins');
                }else{
                    return view('publicacion.404');
                } 
            }            
        }else{
            if (!empty($comprobar['institucional'])) {
                return view('publicacion.404ins');
            }else{
                return view('publicacion.404');
            }            
        }
    }

    public function encuestaContextoPreguntas($contexto){
        $comprobar = Encuesta::select('id','institucional','estatus')->where('contexto',$contexto)->firstOrFail();
        if (!empty($comprobar['id']) && $comprobar['estatus'] == 1 ) {
            $tabla = configuracion_encuesta::select('hash','publicada','fecha_inicio','fecha_fin')->where('encuesta',$comprobar['id'])->firstOrFail();
            if ($tabla['publicada']) {
                $time = strtotime(date("Y-m-d H:i:s"));
                if ($time > strtotime($tabla['fecha_inicio']) && $time < strtotime($tabla['fecha_fin'])) {
                    $encuesta['encuesta'] = Encuesta::select('id','nombre')->where('id',$comprobar['id'])->firstOrFail();
                    $encuesta['registro'] = registroForm::selectRaw('registro_forms.obligatorio,registro_form_templates.texto,registro_form_templates.campo,registro_form_templates.name')
                    ->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
                    ->where('encuesta',$comprobar['id'])                    
                    ->get();
                    $encuesta['preguntas'] = Pregunta::where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->orderByRaw('CAST(orden as SIGNED INTEGER) asc')->get();
                    // $encuesta['secciones'] = Pregunta::select('seccion')->where('encuesta',$comprobar['id'])->groupBy('seccion')->orderBy('seccion','asc')->get();
                    $encuesta['secciones'] = Secciones::select('seccion','texto')->where('encuesta', $comprobar['id'])->orderBy('seccion','asc')->get();
                    $encuesta['opciones'] = Opcion::select('pregunta','opcion')->where('encuesta',$comprobar['id'])->get();
                    try {
                        $encuesta['instrucciones'] = pagina_instruccion::select('instrucciones')->where('encuesta',$comprobar['id'])->firstOrFail();
                    } catch (\Throwable $th) {
                        $encuesta['instrucciones'] = 0;
                    }
                    
                    $encuesta['nivel'] = Nivel::select('id','nivel')->get();
                    $encuesta['area'] = Area::select('id','area')->get();

                    if (empty($comprobar['institucional'])) {
                        return view('publicacion.encuesta',compact('encuesta'));
                    }else{
                        return view('publicacion.encuesta_institucional',compact('encuesta'));
                    }
                }else{
                    $pagina = pagina_cerrada::select('encuesta','cerrada')->where('encuesta',$comprobar['id'])->firstOrFail();
                    if (empty($comprobar['institucional'])) {
                        return view('publicacion.cerrada',compact('pagina'));
                    }else{
                        return view('publicacion.cerrada_institucional',compact('pagina'));
                    }
                }
            }else{
                if (!empty($comprobar['institucional'])) {
                    return view('publicacion.404ins');
                }else{
                    return view('publicacion.404');
                } 
            }
        }else{
            if (!empty($comprobar['institucional'])) {
                return view('publicacion.404ins');
            }else{
                return view('publicacion.404');
            } 
        }
    }

    public function encuestaGuardar($contexto,Request $request){
        $encuesta = Encuesta::select('id')->where('contexto',$contexto)->firstOrFail();
        $gt = configuracion_encuesta::select('hash')->where('encuesta', $encuesta->id)->firstOrFail();
        $pr = Pregunta::where('tipo',4)->where('encuesta', $encuesta->id)->get();
        $datos = $request->all();
        foreach ($pr as $value) {
            if(empty($datos[$value['name']])){
                $datos[$value['name']] = 0;
            }
        }
        $query = "insert into $gt->hash (". implode(', ', array_keys($datos)) .") VALUES ('". implode("','" , array_values($datos)) ."')";
        if(DB::statement($query)){
            echo json_encode(['respuesta' => 1]);
        }else{
            echo json_encode(['respuesta' => 2]);
        }
    }

    public function encuestaContextoFinalizada($contexto){
        $encuesta = Encuesta::select('id','institucional')->where('contexto',$contexto)->firstOrFail();
        if (!empty($encuesta['id'])) {
            $tabla = configuracion_encuesta::select('hash','publicada')->where('encuesta',$encuesta['id'])->firstOrFail();
            if ($tabla['publicada']) {
                $pagina = pagina_fin::select('encuesta','fin')->where('encuesta',$encuesta['id'])->firstOrFail();
                if (empty($encuesta['institucional'])) {
                    return view('publicacion.fin',compact('pagina'));
                }else{
                    return view('publicacion.fin_institucional',compact('pagina'));
                }
            }else{
                if (!empty($encuesta['institucional'])) {
                    return view('publicacion.404ins');
                }else{
                    return view('publicacion.404');
                } 
            }
        }else{
            if (!empty($encuesta['institucional'])) {
                return view('publicacion.404ins');
            }else{
                return view('publicacion.404');
            }            
        }
    }
}
