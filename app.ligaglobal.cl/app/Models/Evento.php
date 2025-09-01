<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'id','nombre', 'descripcion', 'fecha_evento', 'activo'
    ];

    public function subEventos()
    {
        return $this->hasMany(EventoSubEvento::class);
    }
    public function participantes()
    {
        return $this->hasMany(EventoParticipante::class);
    }
    public function observaciones()
    {
        return $this->hasMany(EventoObservacion::class);
    }
}
