<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    
    // Relacion con Marca
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Perfume a través de Detalle_Venta
    public function perfume(): BelongsToMany
    {
        return $this->belongsToMany(Perfume::class, 'detalle__ventas', 'venta_id', 'perfume_id')
            ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }

    // Relación con Inventario
    public function inventario(): BelongsToMany
    {
        return $this->belongsToMany(Inventario::class, 'detalle__ventas', 'venta_id', 'inventario_id')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }

    public function detalles(){
        return $this->hasMany(Detalle_Venta::class);
    }

}

