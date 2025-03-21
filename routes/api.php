<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    
    $token = $user->createToken('auth-token')->plainTextToken;
    
    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, // Assurez-vous que le modèle User a un champ 'role'
        ],
        'token' => $token,
        'success' => true, // Ajoutez un indicateur de succès
    ]);
});


