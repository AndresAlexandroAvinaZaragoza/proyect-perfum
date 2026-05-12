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

            <button class="btn btn-outline-gold">Exportar</button>

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

        <!-- 📈 VENTAS -->
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

        <!-- 💰 ABONOS -->
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

// 📈 VENTAS
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

// 💰 ABONOS
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

</script>
@endsection