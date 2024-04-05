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
            foreach ($r as $vr) {
                if ($vr['name'] =='area') {
                    $ax = true;
                }
                if ($vr['name'] =='nivel_jerarquico') {
                    $nx = true;
                }
                $names[$vr['name']] = ['texto'=>$vr['texto'],'tipo' =>'x'];
            }
            
            $p = Pregunta::select('id','pregunta','name','tipo')->where('encuesta',$d['encuesta'])->get();
            // $cols=[];
            foreach ($p as $vp) {
            //     if ($vp['tipo'] == 1){
            //         $opt = Opcion::select('opcion')->where('encuesta',$d['encuesta'])->where('pregunta',$vp['id'])->get();
            //         $g = [];
            //         foreach ($opt as $o) {
            //             array_push($g,$o['opcion']);
            //         }
            //         $cols[$vp['name']] = ['texto' => $vp['pregunta'],'opciones' => $g];
            //     }
            //     if ($vp['tipo'] == 4){
            //         $cols[$vp['name']] = ['texto' => $vp['pregunta'],'opciones' => ['Si','No','Omitida']];
            //     }
                $names[$vp['name']] = ['id'=>$vp['id'],'texto'=>$vp['pregunta'],'tipo' =>$vp['tipo']];
            }
            $resultado = '';
            if ($ax && $nx) {
                $resultado = DB::table($hash)
                ->selectRaw('area,nivel_jerarquico,count(id) as total')
                ->groupBy('area')->groupBy('nivel_jerarquico')
                ->orderBy('area','asc')->get();
            }elseif ($ax) {
                $resultado = DB::table($hash)->selectRaw('area,count(id) as total')
                ->groupBy('area')
                ->orderBy('area','asc')->get();
            }elseif ($nx) {
                $resultado = DB::table($hash)->selectRaw('nivel_jerarquico,count(id) as total')
                ->groupBy('nivel_jerarquico')->orderBy('nivel_jerarquico','asc')->get();
            }

            $names['fecha'] = ['texto' => 'Fecha','tipo' => 'x'];
            $datos = DB::table($hash)->get();
            return view('resultados.tabla', compact('names','datos','resultado','ax','nx'));
        }
    }
}
