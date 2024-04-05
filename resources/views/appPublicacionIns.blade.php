<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Encuestas</title>

        <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
        <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="{{ asset('css/styleEncuesta.css') }}" rel="stylesheet">
    </head>
    <body>
        @yield('main')
        <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.js"></script>
        <script src="{{ asset('js/customEncuestaIns.js') }}"></script>
    </body>
</html>
