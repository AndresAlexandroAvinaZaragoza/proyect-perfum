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
                    <div class="card card-deuda card-custom rounded-4"> <!-- tarjeta individual -->
                        
                        <div class=""> <!-- contenido de la tarjeta -->
                            <!-- titulo -->
                            <div class="card-body d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <div>
                                        <h3 class="mb-0">{{ $deuda->cliente->nombre }}</h3>
                                        <p class="card-text color-custom">Estado: {{ $deuda->estatus }}</p>
                                    </div>
                                </div>
                                <span class="badge bg-custom fs-6">{{ $deuda->estatus }}</span>
                            </div>

                            <!-- detalles del crédito -->
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="color-custom">Progreso del Pago</span>
                                    <span class="porcentaje color-porcentaje">0%</span>
                                </div>

                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar"  aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class=" pb-4 d-flex justify-content-between align-items-center">
                                    <span  class="color-custom">Abonado: 
                                    <strong class="strong-custom monto-abonado">${{ number_format($deuda->abonado, 2) }}</strong>    
                                    </span>
                                    
                                    <span class="color-custom">
                                        Total: <strong class="strong-custom monto-total">${{ number_format($deuda->total, 2) }}</strong>
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
                                            {{ optional($deuda->ultimoAbono?->fecha_abono)->format('d/m/Y') ?? 'Sin abonos' }}
                                        </span>
                                        <br>
                                        Registrado por: 
                                        <span class="strong-custom">
                                            {{ $deuda->ultimoAbono->usuario->name ?? 'N/D' }}
                                        </span>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary">Detalles</button>
                                        <button class="btn btn-success">Pagar</button>
                                    </div>
                
                                </div>
                            </div>            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function actualizarPorcentaje() {
                $('.card-deuda').each(function() {
                    const abonado = parseFloat(
                        $(this).find('.monto-abonado').text().replace(/[^0-9.-]+/g, "")
                    ) || 0;

                    const total = parseFloat(
                        $(this).find('.monto-total').text().replace(/[^0-9.-]+/g, "")
                    ) || 0;

                    const porcentaje = total > 0 ? (abonado / total) * 100 : 0;

                    $(this).find('.porcentaje').text(porcentaje.toFixed(2) + '%');
                    $(this).find('.progress-bar')
                        .css('width', porcentaje + '%')
                        .attr('aria-valuenow', porcentaje.toFixed(2));
                });
            }

            $(document).ready(function() {
                actualizarPorcentaje();
            });
        </script>

            
    @endsection