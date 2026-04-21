@extends('layouts.ventas')
    @section('contentVenta')
        <link rel="stylesheet" href="{{ asset('css/pedidos.css') }}">
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
                    <h1>Nuevo Pedido</h1>   
                    <p>Registro de un nuevo pedido</p>
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
                        <div class="">
                            <div class="card-body">
                                <h2>Productos del Pedido</h2>
                                <p>DETALLE DE MERCANCIA SOLICITADA</p>
                            </div>
                        </div>
                    </div>

                    <!-- PERFUMES -->
                    <div class="col-md-6">
                        <div class="h-100">
                            <div class="card-body">

                                <p>Buscador de Perfumes</p>
                                <div class="position-relative">
                                    <i class="fa-solid fa-magnifying-glass position-absolute"
                                    style="top: 50%; left: 15px; transform: translateY(-50%); color:#c9a646; z-index: 10;"></i>
            
                                    <select id="selectPerfumes" class="form-control w-100 ps-5">
                                        <option value="">Seleccionar perfume</option>

                                        @foreach ($perfumes as $perfume)
                                            <option value="{{ $perfume->id }}"
                                            data-nombre="{{ $perfume->nombre ?? 'Sin nombre' }} - {{ $perfume->concentracion ?? '' }} - {{ $perfume->contenido ?? '' }}ml - {{ $perfume->genero ?? '' }} - {{ $perfume->tipo ?? 'sin tipo' }}"
        
                                            >
                                                {{ $perfume->nombre ?? 'Sin nombre' }} -
                                                {{ $perfume->concentracion ?? '' }} -
                                                {{ $perfume->contenido ?? '' }}ml -
                                                {{ $perfume->genero ?? '' }}
                                                {{ $perfume->tipo ?? 'sin tipo'}}
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
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-custom m-0">
                                    <thead>
                                        <tr class="th-custom">
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>P. Compra</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-pedido">
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
                        
                        <div class="card-body p-3">
                            <p class="card-title-venta">Resumen del Pedido</p>

                            <div class="mb-2">
                                <label class="form-label label-color">PROVEEDORES</label>
                                <select 
                                    name="selectProovedores"
                                    class="form-select" 
                                    required>
                                    <option value="">Seleccionar Proveedor</option>
                                    @foreach ($proovedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">
                                        {{ $proveedor->nombre }}
                                        </option>   
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label label-color">NUMERO DE GUIA</label>
                                <input 
                                    type="text" 
                                    name="numero_guia" 
                                    class="form-control custom-input"
                                    style="background-color: #050504;" 
                                    inputmode="numeric"
                                    pattern="[0-9.,]*"
                                    maxlength="49"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    required
                                >
                            </div>

                            <div class="mb-2">
                                <label class="form-label label-color">PAQUETERIA</label>
                                <input 
                                    type="text" 
                                    name="paqueteria" 
                                    class="form-control custom-input" 
                                    style="background-color: #050504;" 

                                    maxlength="49"
                                    required
                                >
                            </div>

                            <div class="mb-2">
                                <label class="form-label label-color">PRECIO DE ENVIO</label>
                                <input 
                                    type="text" 
                                    name="precio_envio" 
                                    id="precio_envio"
                                    class="form-control custom-input" 
                                    style="background-color: #050504;" 

                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    maxlength="49"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    required
                                >
                            </div>

                        </div>
                        
                        

                        <div class="card-body p-3">
            
                            

                            
                            <div class="d-flex justify-content-between">
                                <h6 class="h6-custom">Subtotal:</h6>
                                <strong class="h6-custom" id="subtotal_display">$0</strong>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="h6-custom">Envio: </h6>
                                <strong id="envio_display" class="h6-custom">$0</strong>
                            </div>
                        </div>

                        

                        <div class="bloque-total backgroud-custom">
                            <div class="d-flex justify-content-between mt-1">
                                <h4 class="h4-custom p-2">Total a Pedido:</h4>
                                <h4 id="total_display" class="h6-custom p-2">$0</h4>
                            </div>
                        </div>

                            <!-- BOTÓN ABAJO -->
                            <div class="mt-1">

                                <input type="hidden" name="carrito" id="input_carrito">
                                <input type="hidden" name="total" id="input_total">
                                <input type="hidden" name="subtotal" id="input_subtotal">
                                <input type="hidden" name="articulos" id="input_articulos">
                                <input type="hidden" name="envio" id="input_envio">

                                <button type="submit" class="button w-100 btn-finalizar">
                                    Confirmar Pedido <i class="fa-solid fa-arrow-right"></i> 
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
            $('#selectPerfumes').select2({
                placeholder: "Buscar perfume...",
                allowClear: true,
                minimumResultsForSearch: 0,
            });
        </script>


        <script>
            let carrito = [];
            let envio = 0;
            
            // PERFUMES
            $('#selectPerfumes').on('select2:select', function (e) {

                const data = e.params.data;

                if (!data || !data.id) return;

                let item = {
                    id: data.id,
                    nombre: data.text,
                    cantidad: 1,
                    precio: 0,
                };

                agregarAlCarrito(item);

                // Reset visual del Select2 sin volver a disparar la logica de agregado
                $(this).val(null).trigger('change.select2');
                $(this).select2('close');
            });




            // AGREGAR AL CARRITO
            function agregarAlCarrito(item){

                let existente = carrito.find(p => 
                    p.id == item.id && p.tipo == item.tipo
                );

                // SI YA EXISTE
                if(existente){

                    existente.cantidad++;
                } else {
                    carrito.push(item);
                }
                

                renderTabla();
            }

            function renderTabla() {

                let tbody = $('#tabla-pedido');
                tbody.empty();

                let subtotal = 0;
                carrito.forEach((item, index) => {

                    let sub = item.cantidad * (item.precio || 0);
                    subtotal += sub;
                    tbody.append(`
                        <tr class="td-custom">
                            <td>${item.nombre}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">

                                    <button class="btn btn-sm btn-outline-secondary" onclick="restar(${index})">-</button>

                                    <input 
                                        type="number" 
                                        name="cantidad"
                                        min="1"  
                                        value="${item.cantidad}"    
                                        class="form-control form-control-sm"
                                        style="background-color: #1A1614; color: #fff ; width:60px;"
                                        onchange="cambiarCantidad(${index}, this.value)"
                                        style="width:60px;"
                                    >

                                    <button class="btn btn-sm btn-outline-secondary" onclick="sumar(${index})">+</button>


                                </div>
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    name="precio_unitario" 
                                    class="form-control precio-unitario"
                                    style="background-color: #1A1614; color: #fff; border:none; hover:none; focus:none; width:100px;"
                                    value="${formatoMonedaInput(item.precio || 0)}" 
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    onchange="cambiarPrecio(${index}, this.value)"
                                    required
                                >
                            </td>
                            <td>$${sub || 0}</td>
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
                let total = subtotal + envio; // Si no se maneja IVA, el total es igual al subtotal
                // ACTUALIZAR HTML
                $('#subtotal_display').text(formatoMoneda(subtotal));
                $('#envio_display').text(formatoMoneda(envio));
                //$('#iva_display').text(formatoMoneda(iva));
                $('#total_display').text(formatoMoneda(total));

                    //para mostrar la cantidad de productos
                $('#contador2').text(`${carrito.length}`);
            }

            function formatoMoneda(num) {
                return num.toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });
            }

            function parseNumero(valor) {
                if (valor === null || valor === undefined) return 0;
                const limpio = String(valor).replace(/[^0-9]/g, '');
                const numero = parseInt(limpio, 10);
                return isNaN(numero) ? 0 : numero;
            }

            function formatoNumeroInput(num) {
                return Number(num || 0).toLocaleString('es-MX', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2,
                });
            }

                function formatoMonedaInput(num) {
                    return Number(num || 0).toLocaleString('es-MX', {
                        style: 'currency',
                        currency: 'MXN',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
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

                carrito[index].cantidad = nuevaCantidad;

                renderTabla();
            }

            function cambiarPrecio(index, nuevoPrecio) {

                nuevoPrecio = parseNumero(nuevoPrecio);

                if (isNaN(nuevoPrecio) || nuevoPrecio < 0) {
                    nuevoPrecio = 0;
                }

                carrito[index].precio = nuevoPrecio;

                renderTabla();
            }

            function sumar(index) {
                    carrito[index].cantidad++;
                    renderTabla();
                
            }

            function restar(index) {
                if (carrito[index].cantidad > 1) {
                    carrito[index].cantidad--;
                    renderTabla();
                }
            }

            function strockmax(index) {

            
            }

            const inputEnvio = document.getElementById('precio_envio');

            if (inputEnvio) {
                inputEnvio.addEventListener('input', function () {
                    const valor = parseNumero(this.value);
                    envio = isNaN(valor) || valor < 0 ? 0 : valor;
                    renderTabla();
                });

                inputEnvio.addEventListener('focus', function () {
                    this.value = envio > 0 ? envio : '';
                });

                inputEnvio.addEventListener('blur', function () {
                    this.value = envio > 0 ? formatoNumeroInput(envio) : '';
                });
            }

            $(document).on('focus', '.precio-unitario', function () {
                this.value = parseNumero(this.value) || '';
            });

            $(document).on('blur', '.precio-unitario', function () {
                const numero = parseNumero(this.value);
               this.value = formatoMonedaInput(numero);
            });
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

                const totalFinal = subtotalFinal + envio;

                document.getElementById('input_carrito').value = JSON.stringify(carrito);
                document.getElementById('input_total').value = totalFinal;
                document.getElementById('input_subtotal').value = subtotalFinal;
                document.getElementById('input_articulos').value = carrito.length;
                document.getElementById('input_envio').value = envio;
            });
        </script>

    @endsection





