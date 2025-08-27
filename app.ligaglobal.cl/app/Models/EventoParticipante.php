<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoParticipante extends Model
{
    protected $fillable = [
        'evento_id', 'evento_sub_evento_id', 'user_id', 'descripcion', 'activo'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
    public function subEvento()
    {
        return $this->belongsTo(EventoSubEvento::class, 'evento_sub_evento_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
