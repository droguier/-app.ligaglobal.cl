<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventoSubEvento;
use App\Models\EventoParticipante;
use App\Models\User;

class ParticipanteController extends Controller
{
    public function index()
    {        
        $eventos = Evento::orderBy('nombre')->get();
        $subeventos = EventoSubEvento::orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::orderBy('name')->get();
        $query = EventoParticipante::with(['evento', 'subEvento', 'usuario']);
        if (request('evento_id')) {
            $query->where('evento_id', request('evento_id'));
        }
        if (request('sub_evento_id')) {
            $query->where('sub_evento_id', request('sub_evento_id'));
        }
        if (request('user_id')) {
            $query->where('user_id', request('user_id'));
        }
        if (request()->has('activo')) {
            if (request('activo') !== '') {
                $query->where('activo', request('activo'));
            }
        } else {
            $query->where('activo', 1);
        }
        $participantes = $query->orderBy('id', 'desc')->get();
        return view('LigaGlobal::participantes.index', compact('participantes', 'eventos', 'subeventos', 'usuarios'));
    }

    public function create()
    {
        $eventos = Evento::orderBy('nombre')->get();
        $subeventos = EventoSubEvento::orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::orderBy('name')->get();
        return view('LigaGlobal::participantes.create', compact('eventos', 'subeventos', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'evento_sub_evento_id' => 'nullable|exists:evento_sub_eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        // Mapear el nombre del campo del formulario al de la base de datos
        //$validated['evento_sub_evento_id'] = $validated['sub_evento_id'] ?? null;
        //unset($validated['sub_evento_id']);
        EventoParticipante::create($validated);
        return redirect()->route('participantes.index')->with('success', 'Participante registrado correctamente.');
    }

    public function edit(EventoParticipante $participante)
    {
        $eventos = Evento::orderBy('nombre')->get();
        $subeventos = EventoSubEvento::orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::orderBy('name')->get();
        return view('LigaGlobal::participantes.edit', compact('participante', 'eventos', 'subeventos', 'usuarios'));
    }

    public function update(Request $request, EventoParticipante $participante)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'evento_sub_evento_id' => 'nullable|exists:evento_sub_eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        //$validated['evento_sub_evento_id'] = $validated['sub_evento_id'] ?? null;
        //unset($validated['sub_evento_id']);
        $participante->update($validated);
        return redirect()->route('participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    public function destroy(EventoParticipante $participante)
    {
        $participante->activo = 0;
        $participante->updated_at = now();
        $participante->save();
        return redirect()->route('participantes.index')->with('success', 'Participante desactivado correctamente.');
    }
}
