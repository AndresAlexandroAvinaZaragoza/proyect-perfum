<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Acceso</title>

    <!-- Bootstrap (si lo usas) -->
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
        <div class="custom-card p-4" style="width: 100%; max-width: 400px;">

            <div class="text-center mb-4">
                <h4 class="text-warning fw-bold">Recuperar Acceso</h4>
                <p class="h3-custom small">
                    ¿Olvidaste tu contraseña? No hay problema. Solo dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.
                </p>
            </div>

            <!-- SESSION -->
            @if (session('status'))
                <div class="alert alert-success text-center py-2">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-warning">Correo Electrónico</label>
                    <input 
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control custom-input"
                        placeholder="tu@email.com"
                        required
                    >

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-gold">
                        Enviar enlace de restablecimiento
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="link-gold small">
                    ← Volver al inicio de sesión
                </a>
            </div>

        </div>

    </div>

</body>
</html>