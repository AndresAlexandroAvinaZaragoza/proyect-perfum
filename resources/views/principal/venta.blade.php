@extends('layouts.ventas')
    @section('contentVenta')
        <link rel="stylesheet" href="{{ asset('css/venta.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <div class="container-fluid py-4">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
      
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <header class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Punto de venta y facturacion</h1>   
                    <p>Registro de una nueva venta</p>
                </div>

                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#dropdownParent">
                    Limpiar Carrito
                </button>
            </div>

               
        </header>


        <div class="row g-4 ">

            <!--  IZQUIERDA -->
            <div class="col-md-8">

                <!--  FILTROS (OCUPAN TODO EL ANCHO) -->
                <div class="row g-3 mb-3">

                    <!-- CLIENTE -->
                    <div class="col-md-6">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">

                                <p>Selecciona Cliente</p>

                                <div class="position-relative">
                                    <i class="fa-regular fa-user position-absolute"
                                    style="top: 50%; left: 15px; transform: translateY(-50%); color:#c9a646;"></i>
                                <form action="{{ route('venta.store') }}" method="POST" id="form-venta">
                                @csrf
                                    <select name="cliente_id" class="form-select ps-5 w-100" required>
                                        <option value="">Consumidor Final</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- PERFUMES -->
                    <div class="col-md-6">
                        <div class="card card-custom rounded-4 h-100">
                            <div class="card-body">

                                <p>Buscador de Perfumes</p>
                                <div class="position-relative">
                                    <i class="fa-solid fa-magnifying-glass position-absolute"
                                    style="top: 50%; left: 15px; transform: translateY(-50%); color:#c9a646; z-index: 10;"></i>
            
                                    <select id="inventario_id" class="form-control w-100 ps-5">
                                        <option value="">Seleccionar perfume</option>

                                        @foreach ($inventarios as $inventario)
                                            <option value="{{ $inventario->id }}"
                                            data-nombre="{{ $inventario->perfume->nombre ?? 'Sin nombre' }} - {{ $inventario->perfume->concentracion ?? '' }} - {{ $inventario->perfume->contenido ?? '' }}ml - {{ $inventario->perfume->genero ?? '' }} - {{ $inventario->perfume->tipo ?? 'sin tipo' }}"
                                            data-precio="{{ $inventario->precio_venta}}"
                                            data-stock="{{ $inventario->stock }}"
                                            >
                                                {{ $inventario->perfume->nombre ?? 'Sin nombre' }} -
                                                {{ $inventario->perfume->concentracion ?? '' }} -
                                                {{ $inventario->perfume->contenido ?? '' }}ml -
                                                {{ $inventario->perfume->genero ?? '' }}
                                                {{ $inventario->perfume->tipo?? 'sin tipo'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                

                            </div>
                        </div>
                    </div>

                </div>

                <!--  TABLA -->
                <div class="card card-custom rounded-4  ">
                    <div>
                            <div class="d-flex align-items-center justify-content-between px-4 py-3 header-table">
        
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-cart-arrow-down fs-4" style="color:#c9a646;"></i>
                                    <h6 class="mb-0 fw-bold h6-custom">Artículos en Venta</h6>
                                </div>

                                <span class="badge bg-primary" id="contador">0 ITEMS SELECICONADOS</span>

                            </div>
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
                @if(session('success'))
                <script>
                    alertify.success("{{ session('success') }}");
                </script>
                @endif
            <!-- DERECHA -->
            <div class="col-md-4">
                <div class="card card-custom rounded-4 h-custom-2">
                    <div class=" d-flex flex-column">
                        
                        <div class="card-body p-4">
                            <p class="card-title-venta">Resumen de Venta</p>
                            
                            <div class="d-flex justify-content-between">
                                <h6>Articulos</h6>
                                <span class="h6-custom" id="contador2">0</span>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <h6 class="h6-custom">Subtotal:</h6>
                                <strong class="h6-custom" id="subtotal_display">$0</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="h6-custom">IVA:</h6>
                                <strong id="iva_display" class="h6-custom">$0</strong>
                            </div>
                        </div>
                        


                        <div class="bloque-total backgroud-custom">
                            <div class="d-flex justify-content-between mt-1">
                                <h4 class="h4-custom p-2">Total a Pagar:</h4>
                                <h4 id="total_display" class="h6-custom p-2">$0</h4>
                            </div>
                        </div>


                        <div>

                            <p class="p-4 mt-1">METODO DE OPERACION</p>  

                            <div class="radio-inputs mt-4">

                                <!-- Metodo de Contado -->
                                <label>
                                    <input class="radio-input" type="radio" name="metodo_pago" value="contado" checked>

                                    <span class="radio-tile">
                                        <span class="radio-icon">
                                            <i class="fa-solid fa-money-bill-1-wave"></i>
                                        </span>
                                        <span class="radio-label">Contado</span>
                                    </span>
                                </label>

                                <!-- Metodo de Credito -->
                                <label>
                                    <input class="radio-input" type="radio" name="metodo_pago" value="credito">

                                    <span class="radio-tile">
                                        <span class="radio-icon">
                                            <i class="fa-solid fa-credit-card"></i>
                                        </span>
                                        <span class="radio-label">Credito</span>
                                    </span>
                                </label>

                            </div>
                            <!-- BOTÓN ABAJO -->
                            <div class="mt-4 p-4">

                                <input type="hidden" name="carrito" id="input_carrito">
                                <input type="hidden" name="total" id="input_total">
                                <input type="hidden" name="subtotal" id="input_subtotal">
                                <input type="hidden" name="articulos" id="input_articulos">

                                <button type="submit" class="button w-100 btn-finalizar">
                                    Finalizar venta <i class="fa-solid fa-arrow-right"></i> 
                                </button>  
            </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>

        </div>


         <!-- Scrip para rellenar datos del select2 -->
        <script>
            $('#inventario_id').select2({
                placeholder: "Buscar perfume...",
                allowClear: true,
                minimumResultsForSearch: 0,
            });
        </script>


        <script>
            let carrito = [];

            $('#inventario_id').on('change', function () {

                let selected = $(this).find(':selected');

                let id = selected.val();
                let nombre = selected.data('nombre');
                let precio = selected.data('precio');
                let stock = selected.data('stock');    
                if (!id) return;

                // Ver si ya existe
                let producto = carrito.find(p => p.id == id);

                if (producto) {
                    if(producto.cantidad < producto.stock) {
                        producto.cantidad +=1;
                    } else {
                        alert('No hay suficiente stock disponible');
                    }
                } else {
                    carrito.push({
                        id: id,
                        nombre: nombre,
                        precio: precio,
                        cantidad: 1,
                        stock: stock
                    });
                }

                renderTabla();

                // limpiar select
                $('#inventario_id').val(null).trigger('change');
            });


            function renderTabla() {

                let tbody = $('#tabla-carrito');
                tbody.empty();

                let subtotal = 0;
                carrito.forEach((item, index) => {

                    let sub = item.precio * item.cantidad;
                    subtotal += sub;

                    tbody.append(`
                        <tr class="td-custom">
                            <td>${item.nombre}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">

                                    <button class="btn btn-sm btn-outline-secondary" onclick="restar(${index})">-</button>

                                    <input 
                                        type="number" 
                                        min="1" 
                                        value="${item.cantidad}" 
                                        class="form-control form-control-sm text-center"
                                        onchange="cambiarCantidad(${index}, this.value)"
                                        style="width:60px;"
                                    >

                                    <button class="btn btn-sm btn-outline-secondary" onclick="sumar(${index})">+</button>

                                </div>
                            </td>
                            <td>${item.cantidad} / ${item.stock}</td>
                            <td>$${item.precio}</td>
                            <td>$${sub}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="eliminar(${index})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });

                // CALCULOS
               /* let iva = subtotal * 0.16;
                let total = subtotal + iva;
                */
                let total = subtotal; // Si no se maneja IVA, el total es igual al subtotal
                // ACTUALIZAR HTML
                $('#subtotal_display').text(formatoMoneda(subtotal));
                //$('#iva_display').text(formatoMoneda(iva));
                $('#total_display').text(formatoMoneda(total));

                    //para mostrar la cantidad de productos
                $('#contador').text(`${carrito.length} ITEMS SELECCIONADOS`);
                $('#contador2').text(`${carrito.length}`);
            }

            function formatoMoneda(num) {
                return num.toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });
            }

            function eliminar(index) {
                carrito.splice(index, 1);
                renderTabla();
            }

            //funcion para agregar mas cantidad
            function cambiarCantidad(index, nuevaCantidad) {

                nuevaCantidad = parseInt(nuevaCantidad);

                if (isNaN(nuevaCantidad) || nuevaCantidad < 1) {
                    nuevaCantidad = 1;
                }

                if(nuevaCantidad > carrito[index].stock){
                    nuevaCantidad = carrito[index].stock;
                    alert('No puedes agregar más de ' + carrito[index].stock + ' unidades de este producto');
                }

                carrito[index].cantidad = nuevaCantidad;

                renderTabla();
            }

            function sumar(index) {
                if(carrito[index].cantidad < carrito[index].stock) {
                    carrito[index].cantidad++;
                    renderTabla();
                } else {
                    alert('No hay suficiente stock disponible');
                }
            }

            function restar(index) {
                if (carrito[index].cantidad > 1) {
                    carrito[index].cantidad--;
                    renderTabla();
                }
            }

            function strockmax(index) {

            
            }
        </script>


<script>
    const formVenta = document.getElementById('form-venta');

    formVenta.addEventListener('submit', function (event) {
        if (carrito.length === 0) {
            alert("El carrito está vacío. Agrega productos para continuar.");
            event.preventDefault();
            return;
        }

        let subtotalFinal = 0;
        carrito.forEach(item => {
            subtotalFinal += (item.precio * item.cantidad);
        });

        document.getElementById('input_carrito').value = JSON.stringify(carrito);
        document.getElementById('input_total').value = subtotalFinal;
        document.getElementById('input_subtotal').value = subtotalFinal;
        document.getElementById('input_articulos').value = carrito.length;
    });
</script>

    @endsection





