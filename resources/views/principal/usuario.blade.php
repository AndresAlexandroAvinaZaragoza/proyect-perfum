@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Administracion Personal</h1>
                        <p>Gestiona los accesos y roles de los usuarios en el sistema de perdumeria</p>
                    </div>

                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        + Agregar Usuario
                    </button>
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
                                        <button class="btn btn-outline-gold">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>
                                        <button class="btn btn-outline-gold">
                                            <x-icon name="delete" class="me-1" width="16" height="16"/>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </section>
        </div>
            <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>
        <footer></footer>

    @endsection







