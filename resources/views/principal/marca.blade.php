@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Marcas</h1>
                        <p>Directorio Global de Fabricantes</p>
                    </div>

                    <button class="btn btn-primary btn-lg">
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
                            <div class="card card-custom rounded-4 h-100">
                                <div class="card-body">
                                    <form class="d-flex d-grid gap-3 w-60" role="search" >
                                        <input class="form-control me-8 search-custom" type="search" placeholder="Buscar por nombre, marca o fecha" aria-label="Search"/>
                                        <select class="form-select w-auto">
                                            <option selected>Filtrar por</option>
                                            <option value="nombre">Nombre</option>
                                            <option value="marca">Marca</option>
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
                                <th>Pais de Origen</th>
                                <th>Fecha de Creación</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                            <tr class="td-custom">
                                <td>Chanel</td>
                                <td>Francia</td>
                                <td>1910</td>
                                <td>admin</td>
                                <td>
                                    <button class="btn btn-outline-gold">
                                        <x-icon name="edit" class="me-1" width="16" height="16"/></button>
                                    <button class="btn btn-outline-gold">
                                        <x-icon name="delete" class="me-1" width="16" height="16"/></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        
        <footer></footer>

    @endsection














