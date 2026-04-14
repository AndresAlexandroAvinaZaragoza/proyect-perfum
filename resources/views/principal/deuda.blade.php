@extends('layouts.app')
    @section('content')
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/deuda.css') }}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <div class="conteiner-fluid py-4">
            <header class="header mb-4">
                <div class="container">
                    <h1>Gestion de Creditos</h1>
                    <p>Aquí puedes gestionar los créditos y ver el estado de las deudas.</p>
                </div>
            </header> 
        
            <!-- Buscador -->
            <section class="buscador mb-4">
                <div class="">
                    <div class="row g-4 mb-4">
                        <div class="">
                            <div class="card card-search card-custom rounded-4 h-100">
                                <div class="card-body">
                                    <form id="filtros" method="GET" action="{{ route('cliente.index') }}" class="d-flex gap-3 w-60">

                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control search-custom"
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar Clientes..."
                                        />

                                        <select class="form-select w-auto">
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
                        </div>
                    </div>
                </div>
            </section>


            <!-- --- Aquí se mostrarán los créditos y deudas en forma de tarjetas --->

                    <div class="row g-4 p-3 gap-custom"> <!-- div para todas las tarjetas -->
                        @foreach($deudas as $deuda)
                            @php
                                // 1. Calculamos el Total Real sumando lo abonado y lo faltante (por si el total original viene en 0)
                                $totalReal = $deuda->total > 0 ? $deuda->total : ($deuda->abonado + $deuda->faltante);
                                
                                // 2. Calculamos el porcentaje en base a ese Total Real
                                $porcentaje = $totalReal > 0 ? min(($deuda->abonado / $totalReal) * 100, 100) : 0;
                            @endphp
                            <div class="card card-deuda card-custom rounded-4"
                                data-abonado="{{ $deuda->abonado }}"
                                data-total="{{ $totalReal }}"> <!-- tarjeta individual -->
                                
                                <div class=""> <!-- contenido de la tarjeta -->
                                    <!-- titulo -->
                                    <div class="card-body d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <div>
                                                <h3 class="mb-0">{{ $deuda->cliente->nombre }}</h3>
                                                <p class="card-text color-custom">{{ \Carbon\Carbon::parse($deuda->created_at)->format('d M Y') }}</p>
                                            </div>
                                        </div>


                                        <span class="badge fs-6 bg-custom bg-custom-{{ $deuda->estatus }}">
                                            {{ ucfirst($deuda->estatus) }}
                                        </span>
                                    </div>

                                    <!-- detalles del crédito -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="color-custom">Progreso del Pago</span>
                                            <span class="porcentaje color-porcentaje">{{ number_format($porcentaje, 0) }}%</span>
                                        </div>

                                        <div class="progress mb-3" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ round($porcentaje) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class=" pb-4 d-flex justify-content-between align-items-center">
                                            <span  class="color-custom">Abonado: 
                                            <strong class="strong-custom monto-abonado">${{ number_format($deuda->abonado, 2) }}</strong>    
                                            </span>
                                            
                                            <span class="color-custom">
                                                Total: <strong class="strong-custom monto-total">${{ number_format($totalReal, 2) }}</strong>
                                            </span>
                                        </div>

                                        <div class="p-4 rounded border border-secondary d-flex align-items-center justify-content-between">
                                            <div>
                                                <p  class="p-custom">MONTO FALTANTE</p>
                                                <p class="mb-0  p-custom-2"><strong>${{ number_format($deuda->faltante, 2) }}</strong></p>
                                            </div>
                                            <span></span> <!-- espacio para alinear el monto faltante a la derecha -->
                                        </div>
                                        
                                        <div class="bloque-total justify-content-between align-items-center mt-4 d-flex">
                                            <div class="color-custom">
                                                <!-- Aqui traemos los datos de la tabla abonos_registro --> 
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

                                            <div>
                                                <button class="btn btn-primary" oneclick="flipCard()">Detalles</button>

                                                @if($deuda->estatus === 'Pagada')
                                                    <button class="btn btn-success" disabled>Pagar</button>
                                                @else
                                                    <a class="btn btn-success" href="{{ route('abonos.show', $deuda->id) }}">Pagar</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>            
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>    
            </div>        
        </div>
@endsection