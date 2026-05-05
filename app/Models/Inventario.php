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
}
