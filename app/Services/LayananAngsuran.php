<?php

namespace App\Services;

use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use App\Models\PembayaranAngsuran;
use App\Models\RiwayatPinjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LayananAngsuran
{
    protected $layananAgunan;

    public function __construct(LayananAgunan $layananAgunan) {
        $this->layananAgunan = $layananAgunan;
    }

    // ===========================================
    // PINJAMAN AKTIF & GENERATION (Service A calls this)
    // ===========================================

    public function generatePinjamanAktif($pengajuan, $tanggalPencairan, $tanggalJatuhTempoPertama)
    {
        $konfigurasi = $pengajuan->pinjaman->konfigurasi;
        $tenor = intval($pengajuan->tenor);
        $sukuBunga = floatval($konfigurasi->sukubunga_minimum);
        $jumlahDisetujui = floatval($pengajuan->jumlah_disetujui);
        
        $lastPinjamanAktif = PinjamanAktif::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('id', 'desc')
            ->first();
        
        $lastNumberPinjaman = $lastPinjamanAktif ? intval(substr($lastPinjamanAktif->nomor_pinjaman, -4)) : 0;
        $newNumberPinjaman = str_pad($lastNumberPinjaman + 1, 4, '0', STR_PAD_LEFT);
        $nomorPinjaman = 'PJM-' . date('Ym') . '-' . $newNumberPinjaman;

        $pinjamanAktif = PinjamanAktif::create([
            'nomor_pinjaman' => $nomorPinjaman,
            'pengajuan_pinjaman_id' => $pengajuan->id,
            'pengguna_id' => $pengajuan->pengguna_id,
            'pinjaman_id' => $pengajuan->pinjaman_id,
            'pokok_pinjaman' => $jumlahDisetujui,
            'sisa_pokok' => $jumlahDisetujui,
            'tenor_bulan' => $tenor,
            'sisa_tenor' => $tenor,
            'suku_bunga' => $sukuBunga,
            'metode_bunga' => 1,
            'tanggal_pencairan' => $tanggalPencairan,
            'tanggal_jatuh_tempo_pertama' => $tanggalJatuhTempoPertama,
            'tanggal_jatuh_tempo_berikutnya' => $tanggalJatuhTempoPertama,
            'angsuran_per_bulan' => $pengajuan->total_angsuran,
            'total_bunga' => $pengajuan->total_bunga,
            'total_kewajiban' => $pengajuan->total_kewajiban,
            'total_dibayar' => 0,
            'total_pokok_dibayar' => 0,
            'total_bunga_dibayar' => 0,
            'total_denda' => 0,
            'denda_terbayar' => 0,
            'denda_belum_terbayar' => 0,
            'hari_tunggakan' => 0,
            'status' => 1,
        ]);

        $bungaPerBulan = ($jumlahDisetujui * $sukuBunga / 100);
        $pokokPerBulan = $jumlahDisetujui / $tenor;
        $angsuranPerBulan = $pokokPerBulan + $bungaPerBulan;
        
        $saldoAwal = $jumlahDisetujui;
        
        for ($i = 1; $i <= $tenor; $i++) {
            $tanggalJatuhTempo = Carbon::parse($tanggalJatuhTempoPertama)->addMonths($i - 1);
            $saldoAkhir = $saldoAwal - $pokokPerBulan;
            
            JadwalAngsuran::create([
                'pinjaman_aktif_id' => $pinjamanAktif->id,
                'pengguna_id' => $pengajuan->pengguna_id,
                'angsuran_ke' => $i,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'saldo_awal' => round($saldoAwal, 2),
                'angsuran_pokok' => round($pokokPerBulan, 2),
                'angsuran_bunga' => round($bungaPerBulan, 2),
                'total_angsuran' => round($angsuranPerBulan, 2),
                'saldo_akhir' => round($saldoAkhir, 2),
                'status' => 0,
                'jumlah_terbayar' => 0,
                'pokok_terbayar' => 0,
                'bunga_terbayar' => 0,
                'sisa_belum_terbayar' => round($angsuranPerBulan, 2),
                'hari_keterlambatan' => 0,
                'denda' => 0,
                'denda_terbayar' => 0,
            ]);
            
            $saldoAwal = $saldoAkhir;
        }

        return $pinjamanAktif;
    }

    // ===========================================
    // GETTERS
    // ===========================================

    public function getAllPinjamanAktif()
    {
        return PinjamanAktif::with(['pengguna', 'pinjaman', 'pengajuan_pinjaman'])
            ->orderBy('tanggal_pencairan', 'desc')
            ->get();
    }

    public function getPinjamanAktifById($id)
    {
        return PinjamanAktif::with([
            'pengguna',
            'pinjaman',
            'pengajuan_pinjaman',
            'agunan'
        ])->findOrFail($id);
    }
    
    public function getJadwalAngsuran($pinjamanAktifId)
    {
        return JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->orderBy('angsuran_ke', 'asc')
            ->get();
    }
    
    public function getPinjamanMenunggak()
    {
        return PinjamanAktif::with(['pengguna', 'pinjaman', 'agunan'])
            ->where('status', 2) 
            ->orderBy('hari_tunggakan', 'desc')
            ->get();
    }
    
    public function getAllRiwayatPinjaman()
    {
        return RiwayatPinjaman::with(['pengguna', 'pinjaman', 'pinjaman_aktif'])
            ->orderBy('tanggal_pelunasan', 'desc')
            ->get();
    }
    
    public function getRiwayatPinjamanById($id)
    {
        return RiwayatPinjaman::with([
            'pengguna',
            'pinjaman',
            'pinjaman_aktif.agunan'
        ])->findOrFail($id);
    }

    // ===========================================
    // PEMBAYARAN
    // ===========================================

    public function getPembayaranInfo($pinjamanAktifId)
    {
        $pinjamanAktif = PinjamanAktif::with(['pengguna', 'pinjaman'])->findOrFail($pinjamanAktifId);
        
        $jadwalAngsuranBelumLunas = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->whereIn('status', [0, 1, 3])
            ->orderBy('angsuran_ke', 'asc')
            ->get();
        
        $totalTunggakan = $jadwalAngsuranBelumLunas->sum('sisa_belum_terbayar');
        $totalDenda = $jadwalAngsuranBelumLunas->sum(function($jadwal) {
            return floatval($jadwal->denda) - floatval($jadwal->denda_terbayar);
        });
        
        return [
            'pinjamanAktif' => $pinjamanAktif,
            'jadwalAngsuranBelumLunas' => $jadwalAngsuranBelumLunas,
            'totalTunggakan' => $totalTunggakan,
            'totalDenda' => $totalDenda
        ];
    }
    
    public function processPembayaran($pinjamanAktifId, array $data)
    {
        $pinjamanAktif = PinjamanAktif::with('pinjaman.konfigurasi')->findOrFail($pinjamanAktifId);
        $jumlahBayar = floatval($data['jumlah_pembayaran']);
        $sisaBayar = $jumlahBayar;
        $tanggalBayar = Carbon::now()->format('Y-m-d');
        
        $jadwalAngsuranList = JadwalAngsuran::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->whereIn('status', [0, 1, 3])
            ->orderBy('angsuran_ke', 'asc')
            ->get();
        
        if ($jadwalAngsuranList->isEmpty()) {
            throw new \Exception('Tidak ada angsuran yang perlu dibayar');
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
            
            $sisaBungaAngsuran = floatval($jadwal->angsuran_bunga) - floatval($jadwal->bunga_terbayar);
            $sisaPokokAngsuran = floatval($jadwal->angsuran_pokok) - floatval($jadwal->pokok_terbayar);
            
            // Perbaikan logika alokasi: Bunga dulu, baru pokok
            if ($sisaBungaAngsuran > 0) {
                 $pembayaranBunga = min($pembayaranAngsuran, $sisaBungaAngsuran);
                 $pembayaranPokok = $pembayaranAngsuran - $pembayaranBunga;
            } else {
                 $pembayaranBunga = 0;
                 $pembayaranPokok = $pembayaranAngsuran;
            }
            // Pastikan pembayaran pokok tidak melebihi sisa pokok (safety check)
            if ($pembayaranPokok > $sisaPokokAngsuran) {
                // Should not happen with standard math, but float precision safety
                $pembayaranPokok = $sisaPokokAngsuran;
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
                'sisa_pokok' => floatval($pinjamanAktif->sisa_pokok) - $pembayaranPokok, // Est. After payment
                'sisa_kewajiban' => floatval($pinjamanAktif->sisa_pokok) + floatval($pinjamanAktif->total_bunga) - (floatval($pinjamanAktif->total_dibayar) + $jumlahUntukJadwalIni),
                'metode_pembayaran' => $data['metode_pembayaran'],
                'referensi_pembayaran' => $data['referensi_pembayaran'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
                'status' => 1
            ]);
            
            $jadwal->jumlah_terbayar = floatval($jadwal->jumlah_terbayar) + $pembayaranAngsuran;
            $jadwal->pokok_terbayar = floatval($jadwal->pokok_terbayar) + $pembayaranPokok;
            $jadwal->bunga_terbayar = floatval($jadwal->bunga_terbayar) + $pembayaranBunga;
            $jadwal->denda_terbayar = floatval($jadwal->denda_terbayar) + $pembayaranDenda;
            $jadwal->sisa_belum_terbayar = floatval($jadwal->total_angsuran) - floatval($jadwal->jumlah_terbayar);
            
            if ($jadwal->sisa_belum_terbayar <= 0 && ($sisaDenda - $pembayaranDenda) <= 0) {
                $jadwal->status = 2; // Lunas
                $jadwal->tanggal_bayar = $data['tanggal_pembayaran'];
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

            // Release Agunan via Service C
            $this->layananAgunan->releaseAgunanByPinjamanId($pinjamanAktifId, $tanggalBayar);
        }
        
        $pinjamanAktif->save();
        
        return [
            'jumlah_bayar' => $jumlahBayar,
            'sisa_lebih' => $sisaBayar
        ];
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
    
    public function getHistoryPembayaran($pinjamanAktifId)
    {
        return PembayaranAngsuran::with('jadwalAngsuran')
            ->where('pinjaman_aktif_id', $pinjamanAktifId)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();
    }
    
    // ===========================================
    // TUNGGAKAN & AGUNAN
    // ===========================================
    
    public function sitaAgunan($pinjamanAktifId, array $data)
    {
        $pinjamanAktif = PinjamanAktif::with('agunan')->findOrFail($pinjamanAktifId);
        
        if ($pinjamanAktif->agunan->isEmpty()) {
            throw new \Exception('Pinjaman ini tidak memiliki agunan yang dapat disita');
        }
        
        if ($pinjamanAktif->status != 2) {
            throw new \Exception('Hanya pinjaman dengan status menunggak yang dapat disita agunannya');
        }
        
        // Panggil Service C untuk melakukan penyitaan
        // Gunakan method sitaAgunanByPinjamanId yang baru ditambahkan
        $count = $this->layananAgunan->sitaAgunanByPinjamanId($pinjamanAktifId, $data);
        
        if ($count == 0) {
            throw new \Exception('Tidak ada agunan aktif yang dapat disita atau sudah disita');
        }
        
        return $count;
    }
}
