<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Almacen - Inicio</title>
        <!-- Bootstrap 5 CSS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.css') }}">
            <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.css') }}">
        <script src="{{ asset('alertifyjs/alertify.js') }}"></script>
        <link href="{{ asset('css/buttons.dataTables.css') }}" rel="stylesheet" crossorigin="anonymous">
        <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" crossorigin="anonymous">
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.js') }}"></script>
        <!-- Iconos -->
        <script src="https://kit.fontawesome.com/84a2950b3f.js" crossorigin="anonymous"></script>
        <!-- Pagina cc para el layout -->
        <link rel="stylesheet" href="{{ asset('css/index.css') }}"> 
        <!-- Fonts Family -->
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        
    </head>
    <body class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="d-flex flex-column p-3">
        <h4 class="text-center mb-4"><i class="bi"></i> Mi Panel</h4>

        <ul class="nav nav-pills flex-column mb-auto color-a ">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('marca.index') }}" class="nav-link active"><i class="bi me-2"></i> Marcas</a>
            </li>
            <li>
                <a href="{{ route('perfume.index')}}" class="nav-link"><i class="bi  me-2"></i> Perfumes </a>
            </li>
            <li>
                <a href="{{ route('cliente.index') }}" class="nav-link"><i class="bi  me-2"></i> Clientes </a>
            </li>
            <li>
                <a href="{{ route('proovedor.index')}}" class="nav-link"><i class="bi me-2"></i> Provedores </a>
            </li>
            <li>
                <a href="{{ route('pedidos.index')}}" class="nav-link"><i class="bi me-2"></i> Pedidos </a>
            </li>
            <li>
                <a href="{{ route('usuario.index') }}" class="nav-link"><i class="bi  me-2"></i> Usuarios </a>
            </li>     
            <li>
                <a href="{{ route('inventario.index') }}" class="nav-link"><i class="bi  me-2"></i> Inventario </a>
            </li>   
            <li>
                <a href="{{ route('inventario_decants.index') }}" class="nav-link"><i class="bi  me-2"></i> Inventario Decants </a>
            </li>
            <li>
                <a href="{{ route('venta.index') }}" class="nav-link"><i class="bi  me-2"></i> Ventas </a>
            </li>  
            <li>
                <a href="{{ route('venta.historial') }}" class="nav-link">Historial de Ventas</a>
            </li>
            <li>
                <a href="{{ route('deuda.index') }}" class="nav-link"><i class="bi  me-2"></i> Deuda </a>
            </li>
        </ul>

        <div class="mt-auto text-center">
            <hr class="text-white-50" />
            <p> {{ Auth::user()->name ?? '' }}</p>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
            @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                    {{ __('Log Out') }}
                    </x-dropdown-link>
            </form>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div id="content" class="w-100 position-relative">

        @yield('contentDecants')

    </div>


    </body>
</html>