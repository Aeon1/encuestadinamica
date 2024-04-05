@php
    $nombre = Session::get('nombre');
    $rol = Session::get('rol');
    $solicitudes = Session::get('solicitudes');
@endphp
<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
<aside id="colorlib-aside" role="complementary" class="js-fullheight">
    <nav id="colorlib-main-menu" role="navigation">
        @if ($rol == 1)
            <ul>
                <li class="{{ (request()->is('Dashboard')) ? 'colorlib-active' : '' }}">
                    <a href="{{ $rol ==1 || $rol == 2 ? route('dashboard'):"" }}">Dashboard</a>
                </li>
                <li class="{{ (request()->is('Catalogo/Area')) ? 'colorlib-active' : '' }}">
                    <a href="{{ $rol ==1 || $rol == 2 ? route('cArea'):"" }}">Catálogo Área</a>
                </li>
                <li class="{{ (request()->is('Catalogo/Nivel')) ? 'colorlib-active' : '' }}">
                    <a href="{{ $rol ==1 || $rol == 2 ? route('cNivel'):"" }}">Catálogo Nivel</a>
                </li>
                <li class="{{ (request()->is('Encuesta')) ? 'colorlib-active' : '' }}">
                    <a href="{{ $rol ==1 || $rol == 2 ? route('gEncuesta'):"" }}">Encuestas</a>
                </li>
            </ul>
        @endif
        <ul>
            @if ($rol == 2)
                <li class="{{ (request()->is('Dashboard')) ? 'colorlib-active' : '' }}">
                    <a href="{{ $rol ==1 || $rol == 2 ? route('dashboard'):"" }}">Dashboard</a>
                </li>                
            @endif
            @if ($rol == 3)
                
            @endif
            @if ($rol == 1)
                <li class="{{ (request()->is('Gestion')) ? 'colorlib-active' : '' }}">
                    <a href="{{ route('user.management') }}">Gestión usuarios</a>
                </li>
            @endif
            
            <li><a href="{{ route('signout') }}"><span class="text-danger">Salir</span></a></li>
            
        </ul>
    </nav>
</aside> <!-- END COLORLIB-ASIDE -->
