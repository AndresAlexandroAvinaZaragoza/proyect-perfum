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
}
