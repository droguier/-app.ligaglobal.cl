<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view('LigaGlobal::usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('LigaGlobal::usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('LigaGlobal::usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
        ]);
        if ($validated['password']) {
            $usuario->password = bcrypt($validated['password']);
        }
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->save();
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->activo = 0;
        $usuario->updated_at = now();
        $usuario->save();
        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}
