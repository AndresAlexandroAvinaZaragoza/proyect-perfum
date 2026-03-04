@extends('layouts.loginUser')

@section('user')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="card shadow-lg custom-card">
    <div class="card-body p-4">
        <h3 class="card-title mb-4 h3-custom">Iniciar sesión</h3>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label text-white-50">Correo electrónico</label>
                <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                    id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-white-50">Contraseña</label>
                <input type="password" class="form-control custom-input @error('password') is-invalid @enderror" 
                    id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label text-white-50" for="remember">
                        Recordarme
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-gold small text-decoration-none">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2">Ingresar al Sistema</button>
        </form>
    </div>
</div>
@endsection`