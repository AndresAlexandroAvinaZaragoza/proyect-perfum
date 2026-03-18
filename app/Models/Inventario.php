<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventario extends Model
{
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
}
