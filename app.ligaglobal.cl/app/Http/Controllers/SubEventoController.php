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
        $filtros = [
            'evento_id' => request('evento_id'),
            'nombre' => request('nombre'),
            'fecha_evento_desde' => request('fecha_evento_desde'),
            'fecha_evento_hasta' => request('fecha_evento_hasta'),
            'activo' => request('activo'),
        ];

        if (empty(request()->all())) {
            $filtros['activo'] = "1";
            $filtros['fecha_evento_desde'] = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        }

        $query = EventoSubEvento::with('evento');
        if ($filtros['evento_id']) {
            $query->where('evento_id', $filtros['evento_id']);
        }
        if ($filtros['nombre']) {
            $query->where('nombre', 'like', '%' . $filtros['nombre'] . '%');
        }
        if ($filtros['fecha_evento_desde']) {
            $query->whereDate('fecha_evento', '>=', $filtros['fecha_evento_desde']);
        }
        if ($filtros['fecha_evento_hasta']) {
            $query->whereDate('fecha_evento', '<=', $filtros['fecha_evento_hasta']);
        }
        if (array_key_exists('activo', $filtros) && $filtros['activo'] !== null && $filtros['activo'] !== '') {
            $query->where('activo', $filtros['activo']);
        }
        $subeventos = $query->orderBy('fecha_evento', 'desc')->get();

        $pageTitle = 'Sub-Eventos | Liga Global';
        return view('LigaGlobal::sub-eventos.index', compact('subeventos', 'eventos', 'pageTitle', 'filtros'));
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

        // Validar si el evento del subevento existe en la lista de eventos
        $eventoDelSubevento = $eventos->where('id', $subevento->evento_id)->first();
        if (!$eventoDelSubevento) {
            // Si no existe, agregarlo manualmente
            $eventoFaltante = \App\Models\Evento::find($subevento->evento_id);
            if ($eventoFaltante) {
                $eventos->push($eventoFaltante);
            }
        }
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
        $subevento->activo = 0;
        $subevento->updated_at = now();
        $subevento->save();
        return redirect()->route('sub-eventos.index')->with('success', 'Sub-Evento desactivado correctamente.');
    }
    
    /**
     * Retorna los subeventos de un evento en formato JSON (para AJAX).
     */
    public function getByEvento($eventoId)
    {
        $subeventos = EventoSubEvento::where('evento_id', $eventoId)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);
        return response()->json($subeventos);
    }
}
