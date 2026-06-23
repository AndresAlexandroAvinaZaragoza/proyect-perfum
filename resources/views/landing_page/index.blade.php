<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PerfumManager</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    </head>

    <body>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
            <div class="container">

                <a class="navbar-brand fw-bold logo" href="#">
                PerfumManager
                </a>

                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Características</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">Planes</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contacto</a>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-gold ms-lg-3">
                        Demo
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <section class="hero">

            <div class="container">

                <div class="row align-items-center min-vh-100">

                    <div class="col-lg-6">

                        <span class="badge-custom">
                            Software para Perfumerías
                        </span>

                        <h1 class="hero-title">
                            Administra tu perfumería
                            <span>
                                como un profesional
                            </span>
                        </h1>

                        <p class="hero-text">
                            PerfumManager es la solución integral para perfumerías y negocios de fragancias. 
                            <br>
                            <br>
                            Administra inventario y decants, registra ventas, controla existencias 
                            en tiempo real, gestiona clientes, genera reportes detallados y supervisa el rendimiento 
                            de tu negocio desde una sola plataforma, diseñada para optimizar tus operaciones y aumentar tus ganancias.
                        </p>

                        <div class="mt-4">
                            <a href="#" class="btn btn-gold btn-lg me-3">
                                Comenzar
                            </a>

                            <a href="#" class="btn btn-outline-light btn-lg">
                                Ver Demo
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 text-center">
                        <img
                            src="https://images.unsplash.com/photo-1541643600914-78b084683601"
                            class="img-fluid dashboard-image"
                            alt="Dashboard"
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="section-dark">

            <div class="container">

                <div class="text-center mb-5">
                <h2>Todo lo que necesitas</h2>
                <p>Diseñado para perfumerías y tiendas nicho.</p>
                </div>

                <div class="row g-4">

                <div class="col-md-4">
                <div class="feature-card">
                <h4>Inventario Inteligente</h4>
                <p>
                Control total de stock, lotes y existencias.
                </p>
                </div>
                </div>

                <div class="col-md-4">
                <div class="feature-card">
                <h4>Ventas y POS</h4>
                <p>
                Registra ventas rápidamente desde cualquier dispositivo.
                </p>
                </div>
                </div>

                <div class="col-md-4">
                <div class="feature-card">
                <h4>Clientes VIP</h4>
                <p>
                CRM especializado para seguimiento y recompra.
                </p>
                </div>
                </div>

                </div>

            </div>

        </section>

        <!-- Pricing -->
        <section id="pricing" class="pricing">
            <div class="container">

                <div class="text-center mb-5">
                    <h2>Planes</h2>
                    <p>Elige el plan ideal para tu negocio.</p>
                </div>

                <div class="row justify-content-center g-4">
                    
                    <div class="col-lg-4 col-md-6">
                            <div class="pricing-card popular">
                                <div class="plan-name">
                                    Basico
                                </div>
                                <h2 class="price">
                                    $199
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos ilimitados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Respaldo Manuales</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y Caja</span>
                                    </li>   
                                    <li class="list">
                                        ✓ <span>Dashboard Limitado</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Soporte Básico</span>
                                    </li>
                                </ul>
                                <a href="#" class="action">
                                    Comenzar ahora
                                </a>
                            </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                            <div class="pricing-card popular">
                                <div class="popular-badge">
                                    MÁS VENDIDO
                                </div>
                                <div class="plan-name">
                                    Profesional
                                </div>
                                <h2 class="price">
                                    $399
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos ilimitados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y caja</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control de decants</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Reportes avanzados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Respaldo automático</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Soporte prioritario</span>
                                    </li>
                                </ul>
                                <a href="#" class="action">
                                    Comenzar ahora
                                </a>
                            </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                            <div class="pricing-card popular">
                                <div class="plan-name">
                                    Profesional
                                </div>
                                <h2 class="price">
                                    $399
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos ilimitados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y caja</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control de decants</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Reportes avanzados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Respaldo automático</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Soporte prioritario</span>
                                    </li>
                                </ul>
                                <a href="#" class="action">
                                    Comenzar ahora
                                </a>
                            </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- CTA -->
        <section class="cta">

        <div class="container text-center">

        <h2>¿Listo para crecer?</h2>

        <p>
        Empieza hoy y digitaliza tu perfumería.
        </p>

        <a href="#" class="btn btn-gold btn-lg">
        Solicitar Demo
        </a>

        </div>

        </section>

        <!-- Footer -->
        <footer id="contact">

        <div class="container text-center">

        <p>
        © 2026 PerfumManager - Todos los derechos reservados.
        </p>

        </div>

        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>