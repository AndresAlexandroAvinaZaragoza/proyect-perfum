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
                        <h1>Gestion de Clientes</h1>
                        <p>Directorio Global de Clientes</p>
                    </div>

                    <button class="btn btn-outline-warning btn-lg" data-bs-toggle="modal" data-bs-target="#agregarCliente">
                        + Agregar Cliente
                    </button>
                </div>
            </header>

            <!-- Buscador -->
            <section>
                <div class="">
                    <div class="buscador-row g-4 mb-4">
                        <div class="">
                            <div class="card card-custom rounded-4 h-100" style="width: 35rem;">
                                <div class="card-body">
                                    <form id="filtros" method="GET" action="{{ route('cliente.index') }}" class="d-flex gap-3 flex-wrap">

                                        <!-- Buscador -->
                                        <input 
                                            id="search"
                                            class="form-control search-custom"
                                            type="search"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Buscar Clientes..."
                                        />

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
                
            <section>
                    <!-- TABLA -->
                <div class="card card-custom rounded-4">
                    <div id="tabla-clientes" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Celular</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($clientes as $cliente)
                                <tr class="td-custom">
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->celular }}</td>
                                    <td>{{ $cliente->usuario->usuario ?? 'Sin usuario' }}</td>

                                    <td>
                                        <a href="{{ route('cliente.show', $cliente->id) }}" class="btn btn-outline-success">
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                        </a>

                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $cliente->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>

                                        
                                        <!-- Modal Para Editar una Marca-->
                                        <div class="modal fade modal-fonts" id="edit{{ $cliente->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $cliente->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $cliente->id }}">
                                                                Editar Cliente
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
                                                    <form method="POST" action="{{ route('cliente.update', $cliente->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Body -->
                                                        <div class="modal-body modal-custom-body">

                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label label-color">Agregar Cliente</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="nombre"
                                                                    name="nombre"
                                                                    value="{{ $cliente->nombre }}"
                                                                    maxlength="100"
                                                                    onkeypress="if(this.value.length >= 100) return false;"
                                                                    onpaste="setTimeout(() => this.value = this.value.slice(0,100), 0);"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="celular" class="form-label label-color">Ingresa Celular</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="celular"
                                                                    name="celular"
                                                                    value="{{ $cliente->celular }}"
                                                                    maxlength="15"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    onkeypress="if(this.value.length >= 15) return false;"
                                                                    onpaste="setTimeout(() => this.value = this.value.slice(0,15), 0);"
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
                                                                    Guardar Cliente
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>        

                                        <form id="delete-form-{{ $cliente->id }}" 
                                            action="{{ route('cliente.destroy', $cliente->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $cliente->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $clientes->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Para Agregar Una nueva Marca-->
        <div class="modal fade modal-fonts" id="agregarCliente" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar Nuevo Cliente
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
                    <form method="POST" action="{{ route('cliente.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label for="nombre" class="form-label label-color">Agregar Cliente</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="nombre"
                                    name="nombre"
                                    maxlength="100"
                                    onkeypress="if(this.value.length >= 100) return false;"
                                    onpaste="setTimeout(() => this.value = this.value.slice(0,100), 0);"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="celular" class="form-label label-color">Numero de Celular</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="celular"
                                    name="celular"
                                    maxlength="15"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    onkeypress="if(this.value.length >= 15) return false;"
                                    onpaste="setTimeout(() => this.value = this.value.slice(0,15), 0);"
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
                                    Guardar Cliente
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
                    '¿Estás seguro de que deseas eliminar este cliente?',
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

                        const nuevaTabla = doc.querySelector('#tabla-clientes').innerHTML
                        document.querySelector('#tabla-clientes').innerHTML = nuevaTabla

                        // FIX: Reposiciona modales al body para que DataTables no los destruya
                        document.querySelectorAll('.modal').forEach(modal => {
                            document.body.appendChild(modal);
                        });
                    })
                }, 400)
            })
        </script>

    @endsection