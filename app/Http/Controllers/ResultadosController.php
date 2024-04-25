<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\configuracion_encuesta;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\registroForm;
use App\Models\Opcion;
use DB;

class ResultadosController extends Controller
{
    public function obtenerEncuestas(){
        if(Auth::check()){
            $e= configuracion_encuesta::selectRaw('configuracion_encuestas.hash,encuestas.nombre,encuestas.contexto')
            ->leftJoin('encuestas','configuracion_encuestas.encuesta','=', 'encuestas.id')
            ->where('publicada',1)->where('fecha_fin','>',now())->where('estatus',true)->get();
            $f= configuracion_encuesta::selectRaw('configuracion_encuestas.hash,encuestas.nombre,encuestas.contexto')
            ->leftJoin('encuestas','configuracion_encuestas.encuesta','=', 'encuestas.id')
            ->where('publicada',1)->where('fecha_fin','<',now())->where('estatus',true)->get();

            return view('dashboard', compact('e','f'));
        }
        
        return redirect("Login")->with('error','Datos de usuario incorrectos');
    }

    public function obtenerresultados($hash){
        if(Auth::check()){
            // obtener el id de la encuesta
            $d = configuracion_encuesta::select('encuesta')->where('hash',$hash)->firstOrFail();
            // obtener los textos y nombres de las preguntas
            $r = registroForm::select('texto','name')->leftJoin('registro_form_templates','registro_form_templates.id','=','registro_forms.tipo')
            ->where('registro_forms.encuesta',$d['encuesta'])->get();
            $names = [];
            $ax = false;
            $nx = false;
            $namesSimply = [];
            foreach ($r as $vr) {
                if ($vr['name'] =='area') {
                    $ax = true;
                    $namesSimply['header'][$vr['name']] = ['seccion' => '','id'=>'','texto'=>$vr['texto'],'tipo' =>'x'];
                }
                if ($vr['name'] =='nivel_jerarquico') {
                    $nx = true;
                    $namesSimply['header'][$vr['name']] = ['seccion' => '','id'=>'','texto'=>$vr['texto'],'tipo' =>'x'];
                }
                $names['registro'][$vr['name']] = ['texto'=>$vr['texto'],'tipo' =>'x'];
            }
            
            $p = Pregunta::select('preguntas.id','preguntas.pregunta','preguntas.name','tipo','preguntas.seccion','secciones.texto')
            ->selectRaw('secciones.id as seccion_id')
            ->leftJoin('secciones', 'secciones.seccion','=','preguntas.seccion')->where('preguntas.encuesta',$d['encuesta'])->get();
            $pwop = [];
            foreach ($p as $vp) {
                if ($vp['tipo'] == 1) {
                    $opciones = Opcion::selectRaw('GROUP_CONCAT(opcion) as opciones')->where('encuesta',$d['encuesta'])->where('pregunta',$vp['id'])->get();
                    $options = explode(',',$opciones->toArray()[0]['opciones']);
                    $namesSimply['header'][$vp['name']] = ['sid'=> $vp['seccion_id'],'seccion' => $vp['texto'],'id'=>$vp['id'],'texto'=>$vp['pregunta'],'tipo' =>$vp['tipo'],'opciones' =>$options ];
                }elseif ($vp['tipo'] == 4) {
                    $options = ['Si','No','Omitida'];
                    $namesSimply['header'][$vp['name']] = ['sid'=> $vp['seccion_id'],'seccion' => $vp['texto'],'id'=>$vp['id'],'texto'=>$vp['pregunta'],'tipo' =>$vp['tipo'],'opciones' =>$options ];
                }
                $names[$vp['seccion']]['texto'] = "$vp[texto]";
                $names[$vp['seccion']][$vp['name']] = ['id'=>$vp['id'],'texto'=>$vp['pregunta'],'tipo' =>$vp['tipo']];
            }
            $names['fecha'] = ['texto' => 'Fecha','tipo' => 'x'];
            $datos = DB::table($hash)->get();
            return view('resultados.tabla', compact('names','datos','ax','nx','namesSimply'));
        }
    }
}
