<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventoSubEvento;
use App\Models\Evento;

class SubEventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderBy('nombre')->get();
        $query = EventoSubEvento::with('evento');
        if (request('evento_id')) {
            $query->where('evento_id', request('evento_id'));
        }
        if (request('nombre')) {
            $query->where('nombre', 'like', '%' . request('nombre') . '%');
        }
        if (request('fecha_evento')) {
            $query->whereDate('fecha_evento', request('fecha_evento'));
        }
        if (request()->has('activo')) {
            if (request('activo') !== '') {
                $query->where('activo', request('activo'));
            }
        } else {
            $query->where('activo', 1);
        }
        $subeventos = $query->orderBy('fecha_evento', 'desc')->get();
        return view('LigaGlobal::sub-eventos.index', compact('subeventos', 'eventos'));
    }

    public function create()
    {
        $eventos = Evento::orderBy('nombre')->get();
        return view('LigaGlobal::sub-eventos.create', compact('eventos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        EventoSubEvento::create($validated);
        return redirect()->route('sub-eventos.index')->with('success', 'Sub-Evento creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subevento = \App\Models\EventoSubEvento::findOrFail($id);
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        return view('LigaGlobal::sub-eventos.edit', compact('subevento', 'eventos'));
    }

    public function update(Request $request, EventoSubEvento $subevento)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        $subevento->update($validated);
        return redirect()->route('sub-eventos.index')->with('success', 'Sub-Evento actualizado correctamente.');
    }

    public function destroy(EventoSubEvento $subevento)
    {
        $subevento->delete();
        $subevento->activo = 0;
        $subevento->updated_at = now();
        $subevento->save();
        return redirect()->route('sub-eventos.index')->with('success', 'Sub-Evento desactivado correctamente.');
    }
}
