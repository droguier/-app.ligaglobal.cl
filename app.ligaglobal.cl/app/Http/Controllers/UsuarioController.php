<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();

        $pageTitle = 'Usuarios | Liga Global';
        return view('LigaGlobal::usuarios.index', compact('usuarios', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Crear Usuario | Liga Global';
        return view('LigaGlobal::usuarios.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
                'rut' => ['required', 'string', 'max:12', 'unique:users,rut', function($attribute, $value, $fail) {
                $rut = preg_replace('/[^kK0-9]/', '', $value);
                if (strlen($rut) < 8) return $fail('El RUT es demasiado corto.');
                $body = substr($rut, 0, -1);
                $dv = strtoupper(substr($rut, -1));
                $suma = 0;
                $multiplo = 2;
                for ($i = strlen($body) - 1; $i >= 0; $i--) {
                    $suma += $body[$i] * $multiplo;
                    $multiplo = $multiplo == 7 ? 2 : $multiplo + 1;
                }
                $resto = $suma % 11;
                $dvEsperado = 11 - $resto;
                if ($dvEsperado == 11) $dvEsperado = '0';
                elseif ($dvEsperado == 10) $dvEsperado = 'K';
                else $dvEsperado = (string)$dvEsperado;
                if ($dv != $dvEsperado) {
                    return $fail('El RUT no es válido.');
                }
            }],
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:6'],
    ], [
            'rut.required' => 'El RUT es obligatorio.',
            'rut.string' => 'El RUT debe ser texto.',
            'rut.max' => 'El RUT no debe exceder 12 caracteres.',
            'rut.unique' => 'El RUT ya está registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no debe exceder 255 caracteres.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.string' => 'El apellido debe ser texto.',
            'lastname.max' => 'El apellido no debe exceder 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        $pageTitle = 'Editar Usuario | Liga Global';
        return view('LigaGlobal::usuarios.edit', compact('usuario', 'pageTitle'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no debe exceder 255 caracteres.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.string' => 'El apellido debe ser texto.',
            'lastname.max' => 'El apellido no debe exceder 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);
        if ($validated['password']) {
            $usuario->password = bcrypt($validated['password']);
        }
        $usuario->name = $validated['name'];
        $usuario->lastname = $validated['lastname'];
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
    
    public function validatepassword(Request $request, User $usuario)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        $password = $request->input('password');
        if (Hash::check($password, $usuario->password)) {
            return response()->json(['valid' => true, 'message' => 'Contraseña válida.']);
        } else {
            return response()->json(['valid' => false, 'message' => 'Contraseña incorrecta.'], 422);
        }
    }
}
