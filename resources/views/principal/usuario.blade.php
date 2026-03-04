@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Administracion Personal</h1>
                        <p>Gestiona los accesos y roles de los usuarios en el sistema de perdumeria</p>
                    </div>

                    @if(auth()->user()->rol === 'admin')
                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            + Agregar Usuario
                        </button>
                    @endif
                </div>




                <div class="row g-4 mb-4">  <!-- g-4 agrega espacio -->
                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Total de Usuarios</h6>
                                <p class="card-text">Lorem</p>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Nuevos Usuarios</h6>
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
                                    <form class="d-flex d-grid gap-3 w-60" role="search" >
                                        <input class="form-control me-8 search-custom" type="search" placeholder="Buscar el usuario por nombre o  correo" aria-label="Search"/>
                                        <select class="form-select w-auto">
                                            <option selected>Filtrar por</option>
                                            <option value="nombre">Nombre</option>
                                            <option value="nombre">Usuario</option>
                                            <option value="correo">Correo</option>
                                            <option value="fecha">Fecha</option>
                                        </select>
                                        <button class="btn btn-sm btn-outline-gold w-25" type="submit">Ordenar A-Z</button>
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
                    <div class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Registro</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($usuarios as $usuario)
                                <tr class="td-custom">
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->created_at }}</td>
                                    <td>
                                        {{$usuario->id}}
                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $usuario->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>
                                        <!-- Modal para editar usuario-->
                                        <div class="modal fade modal-fonts" id="edit{{ $usuario->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $usuario->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $usuario->id }}">
                                                                Registrar Nuevo Usuario
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
                                                    <form method="POST" action="{{ route('usuario.update', $usuario->id) }}" enctype="multipart/form-data" >
                                                        @csrf
                                                        @method('PUT')
                                                        <!-- Body -->
                                                        <div class="modal-body modal-custom-body">

                                                            <div class="mb-3">
                                                                <label for="name" class="form-label label-color">Nombre completo</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="name"
                                                                    name="name"
                                                                    value="{{ $usuario->name }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="usuario" class="form-label label-color">Usuario</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="usuario"
                                                                    name="usuario"
                                                                    value="{{ $usuario->usuario }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="email" class="form-label label-color">Correo electrónico</label>
                                                                <input type="email"
                                                                    class="form-control custom-input"
                                                                    id="email"
                                                                    name="email"
                                                                    value="{{ $usuario->email }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="password" class="form-label label-color">Contraseña</label>
                                                                <input type="password"
                                                                    class="form-control custom-input"
                                                                    id="password"
                                                                    name="password"
                                                                    >
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="password_confirmation" class="form-label label-color">
                                                                    Confirmar contraseña
                                                                </label>
                                                                <input type="password"
                                                                    class="form-control custom-input"
                                                                    id="password_confirmation"
                                                                    name="password_confirmation"
                                                                    >
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="rol" class="form-label label-color">Rol</label>
                                                                <select name="rol"
                                                                        id="rol"
                                                                        class="form-select">
                                                                    <option value="empleado" {{ $usuario->rol == 'empleado' ? 'selected' : '' }}>Empleado</option>
                                                                    <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                                                                </select>
                                                            </div> -

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
                                                                    Guardar Usuario
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <form id="delete-form-{{ $usuario->id }}" 
                                            action="{{ route('usuario.destroy', $usuario->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $usuario->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal Para Agregar Nuevo Usuario-->
        <div class="modal fade modal-fonts" id="staticBackdrop" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar Nuevo Usuario
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
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label for="name" class="form-label label-color">Nombre completo</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="name"
                                    name="name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="usuario" class="form-label label-color">Usuario</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="usuario"
                                    name="usuario"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label label-color">Correo electrónico</label>
                                <input type="email"
                                    class="form-control custom-input"
                                    id="email"
                                    name="email"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label label-color">Contraseña</label>
                                <input type="password"
                                    class="form-control custom-input"
                                    id="password"
                                    name="password"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label label-color">
                                    Confirmar contraseña
                                </label>
                                <input type="password"
                                    class="form-control custom-input"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="rol" class="form-label label-color">Rol</label>
                                <select name="rol"
                                        id="rol"
                                        class="form-select">
                                    <option value="empleado">Empleado</option>
                                    <option value="admin">Administrador</option>
                                </select>
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
                                    Guardar Usuario
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
                    'Eliminar Usuario',
                    '¿Estás seguro de que deseas eliminar este usuario?',
                    function() {
                        document.getElementById('delete-form-' + id).submit();
                    },
                    function() {
                        alertify.error('Cancelado');
                    }
                );
            }
        </script>`  

@endSection





