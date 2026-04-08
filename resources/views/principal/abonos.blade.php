@extends('layouts.app')
    @section('content')
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
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

            <!-- DIv para las tres tarjetas -->
            <div class="row g-4 p-3 gap-custom"> 
                <!-- Tarjeta 1 -->
                 <div>
                    <div class="col-md-4 card card-custom rounded-4">
                        <div class="p-4">
                            <div class="mt-2 d-flex justify-content-between align-items-center">

                                <!-- IZQUIERDA: icono + texto -->
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

                            <div class="p-3 gap-1  border-secondary d-flex flex-column">
                                <div>
                                    <p  class="p-custom">FALTANTE POR PAGAR</p>
                                    <p class="mb-0  p-custom-2"><strong>$450.00</strong></p>
                                </div>
                                <span></span> <!-- espacio para alinear el monto faltante a la derecha -->
                            </div>
                        </div>


                    </div>

                    
                </div>
                
            

            </div>
        </div>
    @endsection