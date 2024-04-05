<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistema de encuestas</title>

        <link href="https://framework-gb.cdn.gob.mx/gm/v4/css/main.css" rel="stylesheet">
    </head>
    <body>
        @yield('main')
        <script defer src="https://framework-gb.cdn.gob.mx/gm/v4/js/gobmx.js"></script>
    </body>
</html>
