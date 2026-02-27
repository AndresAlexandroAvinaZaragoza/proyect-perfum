<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Perfum Intense</title>

    <link rel="stylesheet" href="{{ asset('css/loginUser.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <main class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5 text-center text-md-start">
                    
                    <header class="mb-4">
                        <img class="img-custom mb-3" src="{{ asset('storage/imageSistem/logo.png') }}" alt="Logo Perfum Intense">
                        <p class="text-white-50 fs-5 mb-0">Sistema Administrativo</p>
                    </header>
                    
                    @yield('user')
                    
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>