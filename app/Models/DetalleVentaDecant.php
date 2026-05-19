<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVentaDecant extends Model
{
    protected $table = 'detalle_venta_decants';

    protected $fillable = [
        'venta_id',
        'decant_id',
        'inventario_decant_id',
        'ml',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'empresa_id'
    ];

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function decant(){
        return $this->belongsTo(Decant::class);
    }

    public function inventarioDecant(){
        return $this->belongsTo(InventarioDecants::class, 'inventario_decant_id');
    }

    public function DetalleVentaDecant(){
        return $this->hasMany(DetalleVentaDecant::class);
    }
}