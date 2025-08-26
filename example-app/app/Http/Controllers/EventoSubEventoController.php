<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoSubEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        $query = \App\Models\EventoSubEvento::with('evento');
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
        return view('evento-sub-eventos.index', compact('subeventos', 'eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        return view('evento-sub-eventos.create', compact('eventos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        \App\Models\EventoSubEvento::create($validated);
        return redirect()->route('evento-sub-eventos.index')->with('success', 'Sub-evento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subevento = \App\Models\EventoSubEvento::with('evento')->findOrFail($id);
        return view('evento-sub-eventos.show', compact('subevento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subevento = \App\Models\EventoSubEvento::findOrFail($id);
        $eventos = \App\Models\Evento::where('activo', 1)->orderBy('nombre')->get();
        return view('evento-sub-eventos.edit', compact('subevento', 'eventos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subevento = \App\Models\EventoSubEvento::findOrFail($id);
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        $subevento->update($validated);
        return redirect()->route('evento-sub-eventos.index')->with('success', 'Sub-evento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subevento = \App\Models\EventoSubEvento::findOrFail($id);
        $subevento->activo = 0;
        $subevento->save();
        return redirect()->route('evento-sub-eventos.index')->with('success', 'Sub-evento desactivado correctamente.');
    }
}
