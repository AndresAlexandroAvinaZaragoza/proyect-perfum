<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PrecioDecant;
use App\Models\Decant;

class InventarioDecants extends Model
{
    protected $table = 'inventario_decants';

    protected $fillable = [
        'decant_id',
        'precio_decant_id',
        'stock',
        'user_id',
        'empresa_id',
    ];

    public function precioDecant()
    {
        return $this->belongsTo(
            PrecioDecant::class,
            'precio_decant_id'
        );
    }


    public function decant()
    {
        return $this->belongsTo(Decant::class, 'decant_id');
    }

    public function precios_decants()
    {
        return $this->belongsTo(PrecioDecant::class, 'precio_decant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perfume(){
        return $this->belongsTo(Perfume::class, 'perfume_id');
    }

    public function inventario(){
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function detalleVentaDecants()
    {
        return $this->hasMany(DetalleVentaDecant::class, 'inventario_decant_id');
    }
}
