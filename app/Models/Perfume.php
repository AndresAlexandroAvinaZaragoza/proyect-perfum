<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfume extends Model
{
    use HasFactory;
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    } 



    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }


    public function decants()
    {
        return $this->hasMany(Decant::class);
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function inventarioDecants()
    {
        return $this->hasMany(InventarioDecant::class);
    }

    public function detalleVenta()
    {
        return $this->hasMany(Detalle_Venta::class);
    }

    public function DetalleVentaDEcant()
    {
        return $this->hasMany(DetalleVentaDecant::class);
    }

    


    


}
