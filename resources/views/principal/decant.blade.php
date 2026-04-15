@extends('layouts.decats')

@section('contentDecants')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('alertifyjs/css/alertify.css') }}">
    <link rel="stylesheet" href="{{ asset('alertifyjs/css/themes/bootstrap.css') }}">
    <script src="{{ asset('alertifyjs/alertify.js') }}"></script>

    <link href="{{ asset('css/buttons.dataTables.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" crossorigin="anonymous">
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.js') }}"></script>

    <script src="https://kit.fontawesome.com/84a2950b3f.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/decants.css') }}">

    <div class="container-fluid py-4">
        <header class="mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Decants</h1>
                    <p>Administra los decants de la tienda</p>
                </div>
                <a href="{{ route('inventario.index') }}" class="btn btn-outline-warning btn-lg">
                    Regresar a Inventario
                </a>
            </div>
        </header>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="row g-4 mb-4">
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
                                <p class="card-text">Lorem</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">
                                <h6 class="card-title">Special title treatment</h6>
                                <p class="card-text">Lorem</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-12">
                        <div class="card card-custom rounded-4 w-100">
                            <div class="card-body">
                                <form class="d-flex gap-3 w-100 flex-wrap" method="GET" action="">
                                    <input 
                                        class="form-control search-custom flex-grow-1" 
                                        type="search" 
                                        name="search"
                                        style="width: 10rem;"
                                        value=""
                                        placeholder="Buscar..." 
                                    />
                                    <select class="form-select w-auto" name="filter">
                                        <option value="">Filtrar por</option>
                                        <option value="name">Nombre</option>
                                        <option value="date">Fecha</option>
                                        <option value="country">País</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  TABLA -->
                <div class="card card-custom rounded-4  ">
                    <div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom m-0">
                                    <thead>
                                        <tr class="th-custom">
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Stock</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-carrito">
                                        <tr class= "td-custom">

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <form method="POST" action=""> @csrf
                    <div class="card card-custom rounded-4 h-custom-2">
                        <div class="card-body p-4">
                            <p class="card-title-venta">Resumen de Venta</p>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <h6>Artículos</h6>
                                <span class="h6-custom" id="contador2">0</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="h6-custom">Subtotal:</h6>
                                <strong class="h6-custom" id="subtotal_display">$0</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="h6-custom">IVA:</h6>
                                <strong id="iva_display" class="h6-custom">$0</strong>
                            </div>
                        </div>

                        <div class="bloque-total backgroud-custom">
                            <div class="d-flex justify-content-between align-items-center px-4 py-2">
                                <h4 class="h4-custom m-0">Total a Pagar:</h4>
                                <h4 id="total_display" class="h6-custom m-0">$0</h4>
                            </div>
                        </div>

                        <div class="p-4">
                            <p class="mb-3">MÉTODO DE OPERACIÓN</p>  

                            <div class="radio-inputs">
                                <label>
                                    <input class="radio-input" type="radio" name="metodo_pago" value="contado" checked>
                                    <span class="radio-tile">
                                        <span class="radio-icon">
                                            <i class="fa-solid fa-money-bill-1-wave"></i>
                                        </span>
                                        <span class="radio-label">Contado</span>
                                    </span>
                                </label>

                                <label>
                                    <input class="radio-input" type="radio" name="metodo_pago" value="credito">
                                    <span class="radio-tile">
                                        <span class="radio-icon">
                                            <i class="fa-solid fa-credit-card"></i>
                                        </span>
                                        <span class="radio-label">Crédito</span>
                                    </span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <input type="hidden" name="carrito" id="input_carrito">
                                <input type="hidden" name="total" id="input_total">
                                <input type="hidden" name="subtotal" id="input_subtotal">
                                <input type="hidden" name="articulos" id="input_articulos">

                                <button type="submit" class="button w-100 btn-finalizar">
                                    Finalizar venta <i class="fa-solid fa-arrow-right"></i> 
                                </button>  
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> 
    </div> 
@endsection