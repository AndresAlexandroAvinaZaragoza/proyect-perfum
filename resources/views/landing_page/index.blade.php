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
        <section id="features" class="section-dark" style="padding-top: 80px; padding-bottom: 80px;">
            <div class="container-fluid px-lg-5">

                <div class="text-center mb-5">
                    <h2 style="color: var(--gold);">Todo lo que necesitas</h2>
                    <p>Diseñado para perfumerías y tiendas nicho.</p>
                </div>

                <div class="row align-items-center py-5">

                    <div class="col-lg-8">
                        <img
                            src="{{ asset('storage/imageSistem/modulo_perfume.png') }}"
                            class="dashboard-image"
                            alt="Features">
                    </div>

                    <div class="col-lg-4 text-center">
                        <ul class="feature-list">
                            <li class="feature-item">
                                <h3 class="feature-title">Gestion de Fragancias</h3>
                                <p>Administra de forma sencilla tu catálogo de fragancias. Registra perfumes, asigna marcas, categorías, concentraciones, 
                                    géneros y tipos, además de realizar búsquedas y filtros avanzados para encontrar cualquier producto en segundos.'
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr style="border-color: var(--gold); margin: 60px 0;">

                <div class="row align-items-center">

                    <div class="col-lg-4 text-center">
                        <ul class="feature-list">
                            <li class="feature-item">
                                <h3 class="feature-title">Gestion de Inventario</h3>
                                <p>
                                    Mantén un control preciso de cada producto de tu catálogo. Visualiza existencias, administra precios, 
                                    consulta información detallada y organiza tu inventario con herramientas de búsqueda y filtrado diseñadas para perfumerías.
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-8">
                        <img
                            src="{{ asset('storage/imageSistem/modulo_inventario.png') }}"
                            class="dashboard-image"
                            alt="Features">
                    </div>
                </div>
                
                <hr style="border-color: var(--gold); margin: 60px 0;">
                    
                    <div class="row align-items-center py-5">
                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_proveedores.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Gestion de Proveedores</h3>
                                    <p>
                                        Centraliza toda la información de tus proveedores en un único módulo. Registra datos de contacto, consulta su información 
                                        rápidamente y mantén un control eficiente de las relaciones comerciales para garantizar el abastecimiento de tu perfumería.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">

                    <div class="row align-items-center">

                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Gestion de Pedidos</h3>
                                    <p>
                                        Administra todos tus pedidos desde un solo lugar. Consulta su estado, realiza el 
                                        seguimiento de envíos y mantén un historial completo de las compras realizadas a tus proveedores.
                                    </p>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_pedidos.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">

                    <div class="row align-items-center py-5">
                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_usuarios.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Gestion de Usuarios</h3>
                                    <p>
                                        Organiza y administra el personal de tu negocio desde un único módulo. Gestiona usuarios, 
                                        consulta su información, controla los accesos al sistema y mantén un registro actualizado de cada colaborador.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">
                    
                    <div class="row align-items-center">

                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Gestion para Decants</h3>
                                    <p>
                                        Optimiza la administración de tus decants registrando diferentes capacidades, controlando existencias y estableciendo precios de venta. 
                                        Mantén un catálogo organizado y listo para satisfacer las necesidades de tus clientes.
                                    </p>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_crearDecants.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">

                    <div class="row align-items-center py-5">
                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_venta.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Venta</h3>
                                    <p>
                                        Agiliza el proceso de venta con una interfaz intuitiva que te permite registrar compras, 
                                        calcular totales y mantener un historial completo de todas las operaciones.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">
                    
                    <div class="row align-items-center">
                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Historial de Ventas</h3>
                                    <p>
                                        Registra y administra todas las ventas de tu perfumería de forma rápida y segura. 
                                        Consulta el historial de transacciones, controla los ingresos y brinda una atención más eficiente a tus clientes.
                                    </p>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_historialVenta.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                    </div>

                    <hr style="border-color: var(--gold); margin: 60px 0;">
                    
                    <div class="row align-items-center py-5">
                        <div class="col-lg-8">
                            <img
                                src="{{ asset('storage/imageSistem/modulo_creditos.png') }}"
                                class="dashboard-image"
                                alt="Features">
                        </div>
                        <div class="col-lg-4 text-center">
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <h3 class="feature-title">Creditos Pendientes</h3>
                                    <p>
                                        Optimiza el control de las ventas a crédito con un módulo que permite administrar deudas, registrar abonos, 
                                        consultar saldos pendientes y dar seguimiento al historial de pagos de cada cliente, manteniendo una gestión financiera más organizada.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing -->
        <section id="pricing" class="pricing" style="padding-top: 80px; padding-bottom: 80px;">
            <div class="container">

                <div class="text-center mb-5">
                    <h2 style="color: var(--gold);">Planes</h2>
                    <p>Elige el plan ideal para tu negocio.</p>
                </div>

                <div class="row justify-content-center g-4">
                    
                    <div class="col-lg-4 col-md-6">
                            <div class="pricing-card popular">
                                <div class="plan-name">
                                    Emprendedor
                                </div>
                                <h2 class="price">
                                    $249
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos Limitados (hasta 250 productos)</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y Caja</span>
                                    </li>   
                                    <li class="list">
                                        ✓ <span>Dashboard Limitado</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control del sistema para 1 unico usuario</span>
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
                                    Store Professional
                                </div>
                                <h2 class="price">
                                    $499
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos Limitados (hasta 5000 productos)</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y caja</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Dashboard Completo</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control de decants</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas a crédito</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo de Creditos y Abonos</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo para proveedores</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Apartado para Envios</span>
                                    </li>
                                    <li class="list">   
                                        ✓ <span>Modulo de Clientes</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Reportes</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo de Usuarios</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control del sistema para 4 usuarios (1 Adminstrador y 3 Empleados)</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Soporte Basico</span>
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
                                    Business
                                </div>
                                <h2 class="price">
                                    $699
                                </h2>
                                <p class="price-period">
                                    MXN / mes
                                </p>
                                <ul class="lists">
                                    <li class="list">
                                        ✓ <span>Productos Ilimitados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Gestión de inventario</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas y caja</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Dashboard Estadístico y Perzonalizable </span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control de decants</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Ventas a crédito</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo de Creditos y Abonos</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo para proveedores</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Apartado para Envios</span>
                                    </li>
                                    <li class="list">   
                                        ✓ <span>Modulo de Clientes</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Reportes avanzados</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Modulo de Usuarios</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Control del sistema para 10 usuarios (Hasta 2 Adminstradores, 2 Supervisor y 8 Empleados)</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Soporte Especializado</span>
                                    </li>
                                    <li class="list">
                                        ✓ <span>Sistema Personalizable</span>
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