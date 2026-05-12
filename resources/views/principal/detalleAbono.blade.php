@extends('layouts.ventas')

@section('contentVenta')

<link rel="stylesheet" href="{{ asset('css/detalle_venta.css') }}">

<div class="container-fluid px-4 py-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <a href="{{ route('deuda.index') }}"
           class="btn btn-outline-light btn-sm">
            ← Volver
        </a>

        <div class="d-flex gap-2">

            <a href="{{ route('venta.show', $deuda->venta_id) }}"
               class="btn btn-outline-gold btn-sm">
                Ver Venta
            </a>

            <a href=""
               target="_blank"
               class="btn btn-outline-gold btn-sm">
                Descargar PDF
            </a>

        </div>

    </div>

    <!-- LOGO -->
    <div class="text-center mb-4">

        <h1 class="gold-title mb-0">
            Perfum Intense
        </h1>

        <span class="color-custom">
            Detalle de Crédito
        </span>

    </div>

    <hr class="line-custom mb-4">

    <!-- TITULO -->
    <div class="mb-4">

        <span class="badge bg-warning text-dark fw-bold">
            Crédito
        </span>

        <h1 class="text-white mt-2">
            {{ $deuda->venta->folio ?? 'Sin folio' }}
        </h1>

        <span class="color-custom">
            {{ $deuda->created_at->format('d M Y H:i') }}
            |
            Registrado por:
            {{ $deuda->usuario->usuario ?? 'N/D' }}
        </span>

    </div>

    <!-- GRID -->
    <div class="row g-4">

        <!-- IZQUIERDA -->
        <div class="col-lg-4">

            <!-- CLIENTE -->
            <div class="card card-custom rounded-4 mb-4">

                <div class="card-body">

                    <h6 class="gold-subtitle mb-3">
                        INFORMACIÓN DEL CLIENTE
                    </h6>

                    <h3 class="text-white">
                        {{ $deuda->cliente->nombre }}
                    </h3>

                    <p class="color-custom mb-2">
                        {{ $deuda->cliente->correo ?? 'Sin correo' }}
                    </p>

                    <small class="text-warning">
                        ● Cliente registrado
                    </small>

                </div>

            </div>

            <!-- ESTADO -->
            <div class="card card-custom rounded-4 mb-4">

                <div class="card-body">

                    <h6 class="gold-subtitle mb-3">
                        ESTADO DEL CRÉDITO
                    </h6>

                    <span class="badge
                        @if($deuda->estatus == 'Pagada')
                            bg-success
                        @else
                            bg-warning text-dark
                        @endif">

                        {{ strtoupper($deuda->estatus) }}

                    </span>

                    <div class="mt-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="color-custom">
                                Progreso
                            </span>

                            <span class="text-white">

                                {{ number_format(
                                    ($deuda->abonado / $deuda->deuda_total) * 100,
                                    0
                                ) }}%

                            </span>

                        </div>

                        <div class="progress" style="height: 8px;">

                            <div class="progress-bar bg-warning"
                                 style="width:
                                 {{ ($deuda->abonado / $deuda->deuda_total) * 100 }}%">
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RESUMEN -->
            <div class="card card-custom rounded-4">

                <div class="card-body">

                    <h6 class="gold-subtitle mb-4">
                        RESUMEN FINANCIERO
                    </h6>

                    <div class="mb-4">

                        <small class="color-custom">
                            DEUDA TOTAL
                        </small>

                        <h3 class="text-white">
                            ${{ number_format($deuda->deuda_total, 2) }}
                        </h3>

                    </div>

                    <div class="mb-4">

                        <small class="color-custom">
                            ABONADO
                        </small>

                        <h4 class="text-success">
                            ${{ number_format($deuda->abonado, 2) }}
                        </h4>

                    </div>

                    <div>

                        <small class="color-custom">
                            RESTANTE
                        </small>

                        <h2 class="text-warning">
                            ${{ number_format($deuda->faltante, 2) }}
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <!-- DERECHA -->
        <div class="col-lg-8">
            <!-- PRODUCTOS -->
            <div class="card card-custom rounded-4 mb-4">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h6 class="gold-subtitle mb-0">
                            ARTÍCULOS DE LA VENTA
                        </h6>
                        <span class="badge bg-secondary">
                            {{ $deuda->venta->articulos }} Items
                        </span>
                    </div>
                    <table class="table table-dark align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Perfume</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deuda->venta->detalles as $detalle)
                                <tr>
                                    <td>
                                        <strong>
                                            {{ $detalle->perfume->nombre }}
                                        </strong>
                                        <br>
                                        <small class="color-custom">
                                            {{ $detalle->perfume->marca->nombre }}
                                            -
                                            {{ $detalle->perfume->concentracion }}
                                            -
                                            {{ $detalle->perfume->contenido }}ml
                                        </small>
                                    </td>
                                    <td>
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td>
                                        ${{ number_format($detalle->precio_unitario,2) }}
                                    </td>
                                    <td class="text-warning fw-bold">
                                        ${{ number_format($detalle->subtotal,2) }}
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($deuda->venta->detallesDecants as $detalle)
                            <tr>
                                <td>
                                    <strong>
                                        Decant
                                        {{ $detalle->decant->perfume->nombre }}
                                    </strong>
                                    <br>
                                    <small class="color-custom">
                                        {{ $detalle->decant->perfume->marca->nombre }}
                                        -
                                        {{ $detalle->decant->perfume->concentracion }}
                                        -
                                        {{ $detalle->ml }}ml
                                    </small>
                                </td>
                                <td>
                                    {{ $detalle->cantidad }}
                                </td>
                                <td>
                                    ${{ number_format($detalle->precio_unitario,2) }}
                                </td>
                                <td class="text-warning fw-bold">
                                    ${{ number_format($detalle->subtotal,2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- HISTORIAL -->
            <div class="card card-custom rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h6 class="gold-subtitle mb-0">
                            HISTORIAL DE ABONOS
                        </h6>

                        <a href="{{ route('abonos.show', $deuda->id) }}" class="btn btn-primary btn-sm">
                            Pagar Deuda
                        </a>

                    </div>

                    @forelse($deuda->abonos as $abono)

                        <div class="border-bottom border-secondary py-3">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <h5 class="text-success mb-1">

                                        +${{ number_format($abono->pago,2) }}

                                    </h5>

                                    <small class="color-custom">

                                        {{ strtoupper($abono->tipo_pago) }}

                                    </small>

                                </div>

                                <div class="text-end">

                                    <small class="color-custom">

                                        {{ $abono->created_at->format('d/m/Y H:i') }}

                                    </small>

                                    <br>

                                    <small class="text-secondary">

                                        {{ $abono->usuario->usuario ?? 'Usuario' }}

                                    </small>

                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-secondary mb-0">
                            No hay abonos registrados
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection