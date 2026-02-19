
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Almacen - Inicio</title>
  <!-- Bootstrap 5 CSS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <script src="{{ asset('css/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.css') }}">
	<link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.css') }}">
  <script src="{{ asset('alertifyjs/alertify.js') }}"></script>
  <link href="{{ asset('css/buttons.dataTables.css') }}" rel="stylesheet" crossorigin="anonymous">
  <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" crossorigin="anonymous">
  <script src="{{ asset('js/datatables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.buttons.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}"> 
  
</head>
<body class="d-flex">
  <!-- Sidebar -->
  <nav id="sidebar" class="d-flex flex-column p-3">
    <h4 class="text-center mb-4"><i class="bi"></i> Mi Panel</h4>

    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="#" class="nav-link active"><i class="bi me-2"></i> Inicio</a>
      </li>
      <li>
        <a href="productos.php" class="nav-link"><i class="bi  me-2"></i> Productos</a>
      </li>
      <li>
        <a href="pedidos.php" class="nav-link"><i class="bi  me-2"></i> Pedidos </a>
      </li>
      <li>
        <a href="provedores.php" class="nav-link"><i class="bi me-2"></i> Provedores </a>
      </li>
    
      <li>
        <a href="usuarios.php" class="nav-link"><i class="bi  me-2"></i> Usuarios </a>
      </li>     
      <li>
            <a href="ventas.php" class="nav-link"><i class="bi  me-2"></i> Ventas </a>
      </li>   
    </ul>

    <div class="mt-auto text-center">
      <hr class="text-white-50" />
      <p>Usuario:   </p>
      <a class="nav-link" href="sesion.php">Cerrar sesión</a>
    </div>
  </nav>

  <!-- Contenido principal -->
  <div id="content" class="w-100 position-relative">
    @yield('content')
    <p>Hola</p>

  </div>


</body>
</html>
