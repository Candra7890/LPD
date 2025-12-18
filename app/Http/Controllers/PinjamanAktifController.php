<?php

namespace App\Http\Controllers;


use App\Services\LayananAngsuran;
use Illuminate\Http\Request;

class PinjamanAktifController extends Controller
{
    protected $layananAngsuran;

    public function __construct(LayananAngsuran $layananAngsuran)
    {
        $this->layananAngsuran = $layananAngsuran;
    }

    public function index()
    {
        $pinjamanAktif = $this->layananAngsuran->getAllPinjamanAktif();
        
        return view('teller.pinjaman.pinjaman-aktif.index', compact('pinjamanAktif'));
    }

    public function show($id)
    {
        $pinjamanAktif = $this->layananAngsuran->getPinjamanAktifById($id);
        
        return view('teller.pinjaman.pinjaman-aktif.show', compact('pinjamanAktif'));
    }

    public function jadwalAngsuran($id)
    {
        $pinjamanAktif = $this->layananAngsuran->getPinjamanAktifById($id);
        $jadwalAngsuran = $this->layananAngsuran->getJadwalAngsuran($id);
        
        return view('teller.pinjaman.pinjaman-aktif.jadwalangsuran', compact('pinjamanAktif', 'jadwalAngsuran'));
    }
}