<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubEvento extends Model
{
	protected $table = 'sub_eventos'; // Ajusta el nombre si tu tabla es diferente
	protected $fillable = [
		'id','nombre', 'descripcion', 'fecha', 'activo'
	];
}
