<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
{
    // Vérifie si l'utilisateur est authentifié
    if (!Auth::check()) {
        abort(403, 'Accès non autorisé');
    }

    // Vérifie si l'utilisateur a le rôle requis
    if (Auth::user()->role !== $role) {
        abort(403, 'Accès non autorisé');
    }

    return $next($request);
}
}
