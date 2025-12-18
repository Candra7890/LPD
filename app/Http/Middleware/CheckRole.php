<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();

        // Cek apakah user aktif
        if ($user->is_active != 1) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif');
        }

        // Konversi role name ke role number
        $allowedRoles = [];
        foreach ($roles as $role) {
            switch (strtolower($role)) {
                case 'teller':
                    $allowedRoles[] = 1;
                    break;
                case 'manajer':
                    $allowedRoles[] = 2;
                    break;
                case 'nasabah':
                    $allowedRoles[] = 3;
                    break;
            }
        }

        // Cek apakah user memiliki role yang diizinkan
        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}