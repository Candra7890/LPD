<?php

namespace App\Http\Controllers;

use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use App\Models\Agunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TunggakanPinjamanController extends Controller
{
    public function index()
    {
        $pinjamanTunggakan = PinjamanAktif::with(['pengguna', 'pinjaman', 'agunan'])
            ->where('status', 2) // Status menunggak
            ->orderBy('hari_tunggakan', 'desc')
            ->get();
        
        return view('teller.pinjaman.tunggakan.index', compact('pinjamanTunggakan'));
    }
    
    public function show($id)
    {
        $pinjamanAktif = PinjamanAktif::with([
            'pengguna',
            'pinjaman',
            'agunan',
            'jadwal_angsuran' => function($query) {
                $query->where('status', 3)->orderBy('angsuran_ke', 'asc');
            }
        ])->findOrFail($id);
        
        $jadwalTunggakan = $pinjamanAktif->jadwal_angsuran;
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
            $pinjamanAktif = PinjamanAktif::with('agunan')->findOrFail($id);
            
            if ($pinjamanAktif->agunan->isEmpty()) {
                return redirect()->back()->with('error', 'Pinjaman ini tidak memiliki agunan yang dapat disita');
            }
            
            if ($pinjamanAktif->status != 2) {
                return redirect()->back()->with('error', 'Hanya pinjaman dengan status menunggak yang dapat disita agunannya');
            }
            
            $agunanSudahDisita = $pinjamanAktif->agunan->where('status', 6)->count();
            if ($agunanSudahDisita > 0) {
                return redirect()->back()->with('error', 'Agunan untuk pinjaman ini sudah pernah disita');
            }
            
            $jumlahAgunanDisita = 0;
            
            foreach ($pinjamanAktif->agunan as $agunan) {
                if ($agunan->status == 4) {
                    $agunan->update([
                        'status' => 6, // Status: Disita
                        'tanggal_penyitaan' => $request->tanggal_penyitaan,
                        'alasan_penyitaan' => $request->alasan_penyitaan,
                        'updated_at' => now()
                    ]);
                    
                    $jumlahAgunanDisita++;
                }
            }
            
            if ($jumlahAgunanDisita == 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Tidak ada agunan aktif yang dapat disita');
            }
            
            DB::commit();
            
            $message = "Berhasil menyita {$jumlahAgunanDisita} agunan pada pinjaman {$pinjamanAktif->nomor_pinjaman}";
            
            return redirect()->route('teller.tunggakan-pinjaman.show', $id)
                ->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyita agunan: ' . $e->getMessage());
        }
    }
}