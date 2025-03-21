<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Middleware d'authentification pour le tableau de bord
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user(); 
        
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // Routes pour l'admin avec middleware de rôle
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Routes pour l'utilisateur avec middleware de rôle
    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    });

    
});
