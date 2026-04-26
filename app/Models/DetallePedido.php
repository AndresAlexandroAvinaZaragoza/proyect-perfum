<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'perfume_id',
        'cantidad',
        'precio_de_compra',
        'empresa_id'
    ];



    public function perfume()
    {
        return $this->belongsTo(Perfume::class);
    }

    public function proovedor()
    {
        return $this->belongsTo(Proovedor::class, 'proovedor_id');
    }
    public function pedido()
    {
        return $this->belongsTo(Pedidos::class, 'pedido_id');
    }
}
