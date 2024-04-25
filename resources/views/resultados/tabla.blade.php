@extends('appExterna')
@section('main')
<div class="container-fluid">
    <div class="container">
        <table id="reporte" class="table table-striped table-bordered cell-border" style="width:100%;font-size:10px;">
            <thead>
                @php
                    $registro = '';
                    $secciones = '';
                    $preguntas = '';
                    $fecha = '';
                    $sn = [];
                    foreach ($names as $key => $columnas) {
                        if ($key == 'registro') {
                            foreach ($columnas as $col) {
                                $registro .="<th class='celdaAsignado' style='vertical-align: middle;' rowspan='2'>$col[texto]</th>";
                            }
                        }elseif($key == 'fecha'){
                        }else{
                            foreach ($columnas as $ks => $col) {
                                if (empty($col['texto'])) {
                                    $secciones .="<th class='celdaAsignado' colspan='".(count($names[$key])-1)."' >$col</th>";
                                }else{
                                    if ($col['tipo'] == 4) {
                                        array_push($sn,$ks);
                                    }
                                    $preguntas .="<td class='celdaAsignado'>$col[texto]</td>";
                                    
                                }
                            }
                        }
                    }
                    echo "<tr> $registro $secciones <th class='celdaAsignado' style='vertical-align: middle;' rowspan='2'>Fecha</th></tr><tr>$preguntas</tr>"
                @endphp
            </thead>
            <tbody>
                
                @foreach ($datos as $collection)                
                    <tr>
                        @foreach ($collection as $k => $c)
                            @if ($k != 'id' && $k != '_token')
                                @if (in_array($k,$sn))
                                    <td data-tableexport-xlsxformatid="49">{{$c == 1?'Si':($c == 2?'No':'Omitida')}}</td>
                                @else
                                    <td data-tableexport-xlsxformatid="49">{{$c}}</td> 
                                @endif
                                
                            @endif
                        @endforeach
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>        
        @if ($ax || $nx && !empty($namesSimply))
            <br><br><br>
            <h5>Reporte simplificado</h5>            
            <table id="simplificadax" class="table table-striped table-bordered cell-border" style="width:100%;font-size:10px;">
                <thead>
                    @php
                    $ht = '';
                    $hs = '';
                    $hp = '';
                    $ho = '';
                    $datox = [];
                    $s = [];
                    foreach ($namesSimply as $key => $value) {
                        foreach ($value as $k => $v) {
                            $o =[];
                            if (!empty($v['opciones'])) {
                                $x = !empty($s[$v['sid']]['cols'])?$s[$v['sid']]['cols']:0;
                                $s[$v['sid']] = ['seccion' => $v['seccion'], 'cols' => $x + count($v['opciones'])];
                                $hp .= "<td class='celdaAsignado' colspan='".count($v['opciones'])."' style='vertical-align: middle;'>$v[texto]</td>";
                                
                                foreach ($v['opciones'] as $val) {
                                    $ho .= "<th style='vertical-align: middle;'>$val</th>";
                                    if ($v['tipo'] == 1) {
                                        $datox[$k][$val] = 0;
                                    }else{
                                        $datox[$k][$val=='Si'?1:($val =='No'?2:($val=='Omitida'?0:$val))] = 0;
                                    }
                                }
                            }else{
                                $ht .= "<th class='celdaAsignado' rowspan=3 style='vertical-align: middle;'>$v[texto]</th>";
                            }
                        }                        
                    }
                    foreach ($s as $vx) {
                        $hs .= "<th class='celdaAsignado' colspan=$vx[cols] style='vertical-align: middle;'>$vx[seccion]</th>";
                    }
                    echo "<tr>$ht $hs</tr>
                    <tr>$hp</tr>
                    <tr>$ho</tr>"
                    @endphp                    
                </thead>
                <tbody>
                    @php
                        $a=[];
                        foreach ($datos as $v) {                      
                            if (!empty($v->area) && !empty($v->nivel_jerarquico)) {
                                if (empty($a[$v->area][$v->nivel_jerarquico])) {
                                    $a[$v->area][$v->nivel_jerarquico] = $datox; 
                                }                                
                                foreach ($v as $key => $value) {
                                    if (!empty($datox[$key])) {
                                        $a[$v->area][$v->nivel_jerarquico][$key][$value] += 1;
                                    }
                                }
                                
                            }elseif(!empty($v->area)) {
                                if (empty($a[$v->area])) {
                                    $a[$v->area] = $datox; 
                                }
                                foreach ($v as $key => $value) {
                                    if (!empty($datox[$key])) {
                                        $a[$v->area][$key][$value] += 1;
                                    }
                                }
                            }elseif(!empty($v->nivel_jerarquico)) {
                                if (empty($a[$v->nivel_jerarquico])) {
                                    $a[$v->nivel_jerarquico] = $datox; 
                                }                                
                                foreach ($v as $key => $value) {
                                    if (!empty($datox[$key])) {
                                        $a[$v->nivel_jerarquico][$key][$value] += 1;
                                    }
                                }  
                            }
                        }
                        // maquetar filas
                        if (!empty($v->area) && !empty($v->nivel_jerarquico)) {
                            foreach ($a as $key => $value) {
                                foreach ($value as $k => $v) {
                                    echo "<tr><td>$key</td>";
                                    echo "<td>$k</td>";
                                    foreach ($v as $vz) {
                                        foreach ($vz as $ve) {
                                            echo "<td data-tableexport-xlsxformatid='49'>$ve</td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                            }
                        }else {
                            foreach ($a as $key => $value) {
                                echo "<tr><td>$key</td>";
                                foreach ($value as $k => $v) {
                                    foreach ($v as $vz) {
                                        echo "<td data-tableexport-xlsxformatid='49'>$vz</td>";
                                    }
                                }
                                echo "</tr>";
                            }
                        }
                        
                    @endphp
                </tbody>
            </table>
        @endif
        
    </div>
</div>
@endsection