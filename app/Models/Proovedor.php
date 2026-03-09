<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proovedor extends Model
{
    protected $table = 'proovedores';
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 
}
