@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/marca.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="container-fluid p-4">

    <!-- TÍTULO -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">

        <!-- IZQUIERDA -->
        <h1 class="mb-0">Dashboard</h1>

        <!-- DERECHA -->
        <div class="d-flex flex-wrap gap-2">

            <button id="exportarBtn" class="btn btn-outline-gold">Exportar</button>

            <a href="{{ route('venta.index') }}" class="btn btn-outline-warning">
                <i class="bi bi-cart"></i> Hacer venta
            </a>

            <a href="{{ route('decant.index') }}" class="btn btn-outline-warning">
                Decants
            </a>

            <a href="{{ route('inventario.index') }}" class="btn btn-outline-warning">
                Inventario
            </a>

            <a href="{{ route('deuda.index') }}" class="btn btn-outline-warning">
                Deudas
            </a>

            <a href="{{ route('pedidos.detallePedidos') }}" class="btn btn-outline-warning">
                Pedidos
            </a>

        </div>

    </div>

    <!-- CARDS -->
    <div class="row g-4 mb-4">

        <!-- Ventas -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">
                    <h6>Pagos del mes</h6>
                    <h3 class="fw-bold text-success">
                        ${{ number_format($metricas->total_ventas_mes) }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Clientes -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">
                    <h6>Clientes activos</h6>
                <h3 class="fw-bold" style="color: #fff;">
                        {{ $metricas->clientes_activos }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Deudas -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">
                    <h6>Deudas pendientes</h6>
                    <h3 class="fw-bold text-danger">
                        ${{ number_format($metricas->deudas_pendientes) }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Stock -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">
                    <h6>Stock crítico</h6>
                    <h3 class="fw-bold text-warning">
                        {{ $metricas->stock_critico }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">

        <!-- VENTAS DEL MES -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">

                    <h6>Ventas del mes</h6>

                    <h2 class="fw-bold text-success">
                        ${{ number_format($ventasMes->total_ingresos) }}
                    </h2>

                    <p class="mb-0">
                        {{ $ventasMes->total_ventas }} ventas registradas
                    </p>

                </div>
            </div>
        </div>

        <!-- RESUMEN SEMANAL -->
        <div class="col-md-3">
            <div class="card card-custom shadow">
                <div class="card-body">

                    <h6>Ventas semanales</h6>

                    <h2 class="fw-bold text-warning">
                        {{ collect($ventasSemanales)->sum('total_ventas') }}
                    </h2>

                    <p class="mb-0">
                        ${{ number_format(collect($ventasSemanales)->sum('total_ingresos')) }}
                        generados esta semana
                    </p>

                </div>
            </div>
        </div>
        @if(auth()->user()->rol == 'admin')
            <div class="col-md-3">
                <div class="card card-custom shadow">
                    <div class="card-body">

                        <h6>Ganancia mensual</h6>

                        <h3 class="fw-bold text-success">
                            ${{ number_format($ganancias->ganancia_real) }}
                        </h3>

                        <p class="mb-0">
                            Ingresos:
                            ${{ number_format($ganancias->ingresos_totales) }}
                        </p>

                        <p class="mb-0">
                            Costos:
                            ${{ number_format($ganancias->costo_total) }}
                        </p>

                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card card-custom shadow">
                    <div class="card-body">
                        <h6>Ganancia semanal</h6>
                        <h3 class="fw-bold text-success">
                            $
                            {{ number_format(
                                collect($gananciasSemanales)
                                ->sum('ganancia_real')
                            ) }}
                        </h3>
                        <p class="mb-0">
                            Ingresos:
                            $
                            {{ number_format(
                                collect($gananciasSemanales)
                                ->sum('ingresos_totales')
                            ) }}
                        </p>
                        <p class="mb-0">
                            Costos:
                            $
                            {{ number_format(
                                collect($gananciasSemanales)
                                ->sum('costos_totales')
                            ) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form method="GET" class="mb-4 d-flex gap-2" style="max-width: 400px;">

        <input type="date" name="inicio" 
            value="{{ request('inicio') }}" 
            class="form-control search-custom">

        <input type="date" name="fin" 
            value="{{ request('fin') }}" 
            class="form-control search-custom">

        <button class="btn btn-primary">Filtrar</button>
    </form>
    

    @php

        // VENTAS
        $fechasVentas = collect($reporteVentas)->pluck('fecha');

        $ingresosVentas = collect($reporteVentas)
            ->pluck('total_ingresos');

        // ABONOS
        $fechasAbonos = collect($reporteAbonos)
            ->pluck('fecha');

        $ingresosAbonos = collect($reporteAbonos)
            ->pluck('total_ingresos');

    @endphp
    
    <div class="row mt-4">

    <!-- IZQUIERDA -->
    <div class="col-md-8">

        <!-- VENTAS -->
        <div class="card card-custom shadow p-3 mb-4"
             style="height: 320px; overflow: hidden;">

            <div class="d-flex justify-content-between align-items-center mb-2">

                <h5 class="mb-0" style="color: #fff;">
                    Ventas semanales
                </h5>

                <span style="color: #516F89; font-size: 13px;">
                    {{ $inicio }} - {{ $fin }}
                </span>

            </div>

            <div style="position: relative; height: 240px;">
                <canvas id="graficaVentas"></canvas>
            </div>

        </div>

        <!--  ABONOS -->
        <div class="card card-custom shadow p-3"
             style="height: 320px; overflow: hidden;">

            <div class="d-flex justify-content-between align-items-center mb-2">

                <h5 class="mb-0" style="color: #fff;">
                    Abonos semanales
                </h5>

                <span style="color: #516F89; font-size: 13px;">
                    {{ $inicio }} - {{ $fin }}
                </span>

            </div>

            <div style="position: relative; height: 240px;">
                <canvas id="graficaAbonos"></canvas>
            </div>

        </div>

    </div>

    <!-- DERECHA -->
    <div class="col-md-4">

        <div class="card card-custom shadow p-3"
             style="height: 660px; overflow-y: auto;">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0" style="color: #fff;">
                    Ventas por usuario
                </h5>

                <span style="color: #516F89; font-size: 13px;">
                    Ranking actual
                </span>

            </div>

            @if(count($ventasUsuarios) > 0)

                <table class="table table-hover table-custom m-0">

                    <thead>

                        <tr class="th-custom">
                            <th>Usuario</th>
                            <th>Ventas</th>
                            <th>Ingresos</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($ventasUsuarios as $v)

                        <tr class="td-custom">

                            <td>
                                {{ $v->usuario }}
                            </td>

                            <td>
                                {{ $v->total_ventas }}
                            </td>

                            <td class="text-success fw-bold">
                                ${{ number_format($v->total_ingresos) }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="text-center mt-4 text-light">
                    No hay ventas para mostrar.
                </p>

            @endif

        </div>

    </div>

</div>

    



</div>
<script>

// VENTAS
const ctxVentas = document.getElementById('graficaVentas');

new Chart(ctxVentas, {

    type: 'line',

    data: {
        labels: @json($fechasVentas),

        datasets: [{
            label: 'Ventas ($)',

            data: @json($ingresosVentas),

            borderColor: '#f9c344',

            backgroundColor: 'rgba(249, 195, 68, 0.15)',

            tension: 0.4,

            fill: true,

            pointBackgroundColor: '#f9c344',

            pointRadius: 4,

            pointHoverRadius: 6
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },

        scales: {
            x: {
                ticks: { color: '#516F89' },
                grid: { color: '#3a3525' }
            },
            y: {
                ticks: { color: '#516F89' },
                grid: { color: '#3a3525' }
            }
        }
    }
});

// ABONOS
const ctxAbonos = document.getElementById('graficaAbonos');

new Chart(ctxAbonos, {

    type: 'line',

    data: {
        labels: @json($fechasAbonos),

        datasets: [{
            label: 'Abonos ($)',

            data: @json($ingresosAbonos),

            borderColor: '#4ade80',

            backgroundColor: 'rgba(74, 222, 128, 0.12)',

            tension: 0.4,

            fill: true,

            pointBackgroundColor: '#4ade80',

            pointRadius: 4,

            pointHoverRadius: 6
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },

        scales: {
            x: {
                ticks: { color: '#516F89' },
                grid: { color: '#3a3525' }
            },
            y: {
                ticks: { color: '#516F89' },
                grid: { color: '#3a3525' }
            }
        }
    }
});

// Funcionalidad de exportar (imprimir)
document.getElementById('exportarBtn').addEventListener('click', function() {
    window.print();
});

</script>

<style>
    @media print {
        /* Ocultar elementos de navegación y botones */
        .btn, 
        form.mb-4,
        button,
        a.btn,
        nav,
        .navbar,
        .sidebar,
        aside {
            display: none !important;
        }

        /* Ocultar header con los botones */
        .d-flex.flex-column.flex-md-row {
            display: none !important;
        }

        /* Ajustar el contenedor principal para máximo ancho */
        .container-fluid {
            padding: 20px !important;
            max-width: 100% !important;
            margin: 0 !important;
        }

        /* Fondo blanco para impresión */
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: white !important;
        }

        /* Estilos de las cards */
        .card {
            box-shadow: none !important;
            page-break-inside: avoid;
            border: 1px solid #ddd !important;
            background-color: white !important;
            margin-bottom: 15px;
        }

        .card-body {
            padding: 12px 15px !important;
            background-color: white !important;
        }

        /* Encabezados */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            page-break-after: avoid;
        }

        h5 {
            color: #333 !important;
            font-size: 14px;
            margin-bottom: 10px;
        }

        h6 {
            color: #666 !important;
            font-size: 12px;
            margin-bottom: 8px;
        }

        h2, h3 {
            color: #333 !important;
        }

        /* Ajustar columnas para mejor distribución */
        .col-md-3, .col-md-4, .col-md-8 {
            page-break-inside: avoid;
        }

        .row {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        /* Gráficos */
        canvas {
            max-height: 250px !important;
            background-color: white !important;
        }

        /* Tablas */
        .table {
            font-size: 11px;
            color: #333;
            background-color: white;
            page-break-inside: avoid;
        }

        .table thead {
            background-color: #f8f9fa !important;
            color: #333 !important;
        }

        .table th,
        .table td {
            color: #333 !important;
            border-color: #ddd !important;
            padding: 8px !important;
        }

        /* Textos */
        p {
            color: #666 !important;
            font-size: 11px;
            margin-bottom: 5px;
        }

        /* Colores de texto visibles */
        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        /* Formularios de filtro */
        form {
            display: none !important;
        }

        /* Espacios */
        .gap-2 {
            gap: 0 !important;
        }

        .gap-3 {
            gap: 0 !important;
        }

        .mb-4 {
            margin-bottom: 15px !important;
        }

        /* Evitar cortes de contenido */
        .card-custom {
            overflow: visible !important;
        }

        /* Ajustar alturas de contenedores */
        .card-custom[style*="height"] {
            height: auto !important;
            max-height: none !important;
        }

        /* Encabezados de secciones */
        .d-flex.justify-content-between.align-items-center {
            page-break-inside: avoid;
            margin-bottom: 10px;
        }

        /* Spans de fechas */
        span {
            color: #666 !important;
            font-size: 11px;
        }
    }
</style>
@endsection