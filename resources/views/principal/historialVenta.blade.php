@extends('layouts.ventas')
    @section('contentVenta')

         <link rel="stylesheet" href="{{ asset('css/decants.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <header class="mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1>Historial de Ventas</h1>
                        <p>Historial de todas las ventas realizadas</p>
                    </div>

                    <div class="">
                        <a href="{{ route('venta.index') }}" class="btn btn-primary btn-lg">
                            + Hacer Venta
                        </a>
                    </div>
                </div>

                <div class="row g-4 mb-4">  <!-- g-4 agrega espacio -->
                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Total de Marcas</h6>
                                <p class="card-text">Lorem</p>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Nuevas Tiendas</h6>
                                <p class="card-text">Lorem </p>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Special title treatment</h6>
                                <p class="card-text">Lorem </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Buscador -->
            <section>
                <div class="">
                    <div class="row g-4 mb-4">
                        <div class="">
                            <div class="card card-custom rounded-4 h-100">
                                <div class="card-body">
                                    <form id="filtros" method="GET" action="{{ route('venta.index') }}" class="d-flex gap-3 flex-wrap">

                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control search-custom"
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar en el inventario..."
                                        />

                                        <!-- Genero -->
                                        <select class="form-select w-auto auto-submit" name="genero">
                                            <option value="">Genero</option>
                                            <option value="Caballero" {{ request('genero') == 'Caballero' ? 'selected' : '' }}>Caballero</option>
                                            <option value="Dama" {{ request('genero') == 'Dama' ? 'selected' : '' }}>Dama</option>
                                        </select>

                                        <!-- Marca -->
                                        <select class="form-select w-auto auto-submit" name="marca">
                                            <option value="">Marca</option>
                                            @foreach ($marcas as $marca)
                                                <option value="{{ $marca->id }}" {{ request('marca') == $marca->id ? 'selected' : '' }}>
                                                    {{ $marca->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Tipo -->
                                        <select class="form-select w-auto auto-submit" name="tipo">
                                            <option value="">Tipo</option>
                                            <option value="Perfume" {{ request('tipo') == 'Perfume' ? 'selected' : '' }}>Perfume</option>
                                            <option value="Set" {{ request('tipo') == 'Set' ? 'selected' : '' }}>Set</option>
                                            <option value="Body" {{ request('tipo') == 'Body' ? 'selected' : '' }}>Body</option>
                                        </select>

                                        <!-- Concentracion -->
                                        <select class="form-select w-auto auto-submit" name="concentracion">
                                            <option value="">Concentracion</option>
                                            <option value="EDT">EDT</option>
                                            <option value="EDP">EDP</option>
                                            <option value="Parfum">Parfum</option>
                                            <option value="Extrait">Extrait</option>
                                            <option value="Elixir">Elixir</option>
                                        </select>

                                        <!-- Categoria -->
                                        <select class="form-select w-auto auto-submit" name="categoria">
                                            <option value="">Categoria</option>
                                            <option value="Diseñador">Diseñador</option>
                                            <option value="Nicho">Nicho</option>
                                            <option value="Arabe">Arabe</option>
                                        </select>

                                        <a href="{{ route('venta.index') }}" class="btn btn-outline-secondary">
                                            Limpiar
                                        </a>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                
            <section>
                @if(session('success'))
                <script>
                    alertify.success("{{ session('success') }}");
                </script>
                @endif

                <div class="card card-custom rounded-4">
                    <div id="tabla-inventario" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class="th-custom">  
                                <th>CLIENTES</th>
                                <th>ARTICULOS</th>
                                <th>TOTAL</th>
                                <th>PAGO</th>
                                <th>FECHA</th>
                                <th>USUARIOS</th>
                                <th>ACCIONES</th>
                            </tr>
                            @foreach ($ventas as $venta)
                                <tr class="td-custom">
                                    <td>{{ $venta->cliente->nombre }}</td>
                                    <td>{{ $venta->articulos }}</td>
                                    <td>{{ $venta->total }}</td>
                                    <td>{{ $venta->tipo_venta }}</td>
                                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $venta->usuario->usuario }}</td>
                                    <td>
                                        <a href="{{ route('venta.show', $venta->id) }}" 
                                        class="btn btn-outline-warning btn-sm">
                                        Ver Detalles
                                        </a> <!-- Agrega más acciones según sea necesario -->
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>

            </section>
    @endsection