<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Venta {{ $venta->id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #C9A646;
        }

        .sub {
            font-size: 12px;
            color: #777;
        }

        .info {
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
        }

        .total strong {
            font-size: 18px;
        }
    </style>
</head>

<body>

    <!-- LOGO Y TITULO -->
    <div class="header" style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
        
        <img src="{{ storage_path('app/public/imageSistem/logo.jpeg') }}" width="80">

        <div>
            <div style="font-size: 24px; font-weight: bold; color: #C9A646;">
                Perfum Intense
            </div>
            <div style="font-size: 12px; color: #777;">
                Recibo de Venta
            </div>
        </div>

    </div>

    <!-- INFO -->
    <div class="info">
        <div class="box">
            <strong>Venta #{{ $venta->id }}</strong><br>
            Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}<br>
            Atendido por: {{ $venta->usuario->usuario }}
        </div>

        <div class="box">
            <strong>Cliente:</strong><br>
            {{ $venta->cliente->nombre }}<br>
            {{ $venta->cliente->correo ?? 'Sin correo' }}
        </div>
    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="right">Cant.</th>
                <th class="right">Precio</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @php
                $items = collect();

                // perfumes
                foreach($venta->detalles as $d){
                    $items->push([
                        'nombre' => ($d->perfume->marca->nombre . ' ' . $d->perfume->nombre . ' ' . $d->perfume->concentracion . ' ' ?? 'Perfume eliminado'). ' ' . $d->perfume->contenido . 'ml',
                        'cantidad' => $d->cantidad,
                        'precio' => $d->precio_unitario,
                        'subtotal' => $d->subtotal
                    ]);
                }

                // decants
                foreach($venta->detallesDecants as $d){
                    $items->push([
                        'nombre' => ('Decant ' .$d->decant->perfume->marca->marca . ' ' . $d->decant->perfume->nombre . ' ' . $d->decant->perfume->concentracion ?? 'Decant eliminado') . ' ' . $d->ml . 'ml',
                        'cantidad' => $d->cantidad,
                        'precio' => $d->precio_unitario,
                        'subtotal' => $d->subtotal
                    ]);
                }
            @endphp
            @foreach($items as $item)
            <tr>
                <td class="stard">{{$item['nombre'] }}</td>
                <td class="right">{{ $item['cantidad'] }}</td>
                <td class="right">${{ number_format($item['precio'],2) }}</td>
                <td class="right">${{ number_format($item['subtotal'],2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total right">
        <p>Subtotal: ${{ number_format($venta->total,2) }}</p>
        <p><strong>Total: ${{ number_format($venta->total,2) }}</strong></p>
    </div>

</body>
</html>