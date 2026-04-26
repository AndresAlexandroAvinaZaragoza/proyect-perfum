@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/detalle_venta.css') }}">

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">

        <a href="{{ route('pedidos.detallePedidos') }}" class="btn btn-outline-light btn-sm">
            ← Volver
        </a>

        <div class="text-center">
            <h2 class="titulo">Perfum Intense</h2>
            <small class="subtitulo">Detalle del Pedido</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-gold btn-sm">Imprimir PDF</button>
            <button class="btn btn-warning btn-sm fw-bold">Actualizar Estado</button>
        </div>
    </div>

    <!-- INFO GENERAL -->
    <div class="mb-4">
        <span class="badge bg-warning text-dark mb-2">Detalle de Pedido</span>

        <h2 class="venta-id" style="color: #fff;">
            {{ $pedido->folio }}
        </h2>

        <p class="color-custom">
            {{ $pedido->created_at->format('d M Y H:i') }} |
            Registrado por: {{ $pedido->usuario->name ?? 'N/A' }}
        </p>
    </div>

    <div class="row g-4">

        <!-- IZQUIERDA -->
        <div class="col-lg-4">

            <!-- PROVEEDOR -->
            <div class="card premium-card p-4 mb-4">
                <h6 class="section-title">Información del Proveedor</h6>

                <h4 class="cliente-nombre" style="color: #fff;">
                    {{ $pedido->proovedor->nombre ?? 'Sin proveedor' }}
                </h4>

                <p class="color-custom">
                    {{ $pedido->proovedor->direccion ?? 'Sin dirección' }}
                </p>
            </div>

            <!-- ENVIO -->
            <div class="card premium-card p-4 mb-4">
                <h6 class="section-title">Logística de Envío</h6>

                <p class="color-custom mb-1">Paquetería</p>
                <strong style="color:#fff;">{{ $pedido->paqueteria }}</strong>

                <p class="color-custom mt-3 mb-1">Número de Guía</p>
                <strong style="color:#fff;">{{ $pedido->guia }}</strong>
            </div>

            <!-- ESTADO -->
            <div class="card premium-card p-4">
                <h6 class="section-title">Estado del Pedido</h6>

                <span class="badge 
                    @if($pedido->estado == 'pendiente') bg-warning text-dark
                    @elseif($pedido->estado == 'enviado') bg-info
                    @elseif($pedido->estado == 'entregado') bg-success
                    @elseif($pedido->estado == 'cancelado') bg-danger
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($pedido->estado) }}
                </span>
            </div>

        </div>

        <!-- DERECHA -->
        <div class="col-lg-8">

            <div class="card premium-card p-0">

                <!-- HEADER TABLA -->
                <div class="p-3 border-bottom d-flex justify-content-between">
                    <h6 class="section-title m-0">Detalle de mercancía</h6>

                    <span class="badge bg-dark">
                        {{ count($pedido->detalles) }} productos
                    </span>
                </div>

                <!-- TABLA -->
                <table class="table table-dark m-0 table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio Compra</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $subtotal = 0; @endphp

                        @foreach($pedido->detalles as $detalle)
                            @php
                                $sub = $detalle->cantidad * $detalle->precio_de_compra;
                                $subtotal += $sub;
                            @endphp

                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <div>
                                        <div class="nombre-perfume">
                                            {{ $detalle->perfume->nombre ?? 'Perfume eliminado' }}
                                        </div>
                                        <small class="color-custom">
                                            {{ $detalle->perfume->marca->nombre ?? '' }} -
                                            {{ $detalle->perfume->concentracion ?? '' }}
                                        </small>
                                    </div>
                                </td>

                                <td class="text-center">
                                    {{ $detalle->cantidad }}
                                </td>

                                <td class="text-end">
                                    ${{ number_format($detalle->precio_de_compra,2) }}
                                </td>

                                <td class="text-end text-warning fw-bold">
                                    ${{ number_format($sub,2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- TOTAL -->
                <div class="p-4 border-top total-box">

                    <div class="d-flex justify-content-end">
                        <div style="width: 250px">

                            <div class="d-flex justify-content-between">
                                <span style="color: #fff;">Subtotal</span>
                                <span style="color: #fff;">
                                    ${{ number_format($subtotal,2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span style="color: #fff;">Envío</span>
                                <span style="color: #fff;">
                                    ${{ number_format($pedido->precio_envio,2) }}
                                </span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between total-final">
                                <strong style="color: #fff;">Total</strong>
                                <strong class="text-warning fs-4">
                                    ${{ number_format($subtotal + $pedido->precio_envio,2) }}
                                </strong>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection