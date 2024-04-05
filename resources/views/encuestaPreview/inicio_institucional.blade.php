@extends('appPreviewIns')
@section('main')
    <main>
        <div class="container" style="background: whitesmoke;">
            @php
                $doc = new DOMDocument();
                $doc->loadHTML(utf8_decode($pagina['inicio']));
                echo $doc->saveHTML();
            @endphp
        </div>
        
    </main>
@endsection