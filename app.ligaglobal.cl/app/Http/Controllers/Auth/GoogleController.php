<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use function Laravel\Prompts\error;

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
            'email' => 'echoes@gmail.com',
            'avatar' => 'https://i.pravatar.cc/150?img=3',
            'google_id' => '1234567890',
        ];

        $user = User::where('email', $dummyUser['email'])->first();

        if (!$user) {
            info('[Error] Usuario no logueado', ['email' => $dummyUser['email']]);
            return redirect()->route('login')->with('error', 'Error autenticando con Google.');
        }else{
            info('Usuario logueado', ['id' => $user->id, 'is_admin' => $user->is_admin]);
            //
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Login de debug exitoso.');
        }
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
            info('GoogleUser logueado: ' . json_encode($googleUser));
            // Buscar usuario solo por email, asegurando que sea único
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                info('[Error] Usuario no logueado', $googleUser->getEmail());
                return redirect()->route('login')->with('error', 'Error autenticando con Google.');
            }else{
                $user->google_id = $googleUser->getId();
                $user->avatar = $googleUser->getAvatar();
                $user->save();

                info('Usuario logueado', ['id' => $user->id, 'is_admin' => $user->is_admin]);
                //
                Auth::login($user);
                return redirect()->route('home')->with('success', 'Login de debug exitoso.');
            }

        } catch (\Exception $e) {
            info('[Error] Usuario no logueado', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Error autenticando con Google.');
        }
    }
}
