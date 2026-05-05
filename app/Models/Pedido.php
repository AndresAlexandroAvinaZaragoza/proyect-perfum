<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'folio',
        'estado',
        'guia',
        'precio_envio',
        'paqueteria',
        'total',
        'proovedor_id',
        'user_id',
        'empresa_id',
    ];
}