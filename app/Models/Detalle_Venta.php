<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    // Relación con Venta 
    protected $fillable = [
    'venta_id',
    'perfume_id',
    'cantidad',
    'precio_unitario',
    'subtotal',
    'empresa_id'
    ];
}
