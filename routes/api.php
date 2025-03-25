<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ici, vous pouvez enregistrer les routes API pour votre application.
| Ces routes sont chargées par le RouteServiceProvider et seront
| assignées au groupe de middleware "api". Faites quelque chose de génial !
|
*/

// Route pour la connexion (login)
Route::post('/login', function (Request $request) {
    // Valider les données de la requête
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Trouver l'utilisateur par email
    $user = User::where('email', $request->email)->first();

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Créer un token pour l'utilisateur
    $token = $user->createToken('auth-token')->plainTextToken;

    // Retourner une réponse JSON avec les informations de l'utilisateur et le token
    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, // Assurez-vous que le modèle User a un champ 'role'
        ],
        'token' => $token,
        'success' => true,
    ]);
});

// Groupe de routes protégées par le middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {
    // Route pour obtenir les informations de l'utilisateur connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route pour la déconnexion (logout)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    });

    // Groupe de routes pour l'admin (protégé par le middleware 'role:admin')
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Ajoutez d'autres routes pour l'admin ici
    });

    // Groupe de routes pour l'utilisateur (protégé par le middleware 'role:user')
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
        // Ajoutez d'autres routes pour l'utilisateur ici
    });
});

// Route par défaut (page d'accueil de l'API)
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});