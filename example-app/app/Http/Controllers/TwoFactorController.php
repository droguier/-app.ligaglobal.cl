<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use App\Models\User;

class TwoFactorController extends Controller
{
    // Mostrar formulario para activar 2FA
    public function show2faForm(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        if (!$user->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $secret = $user->google2fa_secret;
        }
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );
        return view('2fa.activate', [
            'user' => $user,
            'QR_Image' => $QR_Image,
            'secret' => $secret
        ]);
    }

    // Validar código 2FA
    public function validate2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);
        if ($valid) {
            // Aquí puedes marcar el 2FA como activado (opcional)
            return redirect()->route('home')->with('success', '2FA verificado correctamente.');
        } else {
            return back()->with('error', 'Código 2FA inválido.');
        }
    }
}
