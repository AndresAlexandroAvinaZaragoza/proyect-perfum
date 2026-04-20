<!DOCTYPE html>
<html>
<head>
    <title>Ticket</title>

    <style>
        body{
            font-family: monospace;
            width: 220px;
            margin: auto;
        }
    </style>

</head>

<body onload="imprimir()">

    <h3 style="text-align:center;">PERFUM INTENSE</h3>

    <p>Venta #{{ $venta->id }}</p>
    <p>{{ $venta->created_at->format('d/m/Y H:i') }}</p>

    <hr>

    @foreach($venta->detalles as $item)
        <p>
            {{ $item->perfume->nombre }}<br>
            {{ $item->cantidad }} x ${{ number_format($item->precio_unitario,2) }}
        </p>
    @endforeach

    <hr>

    <strong>Total: ${{ number_format($venta->total,2) }}</strong>



    <script>
    function imprimir(){
        window.focus();
        window.print();

        setTimeout(() => {
            window.close();
        }, 800);
    }
    </script>

</body>
</html>