<?php

namespace App\Http\Controllers;


use App\Services\LayananAngsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TunggakanPinjamanController extends Controller
{
    protected $layananAngsuran;

    public function __construct(LayananAngsuran $layananAngsuran)
    {
        $this->layananAngsuran = $layananAngsuran;
    }

    public function index()
    {
        $pinjamanTunggakan = $this->layananAngsuran->getPinjamanMenunggak();
        
        return view('teller.pinjaman.tunggakan.index', compact('pinjamanTunggakan'));
    }
    
    public function show($id)
    {
        $pinjamanAktif = $this->layananAngsuran->getPinjamanAktifById($id);
        
        // Manual loading of jadwal_angsuran (filtered) if not supported by getPinjamanAktifById directly
        // Or we can assume getPinjamanAktifById might not load specific filtered relations.
        // Let's reload just the needed relation or filter from existing if loaded?
        // Actually getPinjamanAktifById loads 'pengguna', 'pinjaman', 'pengajuan', 'agunan'.
        // It does NOT load 'jadwal_angsuran'.
        // So we load it here.
        $jadwalTunggakan = $pinjamanAktif->jadwal_angsuran()
            ->where('status', 3)
            ->orderBy('angsuran_ke', 'asc')
            ->get();
            
        $totalAngsuranTunggak = $jadwalTunggakan->sum('sisa_belum_terbayar');
        $totalDendaTunggak = $jadwalTunggakan->sum(function($jadwal) {
            return floatval($jadwal->denda) - floatval($jadwal->denda_terbayar);
        });
        
        return view('teller.pinjaman.tunggakan.show', compact(
            'pinjamanAktif',
            'jadwalTunggakan',
            'totalAngsuranTunggak',
            'totalDendaTunggak'
        ));
    }
    
    public function sitaAgunan(Request $request, $id)
    {
        $request->validate([
            'tanggal_penyitaan' => 'required|date',
            'alasan_penyitaan' => 'required|string|max:255'
        ], [
            'tanggal_penyitaan.required' => 'Tanggal penyitaan wajib diisi',
            'tanggal_penyitaan.date' => 'Format tanggal penyitaan tidak valid',
            'alasan_penyitaan.required' => 'Alasan penyitaan wajib diisi',
            'alasan_penyitaan.max' => 'Alasan penyitaan maksimal 255 karakter'
        ]);
        
        DB::beginTransaction();
        try {
            $count = $this->layananAngsuran->sitaAgunan($id, $request->all());
            
            DB::commit();
            
            $pinjamanAktif = $this->layananAngsuran->getPinjamanAktifById($id);
            $message = "Berhasil menyita {$count} agunan pada pinjaman {$pinjamanAktif->nomor_pinjaman}";
            
            return redirect()->route('teller.tunggakan-pinjaman.show', $id)
                ->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyita agunan: ' . $e->getMessage());
        }
    }
}