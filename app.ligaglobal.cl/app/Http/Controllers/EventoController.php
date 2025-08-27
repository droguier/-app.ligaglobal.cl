<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Evento;
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
        return view('LigaGlobal::eventos.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('LigaGlobal::eventos.create');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $evento = \App\Models\Evento::findOrFail($id);
        return view('LigaGlobal::eventos.edit', compact('evento'));
    }

    public function destroy(Evento $evento)
    {
        $evento->activo = 0;
        $evento->updated_at = now();
        $evento->save();
        return redirect()->route('eventos.index')->with('success', 'Evento desactivado correctamente.');
    }
}
