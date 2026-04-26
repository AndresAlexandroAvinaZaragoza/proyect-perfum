<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'folio',
        'guia',
        'precio_envio',
        'paqueteria',
        'total',
        'proovedor_id',
        'user_id',
        'empresa_id',
        'estado'
    ];

    // RELACIONES

public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    public function proovedor()
    {
        return $this->belongsTo(Proovedor::class, 'proovedor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
