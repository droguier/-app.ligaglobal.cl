<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        Log::info('Entrando a Authenticate handle', ['user_id' => Auth::id()]);

        //if (!Auth::guard($guards[0] ?? null)->check()) {
        //    return redirect()->route('login');
        //}
        //$user = Auth::user();        
        //info('Usuario rq ', ['id' => $user->id]);
        //info('Usuario rq ', ['id' => $user->id, 'is_admin' => $user->is_admin]);
        return $next($request);
    }
}
