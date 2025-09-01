<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Entrando a AdminMiddleware handle', ['user_id' => Auth::id()]);
        
        if (!Auth::guard($guards[0] ?? null)->check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();        
        info('Entrando a AdminMiddleware handle', ['id' => $user->id, 'is_admin' => $user->is_admin]);

        //Log::info('AdminMiddleware user info: ' . json_encode($user));
        //if (!$user || !$user->is_admin) {
        //    abort(403, 'Acceso solo para administradores');
        //}
        return $next($request);
    }
}
