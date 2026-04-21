<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'nombre',
        'guia',
        'paqueteria',
        'proovedor_id',
        'user_id',
        'empresa_id'
    ];

    // RELACIONES

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proovedor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
