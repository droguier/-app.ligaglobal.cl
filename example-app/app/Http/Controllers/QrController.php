<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Libern\QRCodeReader\QRCodeReader;

class QrController extends Controller
{
    public function showForm()
    {
        return view('qr.upload');
    }

    public function decode(Request $request)
    {   
        $request->validate([
            'image' => 'required|image',
        ]);
        $image = $request->file('image');
        
        if (!$image->isValid()) {
            return back()->with('error', 'La imagen no es válida.');
        }
        
        Log::channel('infofile')->info('Request decode - files:', (array) $request->files->all());
       
        $realPath = $image->getRealPath();
        Log::channel('infofile')->info('Request decode - realPath:', ['realPath' => $realPath]);
        Log::channel('infofile')->info('Tamaño archivo:', ['size' => filesize($realPath)]);

        if (!$realPath || !file_exists($realPath)) {
            return back()->with('error', 'No se pudo leer la imagen subida.');
        } elseif (filesize($realPath) === 0) {
            return back()->with('error', 'La imagen está vacía o corrupta.');
        }
        
        // Guardar la imagen en C:\files_web\web\
        $destinationPath = 'C:\\files_web\\web\\';
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $fileName = uniqid('qr_') . '.' . $image->getClientOriginalExtension();
        $fullStoredPath = $destinationPath . $fileName;
        $image->move($destinationPath, $fileName);
        Log::channel('infofile')->info('Imagen guardada en:', ['path' => $fullStoredPath]); 

        try {
            $qrcode = new QRCodeReader();
            $qrResult = $qrcode->decode($fullStoredPath);
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al leer QR: ' . $e->getMessage());
        }

        return view('qr.upload', [
            'imgSrc' => $imgSrc,
            'qrResult' => $qrResult,
            'consoleMessage' => 'Decoding QR...'
        ]);
    }
}
