<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perfume extends Model
{
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
}
