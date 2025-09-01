<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    /**
     * Simula el login con Google para desarrollo/debug.
     */
    public function debugLogin()
    {
        $dummyUser = [
            'id' => '1',
            'name' => 'Usuario Dummy Echoes',
            'email' => 'echoes@echoes.cl',
            'avatar' => 'https://i.pravatar.cc/150?img=3',
            'google_id' => '1234567890',
        ];
        $user = User::firstOrCreate([
            'email' => $dummyUser['email'],
        ], [
            'name' => $dummyUser['name'],
            'google_id' => $dummyUser['google_id'],
            'avatar' => $dummyUser['avatar'],
            'password' => bcrypt('dummy_password')
            //'is_admin' => false
        ]);

        // Validar si el usuario es administrador y está activo
        //$isAdmin = false;
        //$admin = \App\Models\Administrador::where('user_id', $user->id)->where('activo', true)->first();
        //if ($admin) { $isAdmin = true; }

        info('Usuario logueado', ['id' => $user->id, 'is_admin' => $user->is_admin]);
        
        //$user->is_admin = $isAdmin;
        Auth::login($user);
        return redirect('/home')->with('success', 'Login de debug exitoso.');
    }

    public function redirectToGoogle()
    {
        // Si estamos en entorno local, redirigir a la ruta de debug
        if (app()->environment('local') || request()->getHost() === 'localhost') {
            return redirect('/auth/google/debug');
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::firstOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt('dummy_password'),
                "is_admin" => false
            ]);

            // Validar si el usuario es administrador y está activo
            $isAdmin = false;
            $admin = \App\Models\Administrador::where('user_id', $user->id)->where('activo', true)->first();
            if ($admin) { $isAdmin = true; }
            
            $user->is_admin = $isAdmin;
            Auth::login($user);
            return redirect('/home');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Error autenticando con Google.');
        }
    }
}
