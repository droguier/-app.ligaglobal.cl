<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class KhanamiryanController extends Controller
{
    public function showForm()
    {
        return view('qr.khanamiryan');
    }

    public function decode(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);
        if (!$request->hasFile('image')) {
            return back()->with('error', 'No se ha subido ningún archivo.');
        }
        $image = $request->file('image');
        $realPath = $image->getRealPath();
        $qrResult = null;
        try {
            // Uso de la librería khanamiryan/qrcode-detector-decoder
            $qrcode = new \Zxing\QrReader($realPath);
            $qrResult = $qrcode->text();
            if (!$qrResult) {
                $qrResult = 'No se detectó QR.';
            }
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al leer QR: ' . $e->getMessage());
        }
        return view('qr.khanamiryan', [
            'qrResult' => $qrResult,
        ]);
    }
}
