<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Correo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body style="background: radial-gradient(circle at center, #1A150D, #000000 80%);">

<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">

    <!-- LOGO -->
    <div class="text-center mb-4">
        <h2 style="color:#C5A059; font-weight:bold;">PERFUM INTENSE</h2>
    </div>

    <!-- CARD -->
    <div class="custom-card p-4" style="width: 100%; max-width: 420px;">

        <!-- TEXTO -->
        <div class="text-center mb-4">
            <h4 class="text-warning fw-bold">Verifica tu correo</h4>
            <p class="h3-custom small">
                Antes de comenzar, revisa tu correo y da clic en el enlace de verificación.
                Si no lo recibiste, puedes solicitar otro.
            </p>
        </div>

        <!-- MENSAJE -->
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success text-center py-2">
                Se ha enviado un nuevo enlace de verificación a tu correo.
            </div>
        @endif

        <!-- BOTÓN reenviar -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-gold">
                    Reenviar correo de verificación
                </button>
            </div>
        </form>

        <!-- LOGOUT -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <div class="text-center">
                <button type="submit" class="link-gold small border-0 bg-transparent">
                    Cerrar sesión
                </button>
            </div>
        </form>

    </div>

</div>

</body>
</html>