<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Redirect based on role
                switch ($user->role) {
                    case 1: // Teller
                        return redirect()->route('teller.dashboard');
                    case 2: // Manajer
                        return redirect()->route('manajer.dashboard');
                    case 3: // Nasabah
                        return redirect()->route('nasabah.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}