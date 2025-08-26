<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administradores = \App\Models\Administrador::with('usuario')->orderBy('id', 'desc')->get();
        return view('administradores.index', compact('administradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('administradores.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'caracteristicasJSON' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        \App\Models\Administrador::create($validated);
        return redirect()->route('administradores.index')->with('success', 'Administrador registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = \App\Models\Administrador::with('usuario')->findOrFail($id);
        return view('administradores.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = \App\Models\Administrador::findOrFail($id);
        $usuarios = \App\Models\User::orderBy('name')->get();
        return view('administradores.edit', compact('admin', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = \App\Models\Administrador::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'caracteristicasJSON' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);
        $admin->update($validated);
        return redirect()->route('administradores.index')->with('success', 'Administrador actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = \App\Models\Administrador::findOrFail($id);
        $admin->activo = 0;
        $admin->save();
        return redirect()->route('administradores.index')->with('success', 'Administrador desactivado correctamente.');
    }
}
