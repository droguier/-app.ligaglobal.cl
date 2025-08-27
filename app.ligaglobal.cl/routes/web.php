
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SubEventoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('/eventos', EventoController::class)->names('eventos');
Route::resource('/sub-eventos', SubEventoController::class)->names('sub-eventos');
Route::resource('/usuarios', App\Http\Controllers\UsuarioController::class)->names('usuarios');
Route::resource('/participantes', App\Http\Controllers\ParticipanteController::class)->names('participantes');

// Endpoint para AJAX: obtener subeventos por evento
Route::get('/eventos/{evento}/subeventos', function($eventoId) {
    $subeventos = \App\Models\EventoSubEvento::where('evento_id', $eventoId)->orderBy('nombre')->get(['id', 'nombre']);
    return response()->json($subeventos);
})->name('eventos.subeventos');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');