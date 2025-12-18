<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        // Redirect ke view sesuai role
        switch ($user->role) {
            case 1: // Teller
                return view('teller.dashboard');
                
            case 2: // Manajer
                return view('manajer.dashboard');
                
            default:
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Role tidak valid');
        }
    }
}