<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ZbarController;
use App\Http\Controllers\KhanamiryanController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\GoogleAuthController;

// =================== HOME ===================
Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
})->name('about');

// =================== USUARIOS ===================
// Listado de usuarios (requiere autenticación)
Route::get('/usuarios', function () {
    $users = User::all();
    $user = auth()->user(); // Usuario autenticado
    // Puedes acceder a $user->name, $user->email, etc.
    // Ejemplo: mostrar en la vista
    return view('usuarios.index', compact('users', 'user'));
})->middleware('auth')->name('usuarios.index');

// Formulario de creación de usuario
Route::get('/usuarios/crear', function () {
    return view('usuarios.create');
})->middleware('auth')->name('usuarios.create');

// Guardar nuevo usuario (requiere sesión activa)
Route::post('/usuarios', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);
    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
})->middleware('auth')->name('usuarios.store');

// =================== QR ===================
// QR con khanamiryan
Route::get('/qr/khanamiryan', [KhanamiryanController::class, 'showForm'])->name('qr.khanamiryan.form');
Route::post('/qr/khanamiryan', [KhanamiryanController::class, 'decode'])->name('qr.khanamiryan.decode');
// QR con libern
Route::get('/qr/upload', [QrController::class, 'showForm'])->name('qr.upload');
Route::post('/qr/decode', [QrController::class, 'decode'])->name('qr.decode');
// QR con ZBar
Route::get('/qr/zbar', [ZbarController::class, 'showForm'])->name('zbar.form');
Route::post('/qr/zbar', [ZbarController::class, 'decode'])->name('zbar.decode');

// =================== CÁMARA ===================
Route::get('/camara', function () {
    return view('camara');
})->name('camara');

// =================== 2FA (Google Authenticator) ===================
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/activate', [TwoFactorController::class, 'show2faForm'])->name('2fa.activate');
    Route::post('/2fa/validate', [TwoFactorController::class, 'validate2fa'])->name('2fa.validate');
});

// =================== LOGIN CON GOOGLE ===================
// Vista independiente para login con Google
Route::get('/login/google', function () {
    return view('auth.login-google');
})->name('login.google.view');

// Login con Google (Socialite)
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Al final de tu routes/web.php
Route::get('/login', function () {
    return redirect()->route('login.google.view');
})->name('login');