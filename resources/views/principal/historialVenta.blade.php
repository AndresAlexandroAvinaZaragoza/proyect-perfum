@extends('layouts.ventas')
    @section('contentVenta')

        @if(session('success'))
            <script>
                alertify.success("{{ session('success') }}");
            </script>
        @endif

        @if(session('error'))
            <script>
                alertify.error("{{ session('error') }}");
            </script>
        @endif

        @if ($errors->any())
            <script>
                alertify.error("{{ $errors->first() }}");
            </script>
        @endif

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
                        <p>
                            Módulo que almacena y muestra el historial de ventas realizadas, facilitando la consulta <br>
                            de transacciones, seguimiento de operaciones y análisis de información comercial.
                        </p>
                    </div>

                    <div class="">
                        <a href="{{ route('venta.index') }}" class="btn btn-outline-warning btn-lg">
                            + Hacer Venta
                        </a>
                    </div>
                </div>
            </header>

            <!-- Buscador -->
            <section>
                <div class="">
                    <div class="row g-4 mb-4">
                        <div class="">
                            <div class="card card-custom rounded-4" style="width: 35rem;">
                                <div class="card-body">
                                    <form id="filtros" method="GET" action="{{ route('venta.historial') }}" class="d-flex gap-3 flex-wrap">

                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control search-custom"
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar en el inventario..."
                                        />

                                        <!-- Tipo de Venta -->
                                        <select class="form-select w-auto auto-submit" name="tipo_venta">
                                            <option value="">Tipo de Venta</option>
                                            <option value="contado" {{ request('tipo_venta') == 'contado' ? 'selected' : '' }}>Contado</option>
                                            <option value="credito" {{ request('tipo_venta') == 'credito' ? 'selected' : '' }}>Crédito</option>
                                        </select>

                                        <!-- Ultimas ventas -->
                                        <select class="form-select w-auto auto-submit" name="rango">
                                                <option value="">Ventas</option>
                                                <option value="ayer" {{ request('rango') == 'ayer' ? 'selected' : '' }}>Ayer</option>
                                                <option value="semana" {{ request('rango') == 'semana' ? 'selected' : '' }}>Últimos 7 días</option>
                                                <option value="mes" {{ request('rango') == 'mes' ? 'selected' : '' }}>Último mes</option>
                                                <option value="6meses" {{ request('rango') == '6meses' ? 'selected' : '' }}>Últimos 6 meses</option>
                                        </select>


                                        <a href="{{ route('venta.historial') }}" class="btn btn-outline-secondary">
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


                <div class="card card-custom rounded-4">
                    <div id="tabla-historialVenta" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class="th-custom"> 
                                <th>Folio</th> 
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
                                    <td>{{ $venta->folio }}</td>
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

                                        <form id="delete-form-{{ $venta->id }}" 
                                            action="{{ route('venta.destroy', $venta->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $venta->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $ventas->withQueryString()->links() }}
                        </div>
                    </div>
                </div>

            </section>

         <script>
            function confirmDelete(id) {
                alertify.confirm(
                    'Eliminar la Venta',
                    '¿Estás seguro de que deseas eliminar esta venta?, se eliminarán también los detalles de la venta y se devolverá el stock de los productos vendidos.',
                    function() {
                        document.getElementById('delete-form-' + id).submit();
                    },
                    function() {
                        alertify.error('Cancelado');
                    }
                );
            }
        </script>

        <script>
            document.querySelectorAll('.auto-submit').forEach(select => {
                select.addEventListener('change', function () {
                    document.getElementById('filtros').submit();
                });
            });
        </script>

        <script>

            let timer;

            document.getElementById('search').addEventListener('input', function(){

                clearTimeout(timer)

                timer = setTimeout(() => {

                    const form = document.getElementById('filtros')
                    const data = new FormData(form)
                    const params = new URLSearchParams(data)

                    fetch(form.action + '?' + params.toString())
                    .then(response => response.text())
                    .then(html => {

                        const parser = new DOMParser()
                        const doc = parser.parseFromString(html, 'text/html')

                        const nuevaTabla = doc.querySelector('#tabla-historialVenta').innerHTML
                        document.querySelector('#tabla-historialVenta').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
    @endsection