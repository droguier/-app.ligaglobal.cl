<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\EventoSubEvento;
use App\Models\EventoParticipante;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ParticipanteController extends Controller
{
    public function index()
    {
        $filtros = [
            'evento_id' => request('evento_id'),
            'sub_evento_id' => request('sub_evento_id'),
            'user_id' => request('user_id'),
            'activo' => request('activo')
        ];

        if (empty(request()->all())) {
            $filtros['activo'] = "1";
        }

        $eventos = Evento::orderBy('nombre')->get();
        $subeventos = EventoSubEvento::orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::orderBy('name')->get();

        $query = EventoParticipante::with(['evento', 'subEvento', 'usuario']);
        if ($filtros['evento_id']) {
            $query->where('evento_id', $filtros['evento_id']);
        }
        if ($filtros['sub_evento_id']) {
            $query->where('sub_evento_id', $filtros['sub_evento_id']);
        }
        if ($filtros['user_id']) {
            $query->where('user_id', $filtros['user_id']);
        }
        if (isset($filtros['activo'])) {
            if ($filtros['activo'] !== '') {
                $query->where('activo', $filtros['activo']);
            }
        }

        $participantes = $query->orderBy('id', 'desc')->get();

        $pageTitle = 'Participantes | Liga Global';
        return view('LigaGlobal::participantes.index', compact('participantes', 'eventos', 'subeventos', 'usuarios', 'pageTitle', 'filtros'));
    }

    public function create()
    {
        $eventos = Evento::orderBy('nombre')->get();
        $subeventos = EventoSubEvento::orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::orderBy('name')->get();
        $pageTitle = 'Crear Participante | Liga Global';
        return view('LigaGlobal::participantes.create', compact('eventos', 'subeventos', 'usuarios', 'pageTitle'));
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
        
        EventoParticipante::create($validated);
        return redirect()->route('participantes.index')->with('success', 'Participante registrado correctamente.');
    }

    public function edit(string $id)
    {
        $participante = EventoParticipante::findOrFail($id);
        
        $eventos = Evento::where('id', $participante->evento_id)->orderBy('nombre')->get();
        $subeventos = EventoSubEvento::where('id', $participante->evento_sub_evento_id)->orderBy('nombre')->get();
        if ($subeventos->isEmpty()) {
            $subeventos = null;
        }
        $usuarios = User::where('id', $participante->user_id)->orderBy('name')->get();

        $pageTitle = 'Editar Participante | Liga Global';
        return view('LigaGlobal::participantes.edit', compact('participante', 'eventos', 'subeventos', 'usuarios', 'pageTitle'));
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

    public function inscribir_modal($eventoId)
    {
        $evento = Evento::where('id', $eventoId)->orderBy('nombre')->first();
        $subeventos = EventoSubEvento::where('evento_id', $eventoId)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);
            
        $usuarios = User::orderBy('name')->get();
        $pageTitle = 'Registrar Participante -  | Liga Global';

        Log::info('inscribir_modal user info: ' . json_encode($evento));

        return view('LigaGlobal::participantes.inscribir', compact('evento', 'subeventos', 'usuarios', 'pageTitle'));
    }

    public function inscribir_guardar(Request $request)
    {
        $validated = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'evento_sub_evento_id' => 'nullable|exists:evento_sub_eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        EventoParticipante::create($validated);
        return redirect()->route('participantes.index')->with('success', 'Participante registrado correctamente por evento.');
    }
}
