<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
}
