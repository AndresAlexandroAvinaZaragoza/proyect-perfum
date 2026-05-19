<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decant extends Model
{

    public function perfume()
    {
        return $this->belongsTo(Perfume::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function inventario(){
        return $this->belongsTo(Inventario::class);
    }

    public function precios()
    {
        return $this->hasMany(PrecioDecant::class);
    }
    public function detalleVentaDecant(){
        return $this->hasMany(DetalleVentaDecant::class);
    }

    function inventarioDecants(){
        return $this->hasOne(InventarioDecants::class);
    }
}
