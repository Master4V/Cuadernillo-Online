<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta área');
        }

        return $next($request);
    }
}