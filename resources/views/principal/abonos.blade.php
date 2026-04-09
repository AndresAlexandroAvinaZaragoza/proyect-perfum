@extends('layouts.app')
    @section('content')

        <link rel="stylesheet" href="{{ asset('css/abonos.css') }}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=edit" />
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <div class="container-fluid py-4">
            <header class="header mb-4">
                <div class="container d-flex align-items-center gap-3">
                    
                    <i class="fa-solid fa-money-bills icon-big text-warning"></i> 
                    
                    <h1 class="mb-0">Registrar Abono</h1>
                    
                </div>
            </header> 

            <div class="row g-4 p-3"> 

                <div class="col-md-4 col-lg-4 d-flex flex-column gap-3">
                    
                    <div class="card card-custom rounded-4">
                        <div class="p-4">
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="border-custom">
                                        <i class="fa-regular fa-user fs-4" style="color: #F39D0B;"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0">Andres</h3>
                                        <span class="color-custom">Cliente: Crédito Aprobado</span>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="px-4">
                            <hr class="my-2">   
                        </div>
                        
                        <div class="p-4">
                            <div class="mb-3">
                                <div class="d-flex flex-column gap-1">
                                    <span class="color-custom p-custom">DEUDA TOTAL</span>
                                    <span class="p-custom-2">$1,250.00</span>
                                </div>
                            </div>
                            <div class="p-2 gap-1 border-secondary d-flex flex-column">
                                <div class="mb-0">
                                    <p class="p-custom p-custom-3">FALTANTE POR PAGAR</p>
                                    <p class="mb-0 p-custom-21"><strong>$450.00</strong></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card card-custom card-custom-mov rounded-4 p-4">
                        <div class="d-flex align-items-center gap-2 py-2">
                            <i class="fa-regular fa-calendar-check" style="color: #8A817C"></i>
                            <span style="color: #8A817C;">Ultimos Movimientos</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="span-custom">12 Enero 2026</span>
                            <strong class="strong-custom">+$200.00</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="span-custom">1 Marzo 2026</span>
                            <strong class="strong-custom">+$800.00</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-8">  
                    <div class="card card-custom rounded-4 h-100 d-flex flex-column">    
                        <div class=" p-4 flex-grow-1">
                            
                            <div class="row g-4 mb-4"> 
    
                                <div class="col-md-6">
                                    <label for="monto" class="form-label label-color text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">MONTO DEL ABONO</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-dollar-sign position-absolute fs-4" 
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color:#F39D0B; pointer-events: none;"></i>
                                        
                                        <input type="number" id="monto" name="monto" min="1" placeholder="0.00" 
                                        class="form-control form-control-lg custom-input ps-5" 
                                        style="width: 100%;" required> 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="metodo" class="form-label label-color text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">MÉTODO DE PAGO</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-magnifying-glass-dollar position-absolute fs-5"
                                        style="top: 50%; left: 15px; transform: translateY(-50%); color:#F39D0B; z-index: 10; pointer-events: none;"></i>
                                        
                                        <select name="metodo" id="metodo" class="form-select form-select-lg custom-input ps-5" style="width: 100%;" required>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="transferencia">Transferencia Bancaria</option>
                                            <option value="tarjeta">Tarjeta Crédito / Débito</option>
                                            <option value="paypal">Paypal</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 d-flex align-items-center gap-3" style="border-color: #483C1D !important; background-color: rgba(255,255,255,0.02);">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.05);">
                                            <i class="fa-regular fa-circle-user fs-5 text-secondary"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">REGISTRADO POR (USUARIO)</span>
                                            <strong class="text-white">Administrador Principal</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 d-flex align-items-center gap-3" style="border-color: #483C1D !important; background-color: rgba(255,255,255,0.02);">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; background-color: rgba(255,255,255,0.05);">
                                            <i class="fa-regular fa-clock fs-5 text-secondary"></i>
                                        </div>
                                        <div>
                                            <span class="d-block text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">FECHA Y HORA ACTUAL</span>
                                            <strong class="text-white">08 Abr 2026, 19:40 PM</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="notas" class="form-label text-secondary text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">NOTAS ADICIONALES (OPCIONAL)</label>
                                    <textarea class="form-control custom-input p-3" id="notas" name="notas" rows="3" placeholder="Escriba aquí cualquier detalle relevante sobre el pago..." style="resize: none;"></textarea>
                                </div>
                            </div>

                        </div> <div class="p-4  border-3  d-flex justify-content-end align-items-center gap-4">
                            <a href="#" class="text-decoration-none text-secondary text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 1px; transition: color 0.3s;" onmouseover="this.classList.replace('text-secondary', 'text-white')" onmouseout="this.classList.replace('text-white', 'text-secondary')">
                                Cancelar
                            </a>
                            
                            <button type="submit" class="btn fw-bold px-4 py-2 d-flex align-items-center gap-2" style="background-color: #F39D0B; color: #1a150d; border-radius: 6px; letter-spacing: 1px;">
                                <i class="fa-regular fa-circle-check fs-5"></i>
                                REGISTRAR ABONO
                            </button>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    @endsection