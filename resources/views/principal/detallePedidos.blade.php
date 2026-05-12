@extends('layouts.app')
    @section('content')

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

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Pedidos</h1>
                        <p>Administra tus pedidos</p>
                    </div>

                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-warning ">
                        Agregar Pedido
                    </a>
                </div>
            </header>

            <!-- Buscador -->
            <section>
                <div class="">
                    <div class="row g-4 mb-4">
                        <div class="">
                            <div class="card card-custom rounded-4 " style="width: 35rem;">
                                <div class="card-body">
                                    <form class="d-flex d-grid gap-3 w-60" method="GET" action="{{ route('pedidos.detallePedidos') }}" id="filtros">
                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control me-8 search-custom" 
                                            type="search" 
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar marca..." 
                                        />
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
                    <!-- TABLA -->
                <div class="card card-custom rounded-4">
                    <div id="tabla-pedidos" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Folio P.</th>
                                <th>Guia</th>
                                <th>Paqueteria</th>
                                <th>Precio de Envio</th>
                                <th>Total</th>
                                <th>Proveedor</th>
                                <th>Estado</th>
                                <th>Fecha de Creación</th>
                                <th>Ultima Actualizacion</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($pedidos as $pedido)
                                <tr class="td-custom">
                                    <td>{{ $pedido->folio }}</td>
                                    <td>{{ $pedido->guia }}</td>
                                    <td>{{ $pedido->paqueteria }}</td>
                                    <td>${{ $pedido->precio_envio }}</td>
                                    <td>${{ $pedido->total }}</td>
                                    <td>{{ $pedido->proovedor->nombre ?? 'N/A' }}</td>
                                    <td>
                                        @if($pedido->estado == 'pendiente')
                                            <span class="badge" style="background-color: #ffc107; color: #212529;">Pendiente</span>
                                        @elseif($pedido->estado == 'enviado')
                                            <span class="badge" style="background-color: #17a2b8; color: #fff;">Enviado</span>
                                        @elseif($pedido->estado == 'entregado')
                                            <span class="badge" style="background-color: #28a745; color: #fff;">Entregado</span>
                                        @elseif($pedido->estado == 'cancelado')
                                            <span class="badge" style="background-color: #dc3545; color: #fff;">Cancelado</span>
                                        @else
                                            <span class="badge" style="background-color: #6c757d; color: #fff;">{{ ucfirst($pedido->estado) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $pedido->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>

                                        <a href=" {{ route('pedidos.show', $pedido->id) }}" class="btn btn-outline-warning">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-outline-info">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>


                                        <form id="delete-form-{{ $pedido->id }}" 
                                            action="{{ route('pedidos.destroy', $pedido->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $pedido->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $pedidos->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        
         <script>
            function confirmDelete(id) {
                alertify.confirm(
                    'Eliminar el Pedido',
                    '¿Estás seguro de que deseas eliminar este pedido?',
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

                        const nuevaTabla = doc.querySelector('#tabla-pedidos').innerHTML
                        document.querySelector('#tabla-pedidos').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
    @endsection














