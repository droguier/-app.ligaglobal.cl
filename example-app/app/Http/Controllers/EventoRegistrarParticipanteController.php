<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoRegistrarParticipanteController extends Controller
{
    public function store(Request $request, $evento)
    {
        $user = auth()->user();
        // Puedes validar si ya está inscrito, etc.
        $participante = \App\Models\EventoParticipante::create([
            'evento_id' => $evento,
            'user_id' => $user->id,
            'descripcion' => $request->input('descripcion'),
            'activo' => true,
        ]);
        return redirect()->back()->with('success', 'Participante registrado correctamente.');
    }
}
