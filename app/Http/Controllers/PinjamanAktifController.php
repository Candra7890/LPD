<?php

namespace App\Http\Controllers;

use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use Illuminate\Http\Request;

class PinjamanAktifController extends Controller
{
    public function index()
    {
        $pinjamanAktif = PinjamanAktif::with(['pengguna', 'pinjaman', 'pengajuan_pinjaman'])
            ->orderBy('tanggal_pencairan', 'desc')
            ->get();
        
        return view('teller.pinjaman.pinjaman-aktif.index', compact('pinjamanAktif'));
    }

    public function show($id)
    {
        $pinjamanAktif = PinjamanAktif::with([
            'pengguna',
            'pinjaman',
            'pengajuan_pinjaman',
            'agunan'
        ])->findOrFail($id);
        
        return view('teller.pinjaman.pinjaman-aktif.show', compact('pinjamanAktif'));
    }

    public function jadwalAngsuran($id)
    {
        $pinjamanAktif = PinjamanAktif::with(['pengguna', 'pinjaman'])
            ->findOrFail($id);
        
        $jadwalAngsuran = JadwalAngsuran::where('pinjaman_aktif_id', $id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();
        
        return view('teller.pinjaman.pinjaman-aktif.jadwalangsuran', compact('pinjamanAktif', 'jadwalAngsuran'));
    }
}