@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Proovedores</h1>
                        <p>Directorio Global de Fabricantes</p>
                    </div>

                    <button class="btn btn-outline-warning btn-lg" data-bs-toggle="modal" data-bs-target="#agregarProovedor">
                        + Agregar Proovedor
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
                                    <form id="filtros" method="GET" action="{{ route('proovedor.index') }}" class="d-flex gap-3 flex-wrap">

                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control search-custom"
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar proovedor..."
                                        />

                                        <a href="{{ route('proovedor.index') }}" class="btn btn-outline-secondary">
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
                    <div id="tabla-proovedores" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Celular</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($proovedores as $proovedor)
                                <tr class="td-custom">
                                    <td>{{ $proovedor->nombre }}</td>
                                    <td>{{ $proovedor->celular }}</td>
                                    <td>{{ $proovedor->correo }}</td>
                                    <td>{{ $proovedor->usuario->usuario ?? 'Sin usuario' }}</td>

                                    <td>
                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $proovedor->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>

                                        
                                        <!-- Modal Para Editar una Marca-->
                                        <div class="modal fade modal-fonts" id="edit{{ $proovedor->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $proovedor->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $proovedor->id }}">
                                                                Editar Proovedor
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
                                                    <form method="POST" action="{{ route('proovedor.update', $proovedor->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Body -->
                                                        <div class="modal-body modal-custom-body">

                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label label-color">Agregar Proovedor</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="nombre"
                                                                    name="nombre"
                                                                    value="{{ $proovedor->nombre }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="celular" class="form-label label-color">Ingresa Celular</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="celular"
                                                                    name="celular"
                                                                    value="{{ $proovedor->celular }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="correo" class="form-label label-color">Ingresa el Correo</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="correo"
                                                                    name="correo"
                                                                    value="{{ $proovedor->correo }}"
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
                                                                    Guardar Proovedor
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>        

                                        <form id="delete-form-{{ $proovedor->id }}" 
                                            action="{{ route('proovedor.destroy', $proovedor->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $proovedor->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $proovedores->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Para Agregar Una nueva Marca-->
        <div class="modal fade modal-fonts" id="agregarProovedor" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar Nuevo Proovedor
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
                    <form method="POST" action="{{ route('proovedor.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label for="nombre" class="form-label label-color">Agregar Proovedor</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="nombre"
                                    name="nombre"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="celular" class="form-label label-color">Numero de Celular1</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="celular"
                                    name="celular"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label label-color">Correo</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="correo"
                                    name="correo"
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
                                    Guardar Proovedor
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
                    'Eliminar Proovedor',
                    '¿Estás seguro de que deseas eliminar este proovedor?',
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

                        const nuevaTabla = doc.querySelector('#tabla-proovedores').innerHTML
                        document.querySelector('#tabla-proovedores').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
        
    @endsection