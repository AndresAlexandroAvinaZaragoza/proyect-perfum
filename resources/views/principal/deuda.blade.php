@extends('layouts.app')
    @section('content')
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/deuda.css') }}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <style>
            /* HEADER centrado */
            .header-creditos {
                text-align: center;
                padding: 2rem 0 1.5rem;
            }
            .header-creditos h1 {
                font-size: 2.4rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 0.25rem;
            }
            .header-creditos p {
                color: #8A817C;
                margin: 0;
            }

            /* BUSCADOR full width */
            .buscador-row {
                padding: 0 1.5rem;
            }

            /* GRID 2 columnas que llenan todo */
            .grid-deudas {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.8rem;
                padding: 1.5rem;
            }

            /* Anula el width fijo del CSS original */
            .card-deuda {
                width: 100% !important;
                display: flex;
                flex-direction: column;
            }

            /* ── CORRECCIÓN del bloque-total ─────────────────────────────
               Reemplazamos el posicionamiento absoluto negativo por un
               enfoque flex: el card crece, el bloque-total siempre queda
               pegado al fondo y usa el borde superior + fondo del card.
            ─────────────────────────────────────────────────────────────── */
            .card-deuda .card-content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            /* Neutralizamos los pseudo-elementos del CSS original */
            .bloque-total::before,
            .bloque-total::after {
                display: none !important;
            }

            /* Nuevo bloque-total limpio */
            .bloque-total {
                margin-top: auto;          /* empuja al fondo */
                margin-left: -1rem;        /* cubre el padding del card-body */
                margin-right: -1rem;
                margin-bottom: -1rem;
                padding: 1rem 1.25rem;
                background-color: #171412;
                border-top: 1px solid #ebe7e4;
                border-radius: 0 0 1rem 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: static !important; /* asegura que no herede position:relative issues */
                z-index: auto;
            }

            @media (max-width: 900px) {
                .grid-deudas {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        
        <div class="container-fluid py-4">

            <!-- HEADER centrado -->
            <header class="header-creditos mb-4">
                <h1>Gestion de Creditos</h1>
                <p>Aquí puedes gestionar los créditos y ver el estado de las deudas.</p>
            </header>
        
            <!-- Buscador -->
            <section class="buscador-row mb-4">
                <div class="card card-custom rounded-4">
                    <div class="card-body">
                        <form id="filtros" method="GET" action="{{ route('cliente.index') }}" class="d-flex gap-3 w-100">

                            <input 
                                id="search"
                                class="form-control search-custom flex-grow-1"
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar Clientes..."
                            />

                            <select class="form-select w-auto" name="estatus">
                                <option selected>Filtrar por</option>
                                <option value="todos">Todos los Estados</option>
                                <option value="en_progreso">Progreso de Pago</option>
                                <option value="completado">Credito Completado</option>
                                <option value="atrasado">Atrasado</option>
                            </select>

                            <a href="{{ route('cliente.index') }}" class="btn btn-outline-secondary">
                                Limpiar
                            </a>

                        </form>
                    </div>
                </div>
            </section>

            <!-- GRID DE TARJETAS -->
            <div class="grid-deudas">
                @foreach($deudas as $deuda)
                    @php
                        $totalReal  = $deuda->total > 0 ? $deuda->total : ($deuda->abonado + $deuda->faltante);
                        $porcentaje = $totalReal > 0 ? min(($deuda->abonado / $totalReal) * 100, 100) : 0;
                    @endphp

                    <div class="card card-deuda card-custom rounded-4"
                        data-abonado="{{ $deuda->abonado }}"
                        data-total="{{ $totalReal }}">

                        <!-- Contenido principal -->
                        <div class="card-content">

                            <!-- Cabecera: nombre + badge -->
                            <div class="card-body d-flex justify-content-between align-items-center pb-0">
                                <div>
                                    <h3 class="mb-0">{{ $deuda->cliente->nombre }}</h3>
                                    <p class="card-text color-custom mb-0">{{ \Carbon\Carbon::parse($deuda->created_at)->format('d M Y') }}</p>
                                </div>
                                <span class="badge fs-6 bg-custom bg-custom-{{ $deuda->estatus }}">
                                    {{ ucfirst($deuda->estatus) }}
                                </span>
                            </div>

                            <!-- Cuerpo: progreso, montos, faltante -->
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="color-custom">Progreso del Pago</span>
                                    <span class="porcentaje color-porcentaje">{{ number_format($porcentaje, 0) }}%</span>
                                </div>

                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $porcentaje }}%;"
                                        aria-valuenow="{{ round($porcentaje) }}"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>

                                <div class="pb-4 d-flex justify-content-between align-items-center">
                                    <span class="color-custom">Abonado:
                                        <strong class="strong-custom monto-abonado">${{ number_format($deuda->abonado, 2) }}</strong>
                                    </span>
                                    <span class="color-custom">
                                        Total: <strong class="strong-custom monto-total">${{ number_format($totalReal, 2) }}</strong>
                                    </span>
                                </div>

                                <div class="p-4 rounded border border-secondary">
                                    <p class="p-custom mb-1">MONTO FALTANTE</p>
                                    <p class="mb-0 p-custom-2"><strong>${{ number_format($deuda->faltante, 2) }}</strong></p>
                                </div>

                            </div>

                            <!-- PIE de tarjeta: siempre pegado abajo -->
                            <div class="bloque-total">
                                <div class="color-custom">
                                    Ultimo pago:
                                    <span class="color-custom-2 strong-custom">
                                        {{ optional($deuda->ultimoAbono?->created_at)->format('d/m/Y') ?? 'Sin abonos' }}
                                    </span>
                                    <br>
                                    Registrado por:
                                    <span class="strong-custom">
                                        {{ $deuda->ultimoAbono->usuario->name ?? 'N/D' }}
                                    </span>
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary">Detalles</button>

                                    @if($deuda->estatus === 'Pagada')
                                        <button class="btn btn-success" disabled>Pagar</button>
                                    @else
                                        <a class="btn btn-success" href="{{ route('abonos.show', $deuda->id) }}">Pagar</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
@endsection