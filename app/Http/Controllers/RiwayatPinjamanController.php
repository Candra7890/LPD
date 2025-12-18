<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPinjaman;
use Illuminate\Http\Request;

class RiwayatPinjamanController extends Controller
{
    public function index()
    {
        $riwayatPinjaman = RiwayatPinjaman::with(['pengguna', 'pinjaman', 'pinjaman_aktif'])
            ->orderBy('tanggal_pelunasan', 'desc')
            ->get();
        
        return view('teller.pinjaman.riwayat-pinjaman.index', compact('riwayatPinjaman'));
    }

    public function show($id)
    {
        $riwayatPinjaman = RiwayatPinjaman::with([
            'pengguna',
            'pinjaman',
            'pinjaman_aktif.agunan'
        ])->findOrFail($id);
        
        return view('teller.pinjaman.riwayat-pinjaman.show', compact('riwayatPinjaman'));
    }
}