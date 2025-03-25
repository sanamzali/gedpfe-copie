<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici, vous pouvez enregistrer les routes web pour votre application.
| Ces routes sont chargées par le RouteServiceProvider et seront
| assignées au groupe de middleware "web". Faites quelque chose de génial !
|
*/

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Groupe de routes protégées par le middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // Route pour le tableau de bord (redirige en fonction du rôle)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Vérifie si l'utilisateur a un rôle valide
        if (!$user->role) {
            abort(403, 'Rôle utilisateur non défini');
        }

        // Redirige en fonction du rôle
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Groupe de routes pour l'admin (protégé par le middleware 'role:admin')
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Ajoutez d'autres routes pour l'admin ici
    });

    // Groupe de routes pour l'utilisateur (protégé par le middleware 'role:user')
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
        // Ajoutez d'autres routes pour l'utilisateur ici
    });
});

// Route par défaut (page d'accueil)
Route::get('/', function () {
    return view('welcome');
});