<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body{
    font-family: 'Courier New', monospace;
    font-size: 11px;
    color: #000;
}

.ticket{
    width: 220px;
    margin: auto;
}

.logo{
    text-align: center;
    margin-bottom: 5px;
}

.logo img{
    width: 55px;
}

.title{
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-top: 5px;
}

.subtitle{
    text-align: center;
    font-size: 10px;
    color: #777;
    margin-bottom: 10px;
}

.line{
    border-top: 1px dashed #999;
    margin: 8px 0;
}

.info{
    font-size: 10px;
    margin-bottom: 5px;
}

.product{
    margin-bottom: 8px;
}

.product-name{
    font-weight: bold;
    font-size: 11px;
}

.product-details{
    display: flex;
    justify-content: space-between;
    font-size: 10px;
}

.totals{
    font-size: 11px;
}

.total-final{
    font-weight: bold;
    font-size: 13px;
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
}

.footer{
    text-align: center;
    font-size: 10px;
    margin-top: 10px;
}
</style>
</head>

<body>

 <div class="ticket">

    <div class="logo">
        <img src="{{ public_path('storage/imageSistem/logo.jpeg') }}">
    </div>

    <div class="title">PERFUM INTENSE</div>

    <div class="line"></div>

    <div class="info">
        Venta #{{ $venta->folio }}<br>
        {{ $venta->created_at->format('d/m/Y H:i') }}<br>
        Atendió: {{ $venta->usuario->usuario }}
    </div>

    <div class="line"></div>

    @php
        $items = collect();

        // perfumes
        foreach($venta->detalles as $d){
            $items->push([
                'nombre' => ($d->perfume->marca->nombre . ' ' . $d->perfume->nombre . ' ' . $d->perfume->concentracion ?? 'Perfume eliminado'),
                'cantidad' => $d->cantidad,
                'precio' => $d->precio_unitario,
                'subtotal' => $d->subtotal
            ]);
        }

        // decants
        foreach($venta->detallesDecants as $d){
            $items->push([
                'nombre' => ($d->decant->perfume->marca->marca . ' ' . $d->decant->perfume->nombre . ' ' . $d->decant->perfume->concentracion ?? 'Decant eliminado') . ' ' . $d->ml . 'ml',
                'cantidad' => $d->cantidad,
                'precio' => $d->precio_unitario,
                'subtotal' => $d->subtotal
            ]);
        }
    @endphp
    @foreach($items as $item)
        <div class="product">
            <div class="product-name">{{ $item['nombre'] }}</div>
            <div class="product-details">
                <span>{{ $item['cantidad'] }} x ${{ number_format($item['precio'],2) }}</span>
                <span>${{ number_format($item['subtotal'],2) }}</span>
            </div>
        </div>
    @endforeach
    <div class="line"></div>

    <div class="totals">
        <div class="product-details">
            <span>Subtotal</span>
            <span>${{ number_format($venta->total,2) }}</span>
        </div>

        <div class="product-details">
            <span>IVA</span>
            <span>$0.00</span>
        </div>

        <div class="total-final">
            <span>TOTAL</span>
            <span>${{ number_format($venta->total,2) }}</span>
        </div>
    </div>

    <div class="line"></div>

    <div class="footer">
        Cliente: {{ $venta->cliente->nombre }}<br>
        Gracias por tu compra<br>
        www.perfumintense.com
    </div>

</div>

</body>
</html>