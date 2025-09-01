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
        $filtros = [
            'nombre' => request('nombre'),
            'fecha_evento_desde' => request('fecha_evento_desde'),
            'fecha_evento_hasta' => request('fecha_evento_hasta'),
            'activo' => request('activo')
        ];

        if (empty(request()->all())) 
        {
            $filtros['activo'] = "1";
            $filtros['fecha_evento_desde'] = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        }

        $query = \App\Models\Evento::query();
        if ($filtros['nombre']) {
            $query->where('nombre', 'like', '%' . $filtros['nombre'] . '%');
        }

        if ($filtros['fecha_evento_desde']) {
            $query->whereDate('fecha_evento', '>=', $filtros['fecha_evento_desde']);
        }
        if ($filtros['fecha_evento_hasta']) {
            $query->whereDate('fecha_evento', '<=', $filtros['fecha_evento_hasta']);
        }

        // Filtrar por activo solo si se selecciona una opción
        if ($filtros['activo']) {
            $query->where('activo', $filtros['activo']);
        }

        $eventos = $query->orderBy('fecha_evento', 'desc')->get();

        $pageTitle = 'Eventos | Liga Global';
        return view('LigaGlobal::eventos.index', compact('eventos', 'pageTitle', 'filtros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Crear Evento | Liga Global';
        return view('LigaGlobal::eventos.create', compact('pageTitle'));
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
        
        $pageTitle = 'Editar Evento | Liga Global';
        return view('LigaGlobal::eventos.edit', compact('evento', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_evento' => 'required|date',
            'activo' => 'required|boolean',
        ]);
        $evento = \App\Models\Evento::findOrFail($id);
        $evento->update($validated);
        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }
    
    public function destroy(Evento $evento)
    {
        $evento->activo = 0;
        $evento->updated_at = now();
        $evento->save();
        return redirect()->route('eventos.index')->with('success', 'Evento desactivado correctamente.');
    }
}
