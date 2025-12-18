<?php

namespace App\Services;

use App\Models\KonfigurasiPinjaman;
use App\Models\PengajuanPinjaman;
use App\Models\PencairanPinjaman;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LayananPinjaman
{
    protected $layananPengguna;
    protected $layananAgunan;
    protected $layananAngsuran;

    public function __construct(
        LayananPengguna $layananPengguna,
        LayananAgunan $layananAgunan,
        LayananAngsuran $layananAngsuran
    ) {
        $this->layananPengguna = $layananPengguna;
        $this->layananAgunan = $layananAgunan;
        $this->layananAngsuran = $layananAngsuran;
    }

    // =========================================================================
    // KONFIGURASI & PRODUK
    // =========================================================================

    public function getKonfigurasiByPinjamanId($pinjamanId)
    {
        return KonfigurasiPinjaman::where('pinjaman_id', $pinjamanId)->first();
    }

    public function storeKonfigurasi(array $data)
    {
        return KonfigurasiPinjaman::create($data);
    }

    public function updateKonfigurasi($id, array $data)
    {
        $konfigurasi = KonfigurasiPinjaman::findOrFail($id);
        $konfigurasi->update($data);
        return $konfigurasi;
    }

    public function deleteKonfigurasi($id)
    {
        $konfigurasi = KonfigurasiPinjaman::findOrFail($id);
        return $konfigurasi->delete();
    }

    // =========================================================================
    // KALKULASI & PENGAJUAN
    // =========================================================================

    public function kalkulasiAngsuran($pinjamanId, $plafon, $tenor)
    {
        $konfigurasi = $this->getKonfigurasiByPinjamanId($pinjamanId);

        if (!$konfigurasi) {
            throw new \Exception('Konfigurasi pinjaman tidak ditemukan');
        }

        $plafon = floatval($plafon);
        $tenor = intval($tenor);
        $sukuBunga = floatval($konfigurasi->sukubunga_minimum);

        $bungaPerBulan = ($plafon * $sukuBunga / 100);
        $totalBunga = $bungaPerBulan * $tenor;
        $pokokPerBulan = $plafon / $tenor;
        $angsuranPerBulan = $pokokPerBulan + $bungaPerBulan;
        $totalKewajiban = $plafon + $totalBunga;

        $biayaProvisi = ($plafon * floatval($konfigurasi->persentase_provisi ?? 0) / 100);
        $biayaAdministrasi = ($plafon * floatval($konfigurasi->persentase_administrasi ?? 0) / 100);
        $biayaAsuransi = ($plafon * floatval($konfigurasi->persentase_asuransi ?? 0) / 100);
        $biayaMeterai = floatval($konfigurasi->biaya_meterai ?? 0);
        $totalBiaya = $biayaProvisi + $biayaAdministrasi + $biayaAsuransi + $biayaMeterai;

        $jumlahDiterimaBersih = $plafon - $totalBiaya;

        return [
            'plafon' => $plafon,
            'tenor' => $tenor,
            'suku_bunga' => $sukuBunga,
            'bunga_per_bulan' => round($bungaPerBulan, 2),
            'total_bunga' => round($totalBunga, 2),
            'pokok_per_bulan' => round($pokokPerBulan, 2),
            'angsuran_per_bulan' => round($angsuranPerBulan, 2),
            'total_kewajiban' => round($totalKewajiban, 2),
            'biaya_provisi' => round($biayaProvisi, 2),
            'biaya_administrasi' => round($biayaAdministrasi, 2),
            'biaya_asuransi' => round($biayaAsuransi, 2),
            'biaya_meterai' => round($biayaMeterai, 2),
            'total_biaya' => round($totalBiaya, 2),
            'jumlah_diterima_bersih' => round($jumlahDiterimaBersih, 2)
        ];
    }

    public function createPengajuan(array $data)
    {
        // Validasi Nasabah via Service D (Opional, tapi good practice)
        // $this->layananPengguna->getNasabahById($data['pengguna_id']);

        $kalkulasi = $this->kalkulasiAngsuran($data['pinjaman_id'], $data['jumlah_pengajuan'], $data['tenor']);

        // Generate Nomor Pengajuan
        $lastPengajuan = PengajuanPinjaman::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = $lastPengajuan ? intval(substr($lastPengajuan->nomor_pengajuan, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorPengajuan = 'PJM-' . date('Ym') . '-' . $newNumber;

        return PengajuanPinjaman::create([
            'nomor_pengajuan' => $nomorPengajuan,
            'pengguna_id' => $data['pengguna_id'],
            'pinjaman_id' => $data['pinjaman_id'],
            'jumlah_pengajuan' => $data['jumlah_pengajuan'],
            'tenor' => $data['tenor'],
            'tanggal_pengajuan' => Carbon::now(),
            'total_angsuran' => $kalkulasi['angsuran_per_bulan'],
            'total_bunga' => $kalkulasi['total_bunga'],
            'total_kewajiban' => $kalkulasi['total_kewajiban'],
            'biaya_provisi' => $kalkulasi['biaya_provisi'],
            'biaya_administrasi' => $kalkulasi['biaya_administrasi'],
            'biaya_asuransi' => $kalkulasi['biaya_asuransi'],
            'biaya_meterai' => $kalkulasi['biaya_meterai'],
            'total_biaya' => $kalkulasi['total_biaya'],
            'status' => 0,
            'catatan_pengajuan_teller' => $data['catatan'] ?? null,
        ]);
    }

    public function approvePengajuan($id, $jumlahDisetujui, $catatan)
    {
        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $konfigurasi = $this->getKonfigurasiByPinjamanId($pengajuan->pinjaman_id);

        // Cek Agunan via Service C
        if ($konfigurasi && $konfigurasi->wajib_agunan == 1) {
            $agunanList = $this->layananAgunan->getAgunanByPengajuanId($id);
            $agunanDisetujui = $agunanList->where('status', 1)->first();

            if (!$agunanDisetujui) {
                throw new \Exception('Agunan harus disetujui terlebih dahulu sebelum menyetujui pengajuan');
            }
        }

        $pengajuan->update([
            'jumlah_disetujui' => $jumlahDisetujui,
            'status_approval_teller' => 1,
            'status' => 1,
            'catatan_pengajuan_teller' => $catatan
        ]);

        return $pengajuan;
    }

    public function rejectPengajuan($id, $catatan)
    {
        $pengajuan = PengajuanPinjaman::findOrFail($id);
        $pengajuan->update([
            'status_approval_teller' => 2,
            'status' => 2,
            'catatan_pengajuan_teller' => $catatan
        ]);
        return $pengajuan;
    }

    // =========================================================================
    // PENCAIRAN
    // =========================================================================

    public function cairkanPinjaman($pengajuanId, array $data)
    {
        $pengajuan = PengajuanPinjaman::with(['pinjaman.konfigurasi', 'agunan'])
            ->findOrFail($pengajuanId);

        if ($pengajuan->status != 1) {
            throw new \Exception('Pengajuan tidak dapat dicairkan');
        }

        // Generate Nomor Pencairan
        $lastPencairan = PencairanPinjaman::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = $lastPencairan ? intval(substr($lastPencairan->nomor_pencairan, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorPencairan = 'CAIR-' . date('Ym') . '-' . $newNumber;

        $tanggalPencairan = Carbon::now();
        $jumlahDisetujui = floatval($pengajuan->jumlah_disetujui);
        $totalBiaya = floatval($pengajuan->total_biaya);
        $jumlahDiterima = $jumlahDisetujui - $totalBiaya;

        // Panggil Service B untuk generate Pinjaman Aktif & Jadwal
        // Tanggal Jatuh Tempo Pertama = +1 Bulan
        $tanggalJatuhTempoPertama = Carbon::now()->addMonth();
        
        $pinjamanAktif = $this->layananAngsuran->generatePinjamanAktif(
            $pengajuan, 
            $tanggalPencairan, 
            $tanggalJatuhTempoPertama
        );

        // Update Agunan jika ada (Service A update data via hubungan relasi yang sudah diload)
        // Note: Idealnya panggil Service C untuk update status agunan, tapi karena logic simple update FK,
        // kita bisa lakukan di sini atau panggil Helper Service C.
        // Untuk strictness, mari kita biarkan code asli yang melakukan update langsung via Eloquent relationship
        // karena $pengajuan->agunan is Collection of Agunan models.
        if ($pengajuan->agunan->count() > 0) {
            foreach ($pengajuan->agunan as $agunan) {
                $agunan->update([
                    'status' => 4, // 4 = aktif
                    'tanggal_pengikatan' => $tanggalPencairan,
                    'pinjaman_aktif_id' => $pinjamanAktif->id,
                ]);
            }
        }

        // Create Pencairan Record
        $pencairan = PencairanPinjaman::create([
            'nomor_pencairan' => $nomorPencairan,
            'pengajuan_pinjaman_id' => $pengajuan->id,
            'pinjaman_aktif_id' => $pinjamanAktif->id,
            'pengguna_id' => $pengajuan->pengguna_id,
            'tanggal_pencairan' => $tanggalPencairan,
            'jumlah_disetujui' => $jumlahDisetujui,
            'potongan_biaya' => $totalBiaya,
            'jumlah_diterima' => $jumlahDiterima,
            'potongan_provisi' => $pengajuan->biaya_provisi,
            'potongan_admin' => $pengajuan->biaya_administrasi,
            'metode_pencairan' => $data['metode_pencairan'],
            'bank_tujuan' => $data['bank_tujuan'] ?? null,
            'nomor_rekening' => $data['nomor_rekening'] ?? null,
            'nama_rekening' => $data['nama_rekening'] ?? null,
            'status' => 1, // 1 = selesai
        ]);

        $pengajuan->update([
            'status' => 3, // 3 = dicairkan
            'tanggal_pencairan' => $tanggalPencairan,
        ]);

        return $pencairan;
    }
}
