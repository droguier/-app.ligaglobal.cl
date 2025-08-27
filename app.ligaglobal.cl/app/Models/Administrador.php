<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';
    protected $fillable = [
        'user_id', 'caracteristicasJSON', 'activo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
