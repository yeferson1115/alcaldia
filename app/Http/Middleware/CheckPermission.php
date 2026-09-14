<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, string $permission)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (!Auth::user()->hasPermissionTo($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
