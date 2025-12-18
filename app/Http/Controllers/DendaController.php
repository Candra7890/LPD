<?php

namespace App\Http\Controllers;

use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use App\Models\KonfigurasiPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function checkAndUpdateDenda()
    {
        DB::beginTransaction();
        try {
            $today = Carbon::now()->startOfDay();
            $totalUpdated = 0;
            $totalDendaDikenakan = 0;
            
            $pinjamanAktifList = PinjamanAktif::with('pinjaman.konfigurasi')
                ->whereIn('status', [1, 2])
                ->get();
            
            foreach ($pinjamanAktifList as $pinjamanAktif) {
                $konfigurasi = $pinjamanAktif->pinjaman->konfigurasi;
                
                if (!$konfigurasi) continue;
                
                $toleransiHari = intval($konfigurasi->toleransi_periode_denda ?? 0);
                $persentaseDendaHarian = floatval($konfigurasi->persentase_denda_harian ?? 0);
                $persentaseDendaBulanan = floatval($konfigurasi->persentase_denda_bulanan ?? 0);
                $dendaMaksimal = floatval($konfigurasi->denda_maksimal ?? 0);
                
                $jadwalAngsuranList = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktif->id)
                    ->whereIn('status', [0, 1, 3]) // belum bayar, bayar sebagian, menunggak
                    ->get();
                
                $totalDendaPinjaman = 0;
                $hariTunggakanTerlama = 0;
                $adaTunggakan = false;
                
                foreach ($jadwalAngsuranList as $jadwal) {
                    $tanggalJatuhTempo = Carbon::parse($jadwal->tanggal_jatuh_tempo)->startOfDay();
                    
                    if ($today->greaterThan($tanggalJatuhTempo)) {
                        $hariTerlambat = $tanggalJatuhTempo->diffInDays($today);
                        
                        // Kurangi dengan toleransi
                        $hariKenaDenda = max(0, $hariTerlambat - $toleransiHari);
                        
                        if ($hariKenaDenda > 0) {
                            $adaTunggakan = true;
                            $hariTunggakanTerlama = max($hariTunggakanTerlama, $hariTerlambat);
                            
                            // Hitung denda
                            $sisaAngsuran = floatval($jadwal->sisa_belum_terbayar);
                            $dendaBaru = 0;
                            
                            if ($persentaseDendaHarian > 0) {
                                // Denda harian
                                $dendaBaru = $sisaAngsuran * ($persentaseDendaHarian / 100) * $hariKenaDenda;
                            } elseif ($persentaseDendaBulanan > 0) {
                                // Denda bulanan
                                $bulanTerlambat = ceil($hariKenaDenda / 30);
                                $dendaBaru = $sisaAngsuran * ($persentaseDendaBulanan / 100) * $bulanTerlambat;
                            }
                            
                            if ($dendaMaksimal > 0 && $dendaBaru > $dendaMaksimal) {
                                $dendaBaru = $dendaMaksimal;
                            }
                            
                            // Update jadwal angsuran
                            $dendaSebelumnya = floatval($jadwal->denda);
                            if ($dendaBaru > $dendaSebelumnya) {
                                $jadwal->denda = $dendaBaru;
                                $jadwal->hari_keterlambatan = $hariTerlambat;
                                $jadwal->status = 3; // Menunggak
                                $jadwal->save();
                                
                                $totalDendaDikenakan += ($dendaBaru - $dendaSebelumnya);
                            }
                            
                            $totalDendaPinjaman += $dendaBaru;
                        }
                    }
                }
                
                // Update pinjaman aktif
                if ($adaTunggakan) {
                    $pinjamanAktif->status = 2; // Menunggak
                    $pinjamanAktif->hari_tunggakan = $hariTunggakanTerlama;
                    $pinjamanAktif->total_denda = $totalDendaPinjaman;
                    $pinjamanAktif->denda_belum_terbayar = $totalDendaPinjaman - floatval($pinjamanAktif->denda_terbayar);
                    $pinjamanAktif->save();
                    
                    $totalUpdated++;
                }
            }
            
            DB::commit();
            
            return redirect()->back()->with('success', 
                "Pengecekan denda selesai! Total pinjaman yang diupdate: {$totalUpdated}. " .
                "Total denda baru yang dikenakan: Rp " . number_format($totalDendaDikenakan, 0, ',', '.')
            );
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}