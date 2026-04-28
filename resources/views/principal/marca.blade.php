@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Marcas</h1>
                        <p>Directorio Global de Fabricantes</p>
                    </div>

                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#agregarMarca">
                        + Agregar Marca
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
                            <div class="card card-custom rounded-4 " style="width: 35rem;">
                                <div class="card-body">
                                    <form class="d-flex d-grid gap-3 w-60" method="GET" action="{{ route('marca.index') }}" id="filtros">
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
                    <div id="tabla-marcas" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Pais de Origen</th>
                                <th>Usuario</th>
                                <th>Fecha de Creación</th>
                                <th>Ultima Actualizacion</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($marcas as $marca)
                                <tr class="td-custom">
                                    <td>{{ $marca->nombre }}</td>
                                    <td>{{ $marca->pais_origen }}</td>
                                    <td>{{ $marca->usuario->usuario ?? 'Sin usuario' }}</td>
                                    <td>{{ $marca->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $marca->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>

                                    
                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $marca->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>

                                        
                                        <!-- Modal Para Editar una Marca-->
                                        <div class="modal fade modal-fonts" id="edit{{ $marca->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $marca->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $marca->id }}">
                                                                Registrar una Nueva Marca
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
                                                    <form method="POST" action="{{ route('marca.update', $marca->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Body -->
                                                        <div class="modal-body modal-custom-body">

                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label label-color">Agregar Marca</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="nombre"
                                                                    name="nombre"
                                                                    value="{{ $marca->nombre }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="pais_origen" class="form-label label-color">Pais de Origen</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="pais_origen"
                                                                    name="pais_origen"
                                                                    value="{{ $marca->pais_origen }}"
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
                                                                    Guardar Marca
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>        

                                        <form id="delete-form-{{ $marca->id }}" 
                                            action="{{ route('marca.destroy', $marca->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $marca->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $marcas->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Para Agregar Una nueva Marca-->
        <div class="modal fade modal-fonts" id="agregarMarca" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar una Nueva Marca
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
                    <form method="POST" action="{{ route('marca.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label for="nombre" class="form-label label-color">Agregar Marca</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="nombre"
                                    name="nombre"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="pais_origen" class="form-label label-color">Pais de Origen</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="pais_origen"
                                    name="pais_origen"
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
                                    Guardar Marca
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
                    'Eliminar Marca',
                    '¿Estás seguro de que deseas eliminar esta marca?',
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

                        const nuevaTabla = doc.querySelector('#tabla-marcas').innerHTML
                        document.querySelector('#tabla-marcas').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
    @endsection














