<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoObservacion extends Model
{
    protected $fillable = [
        'evento_id', 'observacionesJSON', 'activo'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
