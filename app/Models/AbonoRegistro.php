<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbonoRegistro extends Model
{
    public function deuda()
    {
        return $this->belongsTo(Deuda::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function abonos()
    {
        return $this->hasMany(AbonoRegistro::class, 'deuda_id');
    }
}


