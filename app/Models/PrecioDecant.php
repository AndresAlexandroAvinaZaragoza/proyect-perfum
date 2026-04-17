<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecioDecant extends Model
{
    protected $table = 'precios_decants';

    protected $fillable = [
        'ml',
        'precio',
        'decant_id',
        'empresa_id',
        'created_at',
        'updated_at',
    ];

    public function decant()
    {
        return $this->belongsTo(Decant::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function perfume()
    {
        return $this->belongsTo(Perfume::class, 'perfume_id');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }
}
