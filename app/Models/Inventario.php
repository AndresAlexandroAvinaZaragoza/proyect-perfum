<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
    
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function perfume(): BelongsTo{
        return $this->belongsTo(Perfume::class);
    }

    public function inventario(): BelongsTo{
        return $this->belongsTo(Inventario::class);
    }

    public function decant(){
        return $this->hasMany(Decant::class, 'inventario_id');
    }

    public function detalle_Venta(){
        return $this->hasMany(Detalle_Venta::class, 'inventario_id');
    }


}
