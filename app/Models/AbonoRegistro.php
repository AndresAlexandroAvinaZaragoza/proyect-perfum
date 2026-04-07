<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbonoRegistro extends Model
{
    protected $fillable = [
        'deuda_id',
        'abonado',
        'faltante',
        'estatus',
        'cliente_id',
        'venta_id',
        'empresa_id',
        'user_id'
    ];

    public function deuda()
    {
        return $this->belongsTo(Deuda::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
