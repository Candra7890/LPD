<?php

namespace App\Http\Controllers;

use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use App\Models\PembayaranAngsuran;
use App\Models\KonfigurasiPinjaman;
use App\Models\RiwayatPinjaman;
use App\Models\Agunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranAngsuranController extends Controller
{
    public function create($pinjamanAktifId)
    {
        $pinjamanAktif = PinjamanAktif::with(['pengguna', 'pinjaman'])->findOrFail($pinjamanAktifId);
        
        $jadwalAngsuranBelumLunas = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->whereIn('status', [0, 1, 3]) // belum bayar, bayar sebagian, menunggak
            ->orderBy('angsuran_ke', 'asc')
            ->get();
        
        $totalTunggakan = $jadwalAngsuranBelumLunas->sum('sisa_belum_terbayar');
        $totalDenda = $jadwalAngsuranBelumLunas->sum(function($jadwal) {
            return floatval($jadwal->denda) - floatval($jadwal->denda_terbayar);
        });
        
        return view('teller.pinjaman.pembayaran.create', compact(
            'pinjamanAktif',
            'jadwalAngsuranBelumLunas',
            'totalTunggakan',
            'totalDenda'
        ));
    }
    
    public function store(Request $request, $pinjamanAktifId)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|in:1,2,3,4',
            'referensi_pembayaran' => $request->metode_pembayaran == '2' || $request->metode_pembayaran == '3' 
                ? 'required|string|max:255' 
                : 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ], [
            'referensi_pembayaran.required' => 'Nomor referensi bank wajib diisi untuk metode Transfer/VA.'
        ]);

        DB::beginTransaction();
        try {
            $pinjamanAktif = PinjamanAktif::with('pinjaman.konfigurasi')->findOrFail($pinjamanAktifId);
            $jumlahBayar = floatval($request->jumlah_pembayaran);
            $sisaBayar = $jumlahBayar;
            $tanggalBayar = Carbon::now()->format('Y-m-d');
            
            $jadwalAngsuranList = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
                ->whereIn('status', [0, 1, 3])
                ->orderBy('angsuran_ke', 'asc')
                ->get();
            
            if ($jadwalAngsuranList->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada angsuran yang perlu dibayar');
            }

            $totalPokokDibayar = 0;
            $totalBungaDibayar = 0;
            $totalDendaDibayar = 0;

            foreach ($jadwalAngsuranList as $jadwal) {
                if ($sisaBayar <= 0) break;
                
                $sisaAngsuran = floatval($jadwal->sisa_belum_terbayar);
                $sisaDenda = floatval($jadwal->denda) - floatval($jadwal->denda_terbayar);
                
                $totalYangHarusDibayar = $sisaAngsuran + $sisaDenda;
                
                if ($totalYangHarusDibayar <= 0) continue;
                
                $jumlahUntukJadwalIni = min($sisaBayar, $totalYangHarusDibayar);
                
                $pembayaranDenda = min($jumlahUntukJadwalIni, $sisaDenda);
                $pembayaranAngsuran = $jumlahUntukJadwalIni - $pembayaranDenda;
                
                $sisaPokokAngsuran = floatval($jadwal->angsuran_pokok) - floatval($jadwal->pokok_terbayar);
                $sisaBungaAngsuran = floatval($jadwal->angsuran_bunga) - floatval($jadwal->bunga_terbayar);
                $totalSisaAngsuran = $sisaPokokAngsuran + $sisaBungaAngsuran;
                
                $pembayaranPokok = 0;
                $pembayaranBunga = 0;
                
                if ($totalSisaAngsuran > 0) {
                    $pembayaranBunga = min($pembayaranAngsuran, $sisaBungaAngsuran);
                    $pembayaranPokok = $pembayaranAngsuran - $pembayaranBunga;
                }
                
                $nomorPembayaran = $this->generateNomorPembayaran();
                
                PembayaranAngsuran::create([
                    'nomor_pembayaran' => $nomorPembayaran,
                    'pinjaman_aktif_id' => $pinjamanAktifId,
                    'jadwal_angsuran_id' => $jadwal->id,
                    'pengguna_id' => $pinjamanAktif->pengguna_id,
                    'tanggal_pembayaran' => $tanggalBayar,
                    'tanggal_transaksi' => Carbon::now()->format('Y-m-d'),
                    'jumlah_pembayaran' => $jumlahUntukJadwalIni,
                    'pembayaran_pokok' => $pembayaranPokok,
                    'pembayaran_bunga' => $pembayaranBunga,
                    'pembayaran_denda' => $pembayaranDenda,
                    'sisa_pokok' => floatval($pinjamanAktif->sisa_pokok) - $pembayaranPokok,
                    'sisa_kewajiban' => floatval($pinjamanAktif->sisa_pokok) + floatval($pinjamanAktif->total_bunga) - (floatval($pinjamanAktif->total_dibayar) + $jumlahUntukJadwalIni),
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'referensi_pembayaran' => $request->referensi_pembayaran,
                    'keterangan' => $request->keterangan,
                    'status' => 1
                ]);
                
                $jadwal->jumlah_terbayar = floatval($jadwal->jumlah_terbayar) + $pembayaranAngsuran;
                $jadwal->pokok_terbayar = floatval($jadwal->pokok_terbayar) + $pembayaranPokok;
                $jadwal->bunga_terbayar = floatval($jadwal->bunga_terbayar) + $pembayaranBunga;
                $jadwal->denda_terbayar = floatval($jadwal->denda_terbayar) + $pembayaranDenda;
                $jadwal->sisa_belum_terbayar = floatval($jadwal->total_angsuran) - floatval($jadwal->jumlah_terbayar);
                
                if ($jadwal->sisa_belum_terbayar <= 0 && ($sisaDenda - $pembayaranDenda) <= 0) {
                    $jadwal->status = 2; // Lunas
                    $jadwal->tanggal_bayar = $request->tanggal_pembayaran;
                    $jadwal->hari_keterlambatan = 0;
                } else {
                    $jadwal->status = 1; // Bayar sebagian
                }
                
                $jadwal->save();
                
                $totalPokokDibayar += $pembayaranPokok;
                $totalBungaDibayar += $pembayaranBunga;
                $totalDendaDibayar += $pembayaranDenda;
                
                $sisaBayar -= $jumlahUntukJadwalIni;
            }
            
            $pinjamanAktif->sisa_pokok = floatval($pinjamanAktif->sisa_pokok) - $totalPokokDibayar;
            $pinjamanAktif->total_dibayar = floatval($pinjamanAktif->total_dibayar) + $jumlahBayar;
            $pinjamanAktif->total_pokok_dibayar = floatval($pinjamanAktif->total_pokok_dibayar) + $totalPokokDibayar;
            $pinjamanAktif->total_bunga_dibayar = floatval($pinjamanAktif->total_bunga_dibayar) + $totalBungaDibayar;
            $pinjamanAktif->denda_terbayar = floatval($pinjamanAktif->denda_terbayar) + $totalDendaDibayar;
            $pinjamanAktif->denda_belum_terbayar = floatval($pinjamanAktif->total_denda) - floatval($pinjamanAktif->denda_terbayar) - $totalDendaDibayar;
            
            $sisaTenor = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
                ->whereIn('status', [0, 1, 3])
                ->count();
            $pinjamanAktif->sisa_tenor = $sisaTenor;
            
            $jadwalBerikutnya = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
                ->whereIn('status', [0, 1, 3])
                ->orderBy('angsuran_ke', 'asc')
                ->first();
            
            if ($jadwalBerikutnya) {
                $pinjamanAktif->tanggal_jatuh_tempo_berikutnya = $jadwalBerikutnya->tanggal_jatuh_tempo;
                $pinjamanAktif->status = 1; // Aktif
                
                if ($jadwalBerikutnya->status == 3) {
                    $pinjamanAktif->status = 2; // Menunggak
                }
            } else {
                $pinjamanAktif->status = 3; // Lunas
                $pinjamanAktif->tanggal_pelunasan = $tanggalBayar;
                $pinjamanAktif->tanggal_jatuh_tempo_berikutnya = null;
                $pinjamanAktif->sisa_tenor = 0;
                $pinjamanAktif->hari_tunggakan = 0;

                RiwayatPinjaman::create([
                    'pinjaman_aktif_id' => $pinjamanAktif->id,
                    'pengguna_id' => $pinjamanAktif->pengguna_id,
                    'pinjaman_id' => $pinjamanAktif->pinjaman_id,
                    'nomor_pinjaman' => $pinjamanAktif->nomor_pinjaman,
                    'pokok_pinjaman' => $pinjamanAktif->pokok_pinjaman,
                    'tenor' => $pinjamanAktif->tenor_bulan,
                    'tanggal_pencairan' => $pinjamanAktif->tanggal_pencairan,
                    'tanggal_pelunasan' => now(),
                    'total_dibayar' => $pinjamanAktif->total_dibayar,
                    'total_pokok_dibayar' => $pinjamanAktif->total_pokok_dibayar,
                    'total_bunga_dibayar' => $pinjamanAktif->total_bunga_dibayar,
                    'total_denda_dibayar' => $pinjamanAktif->denda_terbayar,
                ]);

                $this->releaseAgunan($pinjamanAktifId, $tanggalBayar);
            }
            
            $pinjamanAktif->save();
            
            DB::commit();
            
            $message = "Pembayaran berhasil! Total: Rp " . number_format($jumlahBayar, 0, ',', '.');
            if ($sisaBayar > 0) {
                $message .= " (Kelebihan Rp " . number_format($sisaBayar, 0, ',', '.') . " otomatis dialokasikan ke angsuran berikutnya)";
            }
            
            return redirect()->route('teller.pinjaman-aktif.show', $pinjamanAktifId)
                ->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function releaseAgunan($pinjamanAktifId, $tanggalPelepasan)
    {
        Agunan::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->where('status', 4)
            ->update([
                'status' => 5,
                'tanggal_pelepasan' => $tanggalPelepasan,
                'updated_at' => now()
            ]);
    }
    
    private function generateNomorPembayaran()
    {
        $prefix = 'PAY';
        $date = date('Ymd');
        $lastPembayaran = PembayaranAngsuran::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastPembayaran ? (intval(substr($lastPembayaran->nomor_pembayaran, -4)) + 1) : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
    
    public function history($pinjamanAktifId)
    {
        $pinjamanAktif = PinjamanAktif::with(['pengguna', 'pinjaman'])->findOrFail($pinjamanAktifId);
        
        $pembayaran = PembayaranAngsuran::with('jadwalAngsuran')
            ->where('pinjaman_aktif_id', $pinjamanAktifId)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();
        
        return view('teller.pinjaman.pembayaran.history', compact('pinjamanAktif', 'pembayaran'));
    }
}