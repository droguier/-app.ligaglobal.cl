<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = \App\Models\Evento::query();
        if (request('nombre')) {
            $query->where('nombre', 'like', '%' . request('nombre') . '%');
        }
        if (request('fecha_evento')) {
            $query->whereDate('fecha_evento', request('fecha_evento'));
        }
        // Por defecto solo mostrar activos, salvo que se filtre explicitamente
        if (request()->has('activo')) {
            if (request('activo') !== '') {
                $query->where('activo', request('activo'));
            }
        } else {
            $query->where('activo', 1);
        }
        $eventos = $query->orderBy('fecha_evento', 'desc')->get();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eventos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        \App\Models\Evento::create($validated);
        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $evento = \App\Models\Evento::findOrFail($id);
        return view('eventos.show', compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $evento = \App\Models\Evento::findOrFail($id);
        return view('eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $evento = \App\Models\Evento::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        $evento->update($validated);
        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $evento = \App\Models\Evento::findOrFail($id);
    $evento->activo = 0;
    $evento->save();
    return redirect()->route('eventos.index')->with('success', 'Evento desactivado correctamente.');
    }
}
