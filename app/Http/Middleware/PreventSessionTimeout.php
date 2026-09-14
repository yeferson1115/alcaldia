<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PreventSessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Por ejemplo, si el usuario tiene ID 1
            if ($user->id === 1 || $user->id === 3 || $user->id === 5 || $user->id === 6 || $user->id === 8 || $user->id === 9) { 
                // Establece un tiempo de sesión muy largo
                Config::set('session.lifetime', 525600); // 1 año
            }
        }

        return $next($request);
    }
}
