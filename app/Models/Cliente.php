<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;
        public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 

        public function ultimoAbono()
    {
        return $this->hasOne(AbonoRegistro::class, 'deuda_id')->latestOfMany('created_at');
    }

    public function deuda()
    {
        return $this->belongsTo(Deuda::class);
    }


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function abonos()
    {
        return $this->hasMany(AbonoRegistro::class, 'deuda_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

}
