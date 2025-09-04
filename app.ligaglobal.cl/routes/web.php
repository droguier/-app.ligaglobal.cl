
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SubEventoController;
use App\Http\Controllers\ParticipanteController;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome', ['pageTitle' => 'Bienvenido a Liga Global']);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Route::middleware('auth')->group(function () {
    //eventos
    Route::resource('eventos', EventoController::class);
    //Route::resource('eventos', EventoController::class)->names('eventos.index');
    //Route::get('eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    //Route::delete('eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    //Route::put('eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    // Endpoint para AJAX: obtener subeventos por evento
    Route::get('eventos/{evento}/subeventos', [SubEventoController::class, 'getByEvento'])->name('eventos.subeventos');
    
    //subeventos
    Route::resource('/sub-eventos', SubEventoController::class)->names('sub-eventos');
    //participantes
    Route::resource('participantes', ParticipanteController::class);
    //Route::resource('participantes', ParticipanteController::class)->names('participantes.index');
    //Route::resource('participantes', ParticipanteController::class)->names('participantes.index');
    //Route::get('participantes/{participante}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
    //Route::put('participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');
    Route::get('participantes/create-by-event/{evento}/evento', [ParticipanteController::class, 'inscribir_modal'])->name('participantes.inscribir');
    Route::post('participantes/store-by-event', [ParticipanteController::class, 'inscribir_guardar'])->name('participantes.guardar');

    Route::resource('/usuarios', App\Http\Controllers\UsuarioController::class)->names('usuarios');
//});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Google Auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// Ruta de debug para simular login con Google en desarrollo
Route::get('auth/google/debug', [GoogleController::class, 'debugLogin']);

// Ruta catch-all para mostrar 404 en rutas no definidas
Route::fallback(function () {
    return view('errors.404');
});