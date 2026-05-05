<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfume extends Model
{
    use HasFactory;
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 


    public function ventas(): BelongsToMany
    {
        return $this->belongsToMany(Venta::class, 'detalle__ventas', 'venta_id')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }

    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function pedidos(){
        return $this->belongsToMany(PedidosController::Class);
    }
}
