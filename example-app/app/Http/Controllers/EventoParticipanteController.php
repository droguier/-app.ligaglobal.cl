<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        $subeventos = \App\Models\EventoSubEvento::where('activo', 1)->orderBy('nombre')->get();
        $usuarios = \App\Models\User::orderBy('name')->get();
        $query = \App\Models\EventoParticipante::with(['evento', 'subEvento', 'usuario']);
        if (request('evento_id')) {
            $query->where('evento_id', request('evento_id'));
        }
        if (request('evento_sub_evento_id')) {
            $query->where('evento_sub_evento_id', request('evento_sub_evento_id'));
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
        return view('evento-participantes.index', compact('participantes', 'eventos', 'subeventos', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        $subeventos = \App\Models\EventoSubEvento::where('activo', 1)->orderBy('nombre')->get();
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('evento-participantes.create', compact('eventos', 'subeventos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'evento_sub_evento_id' => 'nullable|exists:evento_sub_eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        \App\Models\EventoParticipante::create($validated);
        return redirect()->route('evento-participantes.index')->with('success', 'Participante registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participante = \App\Models\EventoParticipante::with(['evento', 'subEvento', 'usuario'])->findOrFail($id);
        return view('evento-participantes.show', compact('participante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $participante = \App\Models\EventoParticipante::findOrFail($id);
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        $subeventos = \App\Models\EventoSubEvento::where('activo', 1)->orderBy('nombre')->get();
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('evento-participantes.edit', compact('participante', 'eventos', 'subeventos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $participante = \App\Models\EventoParticipante::findOrFail($id);
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'evento_sub_evento_id' => 'nullable|exists:evento_sub_eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        $participante->update($validated);
        return redirect()->route('evento-participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participante = \App\Models\EventoParticipante::findOrFail($id);
        $participante->activo = 0;
        $participante->save();
        return redirect()->route('evento-participantes.index')->with('success', 'Participante desactivado correctamente.');
    }
}
