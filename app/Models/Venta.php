<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    protected $fillable = [
    'cliente_id',
    'total',
    'tipo_venta',
    'articulos',
    'user_id',
    'empresa_id'
]   ;
    
    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Perfume a través de Detalle_Venta
    public function perfume()
    {
        return $this->belongsToMany(Perfume::class, 'detalle_venta', 'venta_id', 'perfume_id')
                    ->withPivot('cantidad', 'precio', 'subtotal');
    }

    // Relación con Inventario
    public function inventario()
    {
        return $this->belongsToMany(Inventario::class, 'detalle_venta', 'venta_id', 'inventario_id')
                    ->withPivot('cantidad', 'precio', 'subtotal');
    }
}
