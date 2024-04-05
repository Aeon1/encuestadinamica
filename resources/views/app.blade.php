<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistema de encuestas</title>

        <link href="https://framework-gb.cdn.gob.mx/gm/v4/css/main.css" rel="stylesheet">
        <!-- Our Custom CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"/>
    </head>
    <body>
        @include('flash-message')
            <div id="colorlib-page">
                @include('header')            
        
                <div id="colorlib-main">
                    @yield('main')
                </div><!-- END COLORLIB-MAIN -->
            </div><!-- END COLORLIB-PAGE -->



        <script defer src="https://framework-gb.cdn.gob.mx/gm/v4/js/gobmx.js"></script>
        <!-- jQuery CDN -->
        {{-- <script src="{{ asset('js/jquery-3.5.1.js') }}"></script> --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-autocomplete.js') }}"></script>
    </body>
</html>
