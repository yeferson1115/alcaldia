<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('username', 'password');

         // Intentar autenticar al usuario
        if (Auth::attempt($credentials,true)) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario está activo
            if (!$user->status) {
                // Si el usuario no está activo, hacer logout y lanzar una excepción

                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => 'Este usuario no está activo.',
                ]);
            }

            if ($user->id==1 || $user->id==3 || $user->id==5 || $user->id==6 || $user->id==8 || $user->id==9) {
                // Si el usuario es Admin, extender la duración de la sesión
                config(['session.lifetime' => 999999]); // Esto evitará que se cierre la sesión automáticamente
            }
           
                return redirect()->route('dashboard');
            

            
        }

        // Si las credenciales no coinciden, lanzar una excepción
        throw ValidationException::withMessages([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
