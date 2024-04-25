<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistema de encuestas</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css"> --}}
        {{-- datatables --}}
        <link href="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/cr-2.0.0/r-3.0.1/rg-1.5.0/rr-1.5.0/sc-2.4.1/sp-2.3.0/datatables.min.css" rel="stylesheet">
        {{-- <link href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap4.min.css" rel="stylesheet"> --}}
        {{-- datatables end --}}
        <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css" rel="stylesheet">


        <!-- Our Custom CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/trumbowyg.min.css') }}"/>
        
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    </head>
    <body>
        @include('flash-message')
            <div id="colorlib-page">
                @include('header')            
        
                <div id="colorlib-main">
                    @yield('main')
                </div><!-- END COLORLIB-MAIN -->
            </div><!-- END COLORLIB-PAGE -->


        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
        {{-- datatables --}}
        {{-- <script src="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/cr-2.0.0/r-3.0.1/rg-1.5.0/rr-1.5.0/sc-2.4.1/sp-2.3.0/datatables.min.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap4.js"></script>
        <script src="{{ asset('js/xlsx.core.min.js') }}"></script>
        <script src="{{ asset('js/FileSaver.min.js') }}"></script>        
        <script src="{{ asset('js/tableExport.min.js') }}"></script>
{{-- datatables end --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        {{-- <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-autocomplete.js') }}"></script> --}}
        <script src="{{ asset('js/trumbowyg.min.js') }}"></script>
        <script src="{{ asset('js/langs/es.min.js') }}"></script>
        <script src="{{ asset('js/plugins/resizimg/jquery-resizable.min.js') }}"></script>
        <script src="{{ asset('js/plugins/fontsize/trumbowyg.fontsize.min.js') }}"></script>
        <script src="{{ asset('js/plugins/colors/trumbowyg.colors.min.js') }}"></script>
        <script src="{{ asset('js/plugins/history/trumbowyg.history.min.js') }}"></script>
        <script src="{{ asset('js/plugins/indent/trumbowyg.indent.min.js') }}"></script>
        <script src="{{ asset('js/plugins/lineheight/trumbowyg.lineheight.min.js') }}"></script>
        <script src="{{ asset('js/plugins/resizimg/trumbowyg.resizimg.min.js') }}"></script>
        <script src="{{ asset('js/plugins/boton/trumbowyg.botons.js') }}"></script>
        <script src="{{ asset('js/plugins/upload/trumbowyg.upload.min.js') }}"></script>
        
    </body>
</html>
