@extends('layouts.decats')

@section('contentDecants')

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

          
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/decants.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <div class="container-fluid py-4">
        <header class="mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Decants</h1>
                    <p>
                        Módulo que permite generar decants a partir de perfumes existentes, administrando las <br>
                        cantidades utilizadas y actualizando automáticamente el inventario correspondiente.
                    </p>
                </div>
                <a href="{{ route('inventario_decants.index') }}" class="btn btn-outline-warning btn-lg">
                    Regresar a Inventario Decants
                </a>
            </div>
        </header>
        <div class="row g-4">   

                <!-- Modal Para Agregar Una nueva Marca-->
                <div class="modal fade modal-fonts" id="agregarBotellaDecant" data-bs-backdrop="static"
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
                                        Complete la información requerida para agregar un nuevo perfume al sistema administrativo de decants
                                    </p>
                                </div>

                                <button type="button"
                                        class="btn-close position-absolute end-0 top-0 m-3"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>

                            <!-- Form -->
                            <form method="POST" action="{{ route('decant.store') }}" class="mi-formulario">
                                @csrf

                                <!-- Body -->
                                <div class="modal-body modal-custom-body">

                                    <div class="mb-3">
                                        <label class="form-label label-color">Perfume</label>
                                        <br>
                                        <div class="position-relative">
                                            <i class="fa-solid fa-spray-can position-absolute"
                                                style="top: 50%; left: 15px; transform: translateY(-50%); color:#c9a646; z-index: 10;">                                            </i>
                                            <select id="inventario_id" name="inventario_id" class="form-control">
                                                    <option value="">Seleccionar perfume</option>
            
                                                    @foreach ($inventarios as $inventario)
                                                        <option 
                                                        value="{{ $inventario->id }}">
                                                        {{ $inventario->perfume->tipo . '-' . $inventario->perfume->nombre . ' - ' . $inventario->perfume->concentracion . ' - ' . $inventario->perfume->contenido . 'ml' . ' - ' . $inventario->perfume->genero }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio_1ml" class="form-label label-color">Precio para 1ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_1ml"
                                                name="precio_1ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>                                       
                                        <div class="mb-3">
                                            <label for="precio_2ml" class="form-label label-color">Precio para 2ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_2ml"
                                                name="precio_2ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio_3ml" class="form-label label-color">Precio para 3ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_3ml"
                                                name="precio_3ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio_5ml" class="form-label label-color">Precio para 5ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_5ml"
                                                name="precio_5ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio_10ml" class="form-label label-color">Precio para 10ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_10ml"
                                                name="precio_10ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="precio_30ml" class="form-label label-color">Precio para 30ml</label>
                                            <input type="number"
                                                class="form-control custom-input"
                                                id="precio_30ml"
                                                name="precio_30ml"
                                                min="1"
                                                max="99999"
                                                required>
                                        </div>
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

                <div class="col-md-8">
                    <div class="row g-4 mb-4 justify-content-start">
                        <div class="col-12">
                            <div class="card card-custom rounded-4 h-100" style="max-width: 35rem; width: 100%;">
                                <div class="card-body">
                                    <form method="GET"
                                        action="{{ route('decant.index') }}"
                                        id="filtros"
                                        class="d-flex gap-3 align-items-center flex-nowrap">

                                        <input type="search"
                                            name="search"
                                            id="search"
                                            value="{{ request('search') }}"
                                            class="form-control search-custom flex-grow-1"
                                            placeholder="Buscar perfume...">

                                        <select name="porcentaje"
                                                class="form-select auto-submit"
                                            style="min-width: 10rem; width: 10rem; flex-shrink: 0;">

                                            <option value="">Todos</option>
                                            <option value="25">0% - 25%</option>
                                            <option value="50">26% - 50%</option>
                                            <option value="75">51% - 75%</option>
                                            <option value="100">76% - 100%</option>

                                        </select>

                                        <button
                                            type="button"
                                            class="btn btn-outline-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#agregarBotellaDecant">
                                            Agregar Perfume
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="card card-custom rounded-4 table-wrapper-decants">
                    <div id="tabla-decants">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom m-0">
                                    <thead>
                                        <tr class="th-custom">
                                            <th>PERFUME</th>
                                            <th>GENERO</th>
                                            <th>VOL.TOTAL</th>
                                            <th class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-carrito">
                                        @foreach ($decants as $decant)
                                            @php
                                                $total = (float) ($decant->perfume->contenido ?? 0);
                                                $restante = (float) ($decant->cantidad_restante ?? 0);

                                                $porcentaje = $total > 0 ? min(max(($restante / $total) * 100, 0), 100) : 0;

                                                if ($porcentaje <= 25) {
                                                    $colorStock = 'bg-danger';
                                                    $textoStock = '#dc3545';
                                                } elseif ($porcentaje <= 50) {
                                                    $colorStock = 'bg-warning';
                                                    $textoStock = '#ffc107';
                                                } elseif ($porcentaje <= 75) {
                                                    $colorStock = 'bg-info';
                                                    $textoStock = '#0dcaf0';
                                                } else {
                                                    $colorStock = 'bg-success';
                                                    $textoStock = '#198754';
                                                }
                                            @endphp
                                            <tr class= "td-custom">
                                                <td>
                                                    <div>
                                                        <h6 class="mb-1" style="color: #fff;">{{ $decant->perfume->nombre }}</h6>
                                                        <span class="small" style="color: #47525E;">{{ $decant->perfume->marca->nombre . ' - ' . $decant->perfume->concentracion }}</span>
                                                    </div>
                                                </td>
                                                <td> {{ $decant->perfume->genero }} </td>
                                                <td>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="fw-semibold" style="color: {{ $textoStock }}; font-size: 12px;">{{ $decant->cantidad_restante }}ml</span>
                                                        <span style="color: #47525E; font-size: 10px;" >{{ $decant->perfume->contenido}}ml</span>
                                                    </div>
                                                    <div class="progress mb-3" style="height: 10px; background-color: #3a3525;">
                                                        <div
                                                            class="progress-bar {{ $colorStock }}" 
                                                            role="progressbar" 
                                                            style="width: {{ $porcentaje }}%; min-width: {{ $porcentaje > 0 ? '8px' : '0' }};" 
                                                            aria-valuenow="{{ round($porcentaje) }}"
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-warning btn-select-perfume" 
                                                        data-id="{{ $decant->id }}"
                                                        data-nombre="{{ $decant->perfume->nombre }}"
                                                        data-marca="{{ $decant->perfume->marca->nombre }}"
                                                        data-stock="{{ $decant->cantidad_restante }}"
                                                        data-total="{{ $decant->perfume->contenido }}"
                                                        type="button">
                                                        <i class="fa-regular fa-square-plus"></i>
                                                    </button>
                                                    <!-- Rellenar Button -->
                                                    @php
                                                        $availableBottles = \App\Models\Inventario::where('perfume_id', $decant->perfume->id)->sum('stock');
                                                    @endphp
                                                    <button class="btn btn-outline-success ms-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rellenar{{ $decant->id }}"
                                                        type="button"
                                                        {{ $availableBottles <= 0 ? 'disabled' : '' }}>
                                                        <i class="fa-solid fa-fill-drip"></i>
                                                    </button>
                                                    <button class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#edit{{ $decant->id }}" type="button">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <!-- Eliminar Botella -->
                                                    <form id="delete-form-{{ $decant->id }}" 
                                                        action="{{ route('decant.destroy', $decant->id) }}" 
                                                        method="POST" 
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        
                                                        <button type="button" 
                                                                class="btn btn-outline-danger"
                                                                onclick="confirmDelete({{ $decant->id }})">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $decants->withQueryString()->links() }}
                        </div>

                        @foreach ($decants as $decant)
                            <!-- Modal Para Editar Una nueva Marca-->
                            <div class="text-start modal fade modal-fonts" id="edit{{ $decant->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="editLabel{{ $decant->id }}" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content mi-modal">

                                        <!-- Header -->
                                        <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                            <div class="w-100">
                                                <h5 class="modal-title mb-1 h5-custom" id="editLabel {{ $decant->id }}">
                                                    Editar Precios del Decant
                                                </h5>
                                                <p class="mb-0 small p-custom">
                                                    Complete la información requerida para actualizar los precios del decant en el sistema administrativo de decants
                                                </p>
                                            </div>

                                            <button type="button"
                                                    class="btn-close position-absolute end-0 top-0 m-3"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        @php
                                            $preciosMap = $decant->precios->keyBy('ml');
                                        @endphp
                                        <!-- Form -->
                                        <form method="POST" action="{{ route('decant.update', $decant->id) }}" class="mi-formulario">
                                            @csrf
                                            @method('PUT')

                                            <!-- Body -->
                                            <div class="modal-body modal-custom-body">

                                                <div class="mb-3">
                                                    <label class="form-label label-color">Perfume</label>
                                                    <br>
                                                    <div class="position-relative">
                                                        <div class="mb-3">
                                                            <label class="form-label label-color">{{ $decant->perfume->nombre ?? 'N/A' }}</label>
                                                        </div>     
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="precio_1ml" class="form-label label-color">Precio para 1ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_1ml"
                                                            name="precio_1ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[1]->precio ?? '' }}"
                                                            required>
                                                    </div>                                       
                                                    <div class="mb-3">
                                                        <label for="precio_2ml" class="form-label label-color">Precio para 2ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_2ml"
                                                            name="precio_2ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[2]->precio ?? '' }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="precio_3ml" class="form-label label-color">Precio para 3ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_3ml"
                                                            name="precio_3ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[3]->precio ?? '' }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="precio_5ml" class="form-label label-color">Precio para 5ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_5ml"
                                                            name="precio_5ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[5]->precio ?? '' }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="precio_10ml" class="form-label label-color">Precio para 10ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_10ml"
                                                            name="precio_10ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[10]->precio ?? '' }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="precio_30ml" class="form-label label-color">Precio para 30ml</label>
                                                        <input type="number"
                                                            class="form-control custom-input"
                                                            id="precio_30ml"
                                                            name="precio_30ml"
                                                            min="1"
                                                            max="99999"
                                                            value="{{ $preciosMap[30]->precio ?? '' }}"
                                                            required>
                                                    </div>
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
                            
                            <!-- Modal Rellenar -->
                            <div class="modal fade modal-fonts" id="rellenar{{ $decant->id }}" tabindex="-1" aria-labelledby="rellenarLabel{{ $decant->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content mi-modal">
                                        <div class="modal-header mi-header-modal position-relative modal-header-footer">
                                            <div class="w-100">
                                                <h5 class="modal-title mb-1 h5-custom" id="rellenarLabel{{ $decant->id }}">Rellenar Decant</h5>
                                                <p class="mb-0 small p-custom">Transferir frascos del inventario al decant (se añadirá el contenido por frasco).</p>
                                            </div>
                                            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('decant.rellenar') }}" method="POST" class="mi-formulario">
                                            @csrf
                                            <input type="hidden" name="decant_id" value="{{ $decant->id }}">
                                            <div class="modal-body modal-custom-body">
                                                @php
                                                    $availableBottles = \App\Models\Inventario::where('perfume_id', $decant->perfume->id)->sum('stock');
                                                @endphp
                                                <p class="small">Perfume: <strong>{{ $decant->perfume->nombre }}</strong></p>
                                                <p class="small">Botes disponibles en inventario: <strong>{{ $availableBottles }}</strong></p>

                                                <div class="mb-3">
                                                    <label for="botellas_{{ $decant->id }}" class="form-label label-color">Cantidad de frascos a usar</label>
                                                    <input type="number" id="botellas_{{ $decant->id }}" name="botellas" min="1" max="{{ $availableBottles }}" value="1" class="form-control" {{ $availableBottles <= 0 ? 'disabled' : '' }} required>
                                                </div>
                                                <p class="small text-muted">Cada frasco contiene <strong>{{ $decant->perfume->contenido }}ml</strong>. Se añadirá esa cantidad por frasco al decant.</p>
                                            </div>
                                            <div class="modal-footer mi-footer-modal modal-header-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success" {{ $availableBottles <= 0 ? 'disabled' : '' }}>Rellenar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <form id="form-crear-decant" action="{{ route('decant.generar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="decant_id" id="input-decant-id" value="">
                
                    <div class="card card-custom rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="m-0" style="color: #fff;">
                                    <i class="fa-regular fa-square-plus text-warning me-2 fs-3"></i>Crear Decant
                                </h5>
                                <span id="display-marca" class="badge border border-warning text-warning px-3 py-2" style="font-size: 10px;"></span>
                            </div>

                            <div class="card card-custom p-3 mb-4" style="background-color: #120F0D;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 id="display-nombre" class="mb-1 text-white">Nombre del perfume</h6>
                                        <p class="mb-0 small" style="font-size: 11px;">
                                            Disponible: <span id="display-stock" class="text-warning">0ml</span> 
                                            <span class="">/ <span id="display-total">0</span>ml</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <p class="small text-uppercase fw-bold mb-3" style="color: #516F89; letter-spacing: 1px; font-size: 10px;">1. Tamaño del Decant</p>
                            <div class="row g-2 mb-2">
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="1" onchange="actualizarCalculos()" checked>
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">1 ml</span>
                                            <small class="radio-sublabel">Muestra</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="2" onchange="actualizarCalculos()">
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">2 ml</span>
                                            <small class="radio-sublabel">Simple</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="3" onchange="actualizarCalculos()">
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">3 ml</span>
                                            <small class="radio-sublabel">Simple</small>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="5" onchange="actualizarCalculos()">
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">5 ml</span>
                                            <small class="radio-sublabel">Basico</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="10" onchange="actualizarCalculos()">
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">10 ml</span>
                                            <small class="radio-sublabel">Estándar</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="w-100">
                                        <input class="radio-input" type="radio" name="tamano_decant" value="30" onchange="actualizarCalculos()">
                                        <span class="radio-tile-size">
                                            <span class="fw-bold">30 ml</span>
                                            <small class="radio-sublabel">Botella</small>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <p class="small text-uppercase fw-bold mb-3" style="color: #516F89; letter-spacing: 1px; font-size: 10px;">2. Cantidad a Generar</p>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="input-group spinner-custom" style="width: 140px;">
                                    <button class="btn btn-outline-secondary border-secondary text-white" 
                                            type="button" 
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown(); actualizarCalculos();">                                    <i class="fa-solid fa-minus"></i>
                                    </button>

                                    <input type="number" 
                                        class="form-control bg-transparent text-white text-center border-secondary no-spinners" 
                                        name="cantidad_generar" 
                                        value="1" 
                                        min="1"
                                        oninput="actualizarCalculos()">

                                    <button class="btn btn-outline-secondary border-secondary text-white" 
                                            type="button" 
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp(); actualizarCalculos();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                                <span class="h4-custom small">unidades</span>
                            </div>

                            <div class="p-3 rounded-4 backgroud-custom" style="border: 1px solid #2D2621;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class=" small" style="color: #fff;">Extracción Total</span>
                                    <span class="text-danger fw-bold" id="resExtraccion">0ml</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="small" style="color: #fff;">Nuevo Stock (Madre)</span>
                                    <span class="text-white fw-bold" id="resNuevoStock">0ml</span>
                                </div>
                                <div class="progress" style="height: 6px; background-color: #3a3525;">
                                    <div class="progress-bar bg-warning" style="width: 0%;" id="barSplit"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1" style="font-size: 10px;">
                                    <span class="h4-custom">Antes: <span id="display-antes">0ml</span></span>
                                    <span class="h4-custom">Después: <span id="display-despues">0ml</span></span>
                                </div>
                            </div>

                            <button class="button w-100 mt-4 py-3" type="submit">
                                <i class="fa-solid fa-download me-2"></i>CONFIRMAR & ACTUALIZAR
                            </button>
                            <p class="text-center mt-3 mb-0" style="font-size: 10px; color: #516F89;">ESTA ACCIÓN NO SE PUEDE DESHACER.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div> 

    <!-- Scrip para rellenar datos del select2 -->
        <script>
        
            $('#inventario_id').select2({
                placeholder: "Buscar perfume...",
                allowClear: true,
                minimumResultsForSearch: 0,
                dropdownParent: $('#agregarBotellaDecant') 
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formCrearDecant = document.getElementById('form-crear-decant');

                if (formCrearDecant) {
                    formCrearDecant.addEventListener('submit', function(event) {
                        const inputDecantId = document.getElementById('input-decant-id');
                        const decantId = inputDecantId ? inputDecantId.value.trim() : '';

                        if (!decantId) {
                            event.preventDefault();

                            if (window.alertify) {
                                alertify.warning('Primero selecciona un perfume de la tabla.');
                            } else {
                                alert('Primero selecciona un perfume de la tabla.');
                            }
                        }
                    });
                }

                document.addEventListener('click', function(event) {
                    const boton = event.target.closest('.btn-select-perfume');

                    if (!boton) {
                        return;
                    }

                    // 1. Obtener datos del botón
                    const nombre = boton.getAttribute('data-nombre');
                    const marca = boton.getAttribute('data-marca');
                    const stock = boton.getAttribute('data-stock');
                    const total = boton.getAttribute('data-total');
                    const idDecant = boton.getAttribute('data-id');

                    document.getElementById('input-decant-id').value = idDecant;

                    // 2. Insertar en el panel derecho
                    document.getElementById('display-nombre').innerText = nombre;
                    document.getElementById('display-marca').innerText = marca.toUpperCase();
                    document.getElementById('display-stock').innerText = stock + 'ml';
                    document.getElementById('display-total').innerText = total;

                    document.getElementById('display-antes').innerText = stock + 'ml'; // Para el pie de la barra
                    actualizarCalculos(); // <--- Llamada clave

                    // 3. Opcional: Reiniciar el spinner de unidades a 1 al cambiar de perfume
                    const inputCant = document.querySelector('input[name="cantidad_generar"]');
                    if (inputCant) inputCant.value = 1;
                });
            });

            function actualizarCalculos() {
                // 1. Obtener valores de los inputs
                const stockActual = parseFloat(document.getElementById('display-stock').innerText);
                const capacidadTotal = parseFloat(document.getElementById('display-total').innerText);
                
                // Buscar el radio seleccionado de tamaño
                const radioSeleccionado = document.querySelector('input[name="tamano_decant"]:checked');
                const tamanoMl = radioSeleccionado ? parseFloat(radioSeleccionado.value) : 0;
                
                // Obtener cantidad del spinner
                const cantidad = parseInt(document.querySelector('input[name="cantidad_generar"]').value) || 0;

                // 2. Realizar cálculos
                const extraccionTotal = tamanoMl * cantidad;
                const nuevoStock = stockActual - extraccionTotal;
                
                // Calcular porcentaje para la barra (basado en la capacidad total de la botella)
                const porcentaje = capacidadTotal > 0 ? (nuevoStock / capacidadTotal) * 100 : 0;

                // 3. Actualizar la interfaz
                document.getElementById('resExtraccion').innerText = `- ${extraccionTotal}ml`;
                document.getElementById('resNuevoStock').innerText = `${nuevoStock}ml`;
                document.getElementById('display-despues').innerText = `${nuevoStock}ml`;

                const barra = document.getElementById('barSplit');
                barra.style.width = `${Math.max(0, porcentaje)}%`;

                // 4. Alerta visual si el stock es insuficiente
                if (nuevoStock < 0) {
                    document.getElementById('resNuevoStock').style.color = '#ff4d4d'; // Rojo
                    barra.classList.replace('bg-warning', 'bg-danger');
                } else {
                    document.getElementById('resNuevoStock').style.color = '#fff';
                    barra.classList.replace('bg-danger', 'bg-warning');
                }
            }
        </script>

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

        <!-- Script para inicializar Select2 en modal de agregar botella decant -->
        <script>
            $(document).ready(function() {
                // Inicializar select2 cuando el modal se abre
                $('#agregarBotellaDecant').on('show.bs.modal', function() {
                    // Destruir si ya existe
                    if ($('#inventario_id').hasClass('select2-hidden-accessible')) {
                        $('#inventario_id').select2('destroy');
                    }
                    
                    // Reinicializar
                    $('#inventario_id').select2({
                        placeholder: "Buscar perfume...",
                        allowClear: true,
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#agregarBotellaDecant').find('.modal-content'),
                        width: '100%'
                    });
                });

                // FIX: Reposicionar modales de editar al body para evitar que se congelen
                $('body').on('show.bs.modal', '.modal', function() {
                    // Si el modal no está ya en el body, reposicionarlo
                    if ($(this).parent().length && !$(this).parent().is('body')) {
                        $(this).appendTo('body');
                    }
                });
            });
        </script>

        <script>

            // =========================
            // FUNCIÓN FILTRAR
            // =========================
            function filtrarDecants() {

                const form = document.getElementById('filtros');

                const data = new FormData(form);

                const params = new URLSearchParams(data);

                fetch(form.action + '?' + params.toString())

                .then(response => response.text())

                .then(html => {

                    const parser = new DOMParser();

                    const doc = parser.parseFromString(html, 'text/html');

                    const nuevaTabla =
                        doc.querySelector('#tabla-decants').innerHTML;

                    document.querySelector('#tabla-decants').innerHTML =
                        nuevaTabla;

                });
            }

            // =========================
            // SEARCH INPUT
            // =========================
            let timer;

            document.getElementById('search')
            .addEventListener('input', function(){

                clearTimeout(timer);

                timer = setTimeout(() => {

                    filtrarDecants();

                }, 400);

            });

            // =========================
            // SELECTS
            // =========================
            document.querySelectorAll('.auto-submit')
            .forEach(select => {

                select.addEventListener('change', function () {

                    filtrarDecants();

                });

            });

        </script>
        
@endsection