<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    protected $fillable = [
        'deuda_total',
        'abonado',
        'faltante',
        'estatus',
        'cliente_id',
        'venta_id',
        'empresa_id',
        'user_id'
    ];
    
    public function ultimoAbono()
    {
        // Cambia 'deuda_id' y 'fecha_abono' por los nombres reales de tus columnas
        return $this->hasOne(AbonoRegistro::class, 'deuda_id')->latestOfMany('created_at');
    }

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

    public function AbonoRegistro()
    {
        return $this->hasMany(AbonoRegistro::class);
    }
}
