@extends('appExterna')
@section('main')
<div class="container-fluid">
    <div class="container">
        <table id="reporte" class="table table-striped table-bordered cell-border" style="width:100%;font-size:10px;">
            <thead>                
                <tr>
                    @foreach ($names as $k => $n)
                        <th class='celdaAsignado'>{{$n['texto']}}</th>
                    @endforeach
                </tr>                
            </thead>
            <tbody>
                @foreach ($datos as $d)
                <tr>
                    @foreach ($d as $k => $c)
                        @if (array_key_exists($k,$names))
                            @if ($names[$k]['tipo'] == 4)
                                @if($c == 0)
                                <td></td>
                                @elseif ($c == 1)
                                    <td>Si</td>
                                @elseif ($c== 2)
                                    <td>No</td>
                                @endif
                            @else
                                <td>{{$c}}</td> 
                            @endif
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        
        @if ($resultado)
            <br><br><br>
            <h5>Reporte simplificado</h5>
            <table id="simplificada" class="table table-striped table-bordered cell-border" style="width:100%;font-size:10px;">
                <thead>
                    <tr>
                        @if ($ax)
                            <th>Área</th>
                        @endif
                        @if ($nx)
                            <th>Nivel jerárquico</th>
                        @endif
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                    @php($total = 0)
                    @foreach ($resultado as $r)
                        @php($total += $r->total)
                        <tr>
                            @if ($ax)
                                <td>{{$r->area}}</td>
                                                                                               
                            @endif
                            @if ($nx)
                                <td>{{$r->nivel_jerarquico}}</td>
                            @endif
                            <td>{{$r->total}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        @if ($ax && $nx)
                            <th colspan="2" style="text-align:right">Total:</th>
                        @elseif($ax)
                            <th colspan="1" style="text-align:right">Total:</th>
                        @elseif($nx)
                            <th colspan="1" style="text-align:right">Total:</th>
                        @endif
                        <th>{{$total}}</th>
                    </tr>
                </tfoot>
            </table>
        @endif
        {{-- <table class="table table-striped table-bordered cell-border" style="width:100%;font-size:10px;">
            <thead>
                <tr>
                    @if ($ax)
                        <th rowspan="2">Area</th>
                    @endif
                    @if ($nx)
                        <th rowspan="2">Nivel jerarquico</th>
                    @endif
                    
                    @foreach ($cols as $k => $c)
                        <th colspan="{{count($c['opciones'])}}">{{$c['texto']}}</th>
                    @endforeach
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    @foreach ($cols as $k => $c)
                        @foreach ($c['opciones'] as $o)
                        <th >{{$o}}</th>
                        @endforeach
                    @endforeach 
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table> --}}
    </div>
</div>
@endsection