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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ...existing code...
    }
    // ...existing code...
}
