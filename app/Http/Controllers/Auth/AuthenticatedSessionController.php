<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
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
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Redirección basada en roles - versión más segura
        $user = Auth::user(); // Obtenemos el usuario autenticado
        
        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => __('auth.failed')
            ]);
        }

        switch ($user->role) {
            case 'alumno':
                return redirect()->intended(route('alumno.dashboard'));
            case 'profesor':
                return redirect()->intended(route('profesor.dashboard'));
            default:
            return redirect()->intended(RouteServiceProvider::class)->redirectTo(); // return redirect()->intended(app(\App\Providers\RouteServiceProvider::class)->redirectTo());
        }
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