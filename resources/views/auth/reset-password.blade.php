<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>

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

        <!-- TÍTULO -->
        <div class="text-center mb-4">
            <h4 class="text-warning fw-bold">Nueva contraseña</h4>
            <p class="h3-custom small">
                Ingresa tu nueva contraseña para recuperar tu acceso.
            </p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- TOKEN -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label text-warning">Correo Electrónico</label>
                <input 
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    class="form-control custom-input"
                    required
                >

                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label class="form-label text-warning">Nueva contraseña</label>
                <input 
                    type="password"
                    name="password"
                    class="form-control custom-input"
                    required
                >

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-3">
                <label class="form-label text-warning">Confirmar contraseña</label>
                <input 
                    type="password"
                    name="password_confirmation"
                    class="form-control custom-input"
                    required
                >

                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- BOTÓN -->
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-gold">
                    Restablecer contraseña
                </button>
            </div>

        </form>

        <!-- VOLVER -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="link-gold small">
                ← Volver al inicio de sesión
            </a>
        </div>

    </div>

</div>

</body>
</html>