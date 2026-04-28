@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/marca.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
      
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
                    <h6>Ventas del mes</h6>
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

    

</div>

@endsection