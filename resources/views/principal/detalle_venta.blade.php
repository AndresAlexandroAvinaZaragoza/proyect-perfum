@extends('layouts.ventas')

@section('contentVenta')

<link rel="stylesheet" href="{{ asset('css/detalle_venta.css') }}">


<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <a href="{{ route('venta.historial') }}" class="btn btn-outline-light btn-sm">← Volver</a>

        <div class="text-center">
            <h2 class="titulo">Perfum Intense</h2>
            <small class="subtitulo">Detalle de Transacción</small>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('venta.pdf', $venta->id) }}" class="btn btn-outline-gold btn-sm">
                Descargar PDF
            </a>
            <a 
                href="{{ route('venta.pdf2', $venta->id) }}" 
                target="_blank"
                class="btn btn-outline-gold btn-sm">
                    Imprimir Ticket
            </a>


            <button class="btn btn-warning btn-sm fw-bold">Enviar Recibo</button>
        </div>
    </div>

    <!-- INFO -->
    <div class="mb-4">
        <span class="badge bg-warning text-dark mb-2">Detalle de Venta</span>
        <h2 class="venta-id" style="color: #fff;">Venta #{{ $venta->folio }}</h2>
        <p class="color-custom">
            {{ $venta->created_at->format('d M Y H:i') }} |
            Registrado por: {{ $venta->usuario->usuario }}
        </p>
    </div>

    <div class="row g-4">

        <!-- IZQUIERDA -->
        <div class="col-lg-4">

            <!-- CLIENTE -->
            <div class="card premium-card p-4 mb-4">
                <h6 class="section-title">Información del Cliente</h6>

                <h4 class="cliente-nombre" style="color: #fff;">
                    {{ $venta->cliente->nombre }}
                </h4>

                <p class="color-custom">
                    {{ $venta->cliente->correo ?? 'Sin correo' }}
                </p>

                <div class="vip">● Cliente registrado</div>
            </div>

            <!-- PAGO -->
            <div class="card premium-card p-4">
                <h6 class="section-title">Método de Pago</h6>

                <div class="pago-box" style="color: #fff;">
                    {{ strtoupper($venta->tipo_venta) }}
                </div>
            </div>

        </div>

        <!-- DERECHA -->
        <div class="col-lg-8">

            <div class="card premium-card p-0">

                <!-- HEADER TABLA -->
                <div class="p-3 border-bottom d-flex justify-content-between">
                    <h6 class="section-title m-0">Artículos en la orden</h6>
                    <span class="badge bg-dark">
                        {{ count($venta->detalles) }} items
                    </span>
                </div>

                <!-- TABLA -->
                <table class="table table-dark m-0 table-hover">
                    <thead>
                        <tr>
                            <th>Perfume</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Unitario</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $items = collect();

                            // perfumes
                            foreach($venta->detalles as $d){
                                $items->push([
                                    'nombre' => $d->perfume->nombre . ' ' . $d->perfume->concentracion . ' ' . ' ' . $d->perfume->genero ?? 'Perfume eliminado',
                                    'marca' => $d->perfume->marca->nombre ?? 'Marca desconocida',
                                    'tipo' => $d->perfume->tipo ?? 'Tipo desconocido',
                                    'ml' => $d->perfume->contenido . ' ml',
                                    'cantidad' => $d->cantidad,
                                    'precio' => $d->precio_unitario,
                                    'subtotal' => $d->subtotal
                                ]);
                            }

                            // decants
                            foreach($venta->detallesDecants as $d){
                                $items->push([
                                    'nombre' => $d->decant->perfume->nombre . ' ' . $d->decant->perfume->concentracion . ' ' . ' ' . $d->decant->perfume->genero ?? 'Decant eliminado',
                                    'marca' => $d->decant->perfume->marca->nombre ?? 'Marca desconocida',
                                    'tipo' => 'Decant',
                                    'ml' => $d->ml . ' ml',
                                    'cantidad' => $d->cantidad,
                                    'precio' => $d->precio_unitario,
                                    'subtotal' => $d->subtotal
                                ]);
                            }
                            @endphp

                        @foreach($items as $item)
                        <tr>
                            <td class="d-flex align-items-center gap-3">

                                <!-- Imagen fake elegante
                                <div class="img-box"></div>
                                -->
                                <div>
                                    <div class="nombre-perfume">
                                        {{ $item['nombre'] }}
                                    </div>
                                    <small class="color-custom">
                                        {{ $item['tipo'] }} - {{ $item['marca'] }}
                                    </small>
                                </div>

                            </td>
                            <td class="text-center">{{ $item['ml'] }}</td>

                            <td class="text-center">{{ $item['cantidad'] }}</td>

                            <td class="text-end">
                                ${{ number_format($item['precio'],2) }}
                            </td>

                            <td class="text-end text-warning fw-bold">
                                ${{ number_format($item['subtotal'],2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- TOTAL -->
                <div class="p-4 border-top total-box">

                    <div class="d-flex justify-content-end">
                        <div style="width: 250px">

                            <div class="d-flex justify-content-between">
                                <span style="color: #fff;">Subtotal</span>
                                <span style="color: #fff;">${{ number_format($venta->total,2) }}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span style="color: #fff;">IVA</span>
                                <span style="color: #fff;">$0.00</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between total-final">
                                <strong style="color: #fff;">Total</strong>
                                <strong class="text-warning fs-4">
                                    ${{ number_format($venta->total,2) }}
                                </strong>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

    <script>
    async function compartirVenta() {

        const url = "{{ route('venta.pdf', $venta->id) }}";
        const titulo = "Recibo de compra - Perfum Intense";
        const texto = "Hola, aquí tienes tu recibo de compra.";

        if (navigator.share) {
            try {
                await navigator.share({
                    title: titulo,
                    text: texto,
                    url: url
                });
            } catch (error) {
                console.log("Error al compartir:", error);
            }
        } else {
            // fallback si no soporta
            copiarEnlace(url);
        }
    }
    </script>

@endsection