@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
        
<!-- jQuery PRIMERO -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Luego Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Inventario</h1>
                        <p>Directorio Global de Fabricantes</p>
                    </div>

                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#dropdownParent">
                        + Agregar Inventario
                    </button>
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
                                    <form id="filtros" method="GET" action="{{ route('perfume.index') }}" class="d-flex gap-3 flex-wrap">

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

                                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
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

                    <!-- TABLA -->
                <div class="card card-custom rounded-4">
                    <div id="tabla-inventario" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Contenido</th>
                                <th>Stock</th>
                                <th>Precio de venta</th>
                                <th>Precio de compra</th>
                                <th>Concentracion</th>
                                <th>Marca</th>
                                <th>Genero</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($inventarios as $inventario)
                                <tr class="td-custom"> 
                                    <td>{{ $inventario->perfume->nombre ?? 'Sin Nombre' }}</td>
                                    <td>{{ $inventario->perfume->contenido ?? 'Sin contenido' }}</td>
                                    <td>{{ $inventario->stock ?? 'Sin stock'}}</td>
                                    <td>{{ $inventario->precio_venta}}</td>
                                    <td>{{ $inventario->precio_compra}}</td>
                                    <td>{{ $inventario->perfume->concentracion ?? 'Sin Nombre' }}</td>
                                    <td>{{ $inventario->perfume->marca->nombre ?? 'Sin marca' }}</td>
                                    <td>{{ $inventario->perfume->genero ?? 'Sin genero' }}</td>
                                    <td>{{ $inventario->perfume->tipo ?? 'Sin tipo' }}</td>
                                    <td>{{ $inventario->perfume->categoria ?? 'Sin categoria' }}</td>
                                    <td>{{ $inventario->usuario->usuario ?? 'Sin usuario' }}</td>
                                    <td>
                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $inventario->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>

                                        
                                        <!-- Modal Para Editar una Marca-->
                                        <div class="modal fade modal-fonts" id="edit{{ $inventario->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $inventario->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $inventario->id }}">
                                                                Editar Inventario
                                                            </h5>
                                                            <p class="mb-0 small p-custom">
                                                                Complete la información requerida para el acceso al sistema administrativo de perfumes
                                                            </p>
                                                        </div>

                                                        <button type="button"
                                                                class="btn-close position-absolute end-0 top-0 m-3"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"></button>

                                                    </div>
                                                    
    
                                                    <!-- Form -->
                                                    <form method="POST" action="{{ route('inventario.update', $inventario->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Body -->
                                                        <div class="modal-body modal-custom-body">
                                                            
                                                        <div class="mb-3">
                                                    
                                                            <label for="perfume_id" class="form-label label-color">Perfume</label>
                                                                <p>
                                                                    {{ $inventario->perfume->nombre ?? 'Sin nombre' }} -
                                                                    {{ $inventario->perfume->concentracion ?? '' }} -
                                                                    {{ $inventario->perfume->contenido ?? '' }}ml -
                                                                    {{ $inventario->perfume->genero ?? '' }}
                                                                </p>                                                            
                                                        </div>
                                                            <!-- 
                                                             {{ $inventario->perfume->genero ?? 'Sin genero' }}           
                                                            <div class="mb-3">
                                                                <label class="form-label label-color">Perfume</label>
                                                                <select id="perfume_id" name="perfume_id" class="form-control">
                                                                    <option value="{{$marca->id}}">Seleccionar perfume</option>

                                                                    @foreach ($perfumes as $perfume)
                                                                        <option 
                                                                        {{ $perfume->nombre . ' - ' . $perfume->concentracion . ' - ' . $perfume->contenido . 'ml' . ' - ' . $perfume->genero }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
-->
                                                            <div class="mb-3">
                                                                <label for="precio_compra" class="form-label label-color">Precio de compra</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="precio_compra"
                                                                    name="precio_compra"
                                                                    value="{{ $inventario->precio_compra }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="precio_venta" class="form-label label-color">Precio de Venta</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="precio_venta"
                                                                    name="precio_venta"
                                                                    value=" {{ $inventario->precio_venta}}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stock" class="form-label label-color">Stock</label>
                                                                <input type="number"
                                                                    class="form-control custom-input"
                                                                    id="stock"
                                                                    name="stock"
                                                                    value="{{ $inventario->stock }}"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <!-- Footer -->
                                                        <div class="modal-footer mi-footer-modal modal-header-footer">                            
                        <!-- 
                                                            <a href="{{ route('login') }}"
                                                            class="text-decoration-none">
                                                                ¿Ya estás registrado?
                                                            </a>
                        -->        
                                                            <div>
                                                                <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    Cancelar
                                                                </button>

                                                                <button type="submit"
                                                                        class="btn btn-primary">
                                                                    Guardar Edicion
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>        
                                        <form id="delete-form-{{ $inventario->id }}" 
                                            action="{{ route('inventario.destroy', $inventario->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $inventario->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $inventarios->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Para Agregar Una nueva Marca-->
        <div class="modal fade modal-fonts" id="dropdownParent" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar Nuevo Producto para el Inventario
                            </h5>
                            <p class="mb-0 small p-custom">
                                Complete la información requerida para el acceso al sistema administrativo de perfumes
                            </p>
                        </div>

                        <button type="button"
                                class="btn-close position-absolute end-0 top-0 m-3"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('inventario.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label>Perfume</label>
                                <select id="perfume_id" name="perfume_id" class="form-control">
                                    <option value="">Seleccionar perfume</option>

                                    @foreach ($perfumes as $perfume)
                                        <option 
                                        value="{{ $perfume->id }}">
                                        {{ $perfume->nombre . ' - ' . $perfume->concentracion . ' - ' . $perfume->contenido . 'ml' . ' - ' . $perfume->genero }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="precio_compra" class="form-label label-color">Precio de compra</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="precio_compra"
                                    name="precio_compra"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="precio_venta" class="form-label label-color">Precio de Venta</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="precio_venta"
                                    name="precio_venta"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label label-color">Stock</label>
                                <input type="number"
                                    class="form-control custom-input"
                                    id="stock"
                                    name="stock"
                                    required>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer mi-footer-modal modal-header-footer">                            
<!-- 
                            <a href="{{ route('login') }}"
                            class="text-decoration-none">
                                ¿Ya estás registrado?
                            </a>
-->
                            <div>
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                    Cancelar
                                </button>

                                <button type="submit"
                                        class="btn btn-primary">
                                    Guardar Perfume
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
         <script>
            function confirmDelete(id) {
                alertify.confirm(
                    'Eliminar Perfume',
                    '¿Estás seguro de que deseas eliminar este perfume?',
                    function() {
                        document.getElementById('delete-form-' + id).submit();
                    },
                    function() {
                        alertify.error('Cancelado');
                    }
                );
            }
        </script>
        <!-- Auto filtrado al seleccionar un selec -->
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

                        const nuevaTabla = doc.querySelector('#tabla-inventario').innerHTML
                        document.querySelector('#tabla-inventario').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
        
        <!-- Scrip para rellenar datos del select2 -->
        <script>
            $('#perfume_select').select2({
                placeholder: "Buscar perfume...",
                allowClear: true,
                minimumResultsForSearch: 0,
                dropdownParent: $('#dropdownParent') 
            });
        </script>
    @endsection