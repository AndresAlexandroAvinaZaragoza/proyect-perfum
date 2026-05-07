@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/marca.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
            <header class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1>Gestion de Perfume</h1>
                        <p>Directorio Global de Fabricantes</p>
                    </div>

                    <button class="btn btn-outline-warning btn-lg" data-bs-toggle="modal" data-bs-target="#agregarPerfume">
                        + Agregar Fragancia
                    </button>
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
                                            placeholder="Buscar perfume..."
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

                                        <a href="{{ route('perfume.index') }}" class="btn btn-outline-secondary">
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
                    <div id="tabla-perfumes" class="card-body p-0">
                        <table class="table table-hover table-custom m-0 .table-wrapper">
                            <tr class=" th-custom">
                                <th>Nombre</th>
                                <th>Contenido</th>
                                <th>Concentracion</th>
                                <th>Marca</th>
                                <th>Genero</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Usuario</th>
                                <!--
                                <th>Ultima Actualizacion</th>
                                -->
                                <th>Acciones</th>
                            </tr>
                            @foreach ($perfumes as $perfume)
                                <tr class="td-custom">
                                    <td>{{ $perfume->nombre }}</td>
                                    <td>{{ $perfume->contenido }}</td>
                                    <td>{{ $perfume->concentracion }}</td>
                                    <td>{{ $perfume->marca->nombre ?? 'Sin marca' }}</td>
                                    <td>{{ $perfume->genero }}</td>
                                    <td>{{ $perfume->tipo }}</td>
                                    <td>{{ $perfume->categoria }}</td>
                                    <td>{{ $perfume->usuario->usuario ?? 'Sin usuario' }}</td>
                                    <!-- 
                                    <td>{{ $perfume->updated_at->format('d/m/Y H:i') }}</td>
                                    -->
                                    <td>
                                        <button class="btn btn-outline-gold" data-bs-toggle="modal" data-bs-target="#edit{{ $perfume->id }}">
                                            <x-icon name="edit" class="me-1" width="16" height="16"/>
                                        </button>

                                        
                                        <!-- Modal Para Editar una Marca-->
                                        <div class="modal fade modal-fonts" id="edit{{ $perfume->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editLabel{{ $perfume->id }}" aria-hidden="true">

                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content mi-modal">

                                                    <!-- Header -->
                                                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                                                        <div class="w-100">
                                                            <h5 class="modal-title mb-1 h5-custom" id="editLabel{{ $perfume->id }}">
                                                                Editar Perfume
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
                                                    <form method="POST" action="{{ route('perfume.update', $perfume->id) }}" enctype="multipart/form-data">
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
                                                                    value="{{ $perfume->nombre }}"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="contenido" class="form-label label-color">Pais de Origen</label>
                                                                <input type="text"
                                                                    class="form-control custom-input"
                                                                    id="contenido"
                                                                    name="contenido"
                                                                    value="{{ $perfume->contenido }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="marca_id" class="form-label label-color">Selecciona la Marca</label>
                                                                <select name="marca_id" class="form-select">

                                                                @foreach($marcas as $marca)
                                                                    <option value="{{ $marca->id }}"
                                                                        {{ $marca->id == $perfume->marca_id ? 'selected' : '' }}>
                                                                        {{ $marca->nombre }}
                                                                    </option>
                                                                @endforeach
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="concentracion" class="form-label label-color">Selecciona la Concentracion</label>
                                                                <select name="concentracion" class="form-select">
                                                                    <option value="EDT" {{ $perfume->concentracion == 'EDT' ? 'selected' : ''}}>EDT</option>
                                                                    <option value="EDP" {{ $perfume->concentracion == 'EDP' ? 'selected' : ''}}>EDP</option>
                                                                    <option value="Parfum" {{ $perfume->concentracion == 'Parfum' ? 'selected' : ''}}>Parfum</option>
                                                                    <option value="Extrait" {{$perfume->concentracion == 'Extrait' ? 'selected' : ''}}>Extrait</option>
                                                                    <option value="Elixir" {{$perfume->concentracion == 'Elixir' ? 'selected' : ''}}>Elixir</option>
                                                                    <option value="Body Spray" {{ $perfume->concentracion == 'Body Spray' ? 'selected' : ''}}>Body Spray</option>
                                                                    <option value="Body Mist" {{ $perfume->concentracion == 'Body Mist' ? 'selected' : ''}}>Body Mist</option>
                                                                    <option value="Splash" {{ $perfume->concentracion == 'Splash' ? 'selected' : ''}}>Splash</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="genero" class="form-label label-color">Selecciona el Genero</label>
                                                                <select name="genero" class="form-select">
                                                                    <option value="Caballero" {{ $perfume->genero == 'Caballero' ? 'selected' : ''}}>Caballero</option>
                                                                    <option value="Dama" {{ $perfume->genero == 'Dama' ? 'selected' : ''}}>Dama</option>
                                                                    <option value="Unisex" {{ $perfume->genero == 'Unisex' ? 'selected' : ''}}>Unisex</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tipo" class="form-label label-color">Selecciona el Tipo de Fragancia</label>
                                                                <select name="tipo" class="form-select">
                                                                    <option value="Perfume" {{ $perfume->tipo == 'Perfume' ? 'selected' : ''}}>Perfume</option>
                                                                    <option value="Set" {{ $perfume->tipo == 'Set' ? 'selected' : ''}}>Set</option>
                                                                    <option value="Body" {{ $perfume->tipo == 'Body' ? 'selected' : ''}}>Body</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="categoria" class="form-label label-color">Selecciona la Categoria</label>
                                                                <select name="categoria" class="form-select">
                                                                    <option value="Diseñador" {{ $perfume->categoria == 'Diseñador' ? 'selected' : ''}}>Diseñador</option>
                                                                    <option value="Arabe" {{ $perfume->categoria == 'Arabe' ? 'selected' : ''}}>Arabe</option>
                                                                    <option value="Nicho" {{ $perfume->categoria == 'Nicho' ? 'selected' : ''}}>Nicho</option>
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
                                                                    Guardar Marca
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>        

                                        <form id="delete-form-{{ $perfume->id }}" 
                                            action="{{ route('perfume.destroy', $perfume->id) }}" 
                                            method="POST" 
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="confirmDelete({{ $perfume->id }})">
                                                <x-icon name="delete" width="16" height="16"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            {{ $perfumes->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Para Agregar Una nueva Marca-->
        <div class="modal fade modal-fonts" id="agregarPerfume" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content mi-modal">

                    <!-- Header -->
                    <div class="modal-header mi-header-modal position-relative modal-header-footer">

                        <div class="w-100">
                            <h5 class="modal-title mb-1 h5-custom" id="staticBackdropLabel">
                                Registrar Nuevo Producto
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
                    <form method="POST" action="{{ route('perfume.store') }}">
                        @csrf

                        <!-- Body -->
                        <div class="modal-body modal-custom-body">

                            <div class="mb-3">
                                <label for="nombre" class="form-label label-color">Agregar Nombre de la Fragancia</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="nombre"
                                    name="nombre"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="contenido" class="form-label label-color">Cantidad de la Fragancia (Mililitros)</label>
                                <input type="text"
                                    class="form-control custom-input"
                                    id="contenido"
                                    name="contenido"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="marca_id" class="form-label label-color">Selecciona la Marca</label>
                                <select name="marca_id"
                                        id="marca_id"
                                        class="form-select"
                                        required>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id }}">
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="concentracion" class="form-label label-color">Selecciona la Concentracion</label>
                                <select name="concentracion" class="form-select">
                                    <option value="EDT">EDT</option>
                                    <option value="EDP">EDP</option>
                                    <option value="Parfum">Parfum</option>
                                    <option value="Extrait">Extrait</option>
                                    <option value="Elixir">Elixir</option>
                                    <option value="Body Spray">Body Spray</option>
                                    <option value="Body Mist">Body Mist</option>
                                    <option value="Splash">Splash</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="genero" class="form-label label-color">Selecciona el Genero</label>
                                <select name="genero" class="form-select">
                                    <option value="Caballero">Caballero</option>
                                    <option value="Dama">Dama</option>
                                    <option value="Unisex">Unisex</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label label-color">Selecciona el Tipo de Fragancia</label>
                                <select name="tipo" class="form-select">
                                    <option value="Perfume">Perfume</option>
                                    <option value="Set">Set</option>
                                    <option value="Body">Body</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label label-color">Selecciona la Categoria</label>
                                <select name="categoria" class="form-select">
                                    <option value="Diseñador">Diseñador</option>
                                    <option value="Arabe">Arabe</option>
                                    <option value="Nicho">Nicho</option>
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

                        const nuevaTabla = doc.querySelector('#tabla-perfumes').innerHTML
                        document.querySelector('#tabla-perfumes').innerHTML = nuevaTabla
                    })
                }, 400)
            })
        </script>
        
    @endsection