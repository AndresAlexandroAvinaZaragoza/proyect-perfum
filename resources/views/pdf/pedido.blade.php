<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedido #{{ $pedido->folio }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .header {
            margin-bottom: 20px;
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

        .estado {
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: bold;
        }

        .pendiente {
            color: #b45309;
        }

        .recibido {
            color: #15803d;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header" style="display: flex; align-items: center; gap: 15px;">

        <img src="{{ storage_path('app/public/imageSistem/logo.jpeg') }}" width="80">

        <div>
            <div style="font-size: 24px; font-weight: bold; color: #C9A646;">
                Perfum Intense
            </div>

            <div style="font-size: 12px; color: #777;">
                Comprobante de Pedido
            </div>
        </div>

    </div>

    <!-- INFORMACIÓN -->
    <div class="info">

        <div class="box">
            <strong>Pedido #{{ $pedido->folio }}</strong><br>

            Fecha:
            {{ $pedido->created_at->format('d/m/Y H:i') }}
            <br>

            Estado:
            <span class="estado {{ strtolower($pedido->estado) }}">
                {{ ucfirst($pedido->estado) }}
            </span>
            <br>

            Atendido por:
            {{ $pedido->usuario->usuario }}
        </div>

        <div class="box">
            <strong>Proveedor:</strong><br>

            {{ $pedido->proovedor->nombre }}<br>

            Tel:
            {{ $pedido->proovedor->celular ?? 'Sin teléfono' }}
            <br>

            Correo:
            {{ $pedido->proovedor->correo ?? 'Sin correo' }}
        </div>

        <div class="box">
            <strong>Envío</strong><br>

            Paquetería:
            {{ $pedido->paqueteria }}<br>

            Guía:
            {{ $pedido->guia }}<br>

            Costo envío:
            ${{ number_format($pedido->precio_envio, 2) }}
        </div>

    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th>Perfume</th>
                <th class="right">Cantidad</th>
                <th class="right">Precio Compra</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>

        <tbody>

            @foreach($pedido->detalles as $detalle)

                <tr>

                    <td>
                        {{ 
                            ($detalle->perfume->marca->nombre ?? 'Marca eliminada') 
                            . ' ' .
                            ($detalle->perfume->nombre ?? 'Perfume eliminado')
                            . ' ' .
                            ($detalle->perfume->concentracion ?? '')
                            . ' ' .
                            ($detalle->perfume->contenido ?? '')
                            . 'ml'
                        }}
                    </td>

                    <td class="right">
                        {{ $detalle->cantidad }}
                    </td>

                    <td class="right">
                        ${{ number_format($detalle->precio_de_compra, 2) }}
                    </td>

                    <td class="right">
                        ${{ number_format($detalle->cantidad * $detalle->precio_de_compra, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total right">

        <p>
            Envío:
            ${{ number_format($pedido->precio_envio, 2) }}
        </p>

        <p>
            <strong>
                Total:
                ${{ number_format($pedido->total, 2) }}
            </strong>
        </p>

    </div>

</body>
</html>