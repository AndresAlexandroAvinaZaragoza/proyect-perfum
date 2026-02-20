@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">


        <header class="p-4 container-fluid">
            
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Gestion de Marcas</h1>
                    <p>Directorio Global de Fabricantes</p>
                </div>

                <button class="btn btn-primary btn-lg">
                    + Agregar Marca
                </button>
            </div>
            <div class="row g-4">  <!-- g-4 agrega espacio -->

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

        <section>


        </section>


        <section></section>
        <footer></footer>

    @endsection














