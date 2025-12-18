<?php

namespace App\Http\Controllers;


use App\Services\LayananAngsuran;
use Illuminate\Http\Request;

class RiwayatPinjamanController extends Controller
{
    protected $layananAngsuran;

    public function __construct(LayananAngsuran $layananAngsuran)
    {
        $this->layananAngsuran = $layananAngsuran;
    }

    public function index()
    {
        $riwayatPinjaman = $this->layananAngsuran->getAllRiwayatPinjaman();
        
        return view('teller.pinjaman.riwayat-pinjaman.index', compact('riwayatPinjaman'));
    }

    public function show($id)
    {
        $riwayatPinjaman = $this->layananAngsuran->getRiwayatPinjamanById($id);
        
        return view('teller.pinjaman.riwayat-pinjaman.show', compact('riwayatPinjaman'));
    }
}