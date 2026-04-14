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

        <!-- 🔹 COLUMNA IZQUIERDA -->
        <div class="col-md-4 col-lg-4 d-flex flex-column gap-3">

            <div class="card card-custom rounded-4">
                <div class="p-4">
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            
                            <div class="border-custom">
                                <i class="fa-regular fa-user fs-4" style="color: #F39D0B;"></i>
                            </div>

                            <div>
                                <h3 class="mb-0">
                                    <h3>{{ $deuda->cliente->nombre ?? 'Sin cliente' }}</h3>
                                </h3>
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
                            <span class="p-custom-2">${{ number_format($deuda->total, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-2 gap-1 border-secondary d-flex flex-column">
                        <div class="mb-0">
                            <p class="p-custom p-custom-3">FALTANTE POR PAGAR</p>
                            <p class="mb-0 p-custom-21">
                                <strong>${{ number_format($deuda->faltante, 2) }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔹 MOVIMIENTOS -->
            <div class="card card-custom card-custom-mov rounded-4 p-4">
                <div class="d-flex align-items-center gap-2 py-2">
                    <i class="fa-regular fa-calendar-check" style="color: #8A817C"></i>
                    <span style="color: #8A817C;">Ultimos Movimientos</span>
                </div>

                @if($deuda->abonos && $deuda->abonos->count())
                    @foreach($deuda->abonos as $abono)
                        <div class="d-flex justify-content-between">
                            <span class="span-custom">{{ \Carbon\Carbon::parse($abono->created_at)->format('d M Y') }}</span>
                            <strong class="strong-custom">+${{ number_format($abono->pago, 2) }}</strong>
                        </div>
                    @endforeach
                @else
                    <p class="text-secondary">No hay abonos registrados</p>
                @endif
            </div>

        </div>

        <!-- 🔹 COLUMNA DERECHA -->
        <div class="col-md-8 col-lg-8">

            <form action="{{ route('abonos.store') }}" method="POST">
            @csrf
              <input type="hidden" name="deuda_id" value="{{ $deuda->id }}">
                <div class="card card-custom rounded-4 h-100 d-flex flex-column">    

                    <div class="p-4 flex-grow-1">

                        <div class="row g-4 mb-4"> 

                            <div class="col-md-6">
                                <label class="form-label label-color text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                                    MONTO DEL ABONO
                                </label>

                                <div class="position-relative">
                                    <i class="fa-solid fa-dollar-sign position-absolute fs-4"
                                       style="top: 50%; left: 15px; transform: translateY(-50%); color:#F39D0B;"></i>

                                    <input type="number" name="pago" min="1" placeholder="0.00" max="{{ $deuda->faltante }}" step="0.01"
                                           class="form-control form-control-lg custom-input ps-5" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label label-color text-uppercase" style="font-size: 0.85rem;">
                                    MÉTODO DE PAGO
                                </label>

                                <div class="position-relative">
                                    <i class="fa-solid fa-magnifying-glass-dollar position-absolute fs-5"
                                       style="top: 50%; left: 15px; transform: translateY(-50%); color:#F39D0B;"></i>

                                    <select name="tipo_pago" class="form-select form-select-lg custom-input ps-5" required>
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
                                <div class="border rounded-3 p-3 d-flex align-items-center gap-3">
                                    <i class="fa-regular fa-circle-user text-secondary fs-4" ></i>
                                    <div>
                                        <span class="p-custom span-custom">REGISTRADO POR:</span>
                                        <br>
                                        <strong style="color: Grey">{{ auth()->user()->name }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 d-flex align-items-center gap-3">
                                    <i class="fa-regular fa-clock text-secondary fs-4" ></i>
                                    <div>
                                        <span class="p-custom span-custom">FECHA ACTUAL</span>
                                        <br>
                                        <strong style="color: Grey">{{ date('d M Y, g:i A')  }}</strong>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <textarea class="form-control custom-input p-3" name="notas" rows="3"
                                  placeholder="Notas..."></textarea>

                    </div>

                    <div class="p-4 d-flex justify-content-end gap-4">
                        <a href="{{ route('deuda.index') }}" 
                            class="text-decoration-none text-secondary text-uppercase fw-bold" 
                            style="font-size: 0.85rem; letter-spacing: 1px; transition: color 0.3s;">Cancelar</a>

                        <button 
                            type="submit" 
                            class="btn fw-bold px-4 py-2 d-flex align-items-center gap-2" 
                            style="background-color: #F39D0B; color: #1a150d; border-radius: 6px; letter-spacing: 1px;"> 
                            <i class="fa-regular fa-circle-check fs-5"></i> 
                            REGISTRAR ABONO
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

