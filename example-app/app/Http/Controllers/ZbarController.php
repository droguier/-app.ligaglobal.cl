<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use TarfinLabs\ZbarPhp\Exceptions\ZbarError;
use TarfinLabs\ZbarPhp\Zbar;

class ZbarController extends Controller
{
    public function showForm()
    {
        return view('qr.zbar');
    }

    public function decode(Request $request)
    {
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
        try { 
        $fileName = uniqid('qr_') . '.' . $image->getClientOriginalExtension();
        $fullStoredPath = $destinationPath . $fileName;
        $image->move($destinationPath, $fileName);
        Log::channel('infofile')->info('Imagen guardada en:', ['path' => $fullStoredPath]); 

        $image = $request->file('image');
        $realPath = $image->getRealPath();
            // Aquí deberías implementar la lógica usando ZBar
            // Por ahora, solo mostramos un mensaje de ejemplo
            // Ejecutar ZBar desde línea de comandos (requiere zbarimg instalado en el sistema)
            $output = null;
            $returnVar = null;
            $command = 'zbarimg ' . escapeshellarg($realPath) . ' 2>&1';
            exec($command, $output, $returnVar);
            $qrResult = 'No se detectó QR.';
            if ($returnVar === 0 && !empty($output)) {
                // El resultado de zbarimg suele ser: "QR-Code:contenido"
                $qrResult = implode("\n", $output);
            } elseif ($returnVar !== 0) {
                $qrResult = 'Error ZBar: ' . implode(" ", $output);
            }
            return view('qr.zbar', [
                'qrResult' => $qrResult,
            ]);

        } catch (\Throwable $e) {
            return back()->with('error', 'Error al leer QR: ' . $e->getMessage());
        }
    }
}
