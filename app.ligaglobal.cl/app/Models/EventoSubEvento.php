<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoSubEvento extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id', 'nombre', 'descripcion', 'fecha_evento', 'activo'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
    public function participantes()
    {
        return $this->hasMany(EventoParticipante::class, 'evento_sub_evento_id');
    }
}
