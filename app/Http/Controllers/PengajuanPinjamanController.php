<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;
use App\Models\KonfigurasiPinjaman;
use App\Models\Nasabah;
use App\Models\Agunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PengajuanPinjamanController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman.konfigurasi', 'agunan'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('teller.pinjaman.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $nasabahList = Nasabah::where('is_active', 1)
            ->select('id', 'kode_nasabah', 'nik', 'nama_lengkap', 'no_telepon', 'pekerjaan')
            ->orderBy('nama_lengkap', 'asc')
            ->get();
        
        $produkPinjaman = Pinjaman::get();
        
        return view('teller.pinjaman.pengajuan.create', compact('nasabahList', 'produkPinjaman'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman.konfigurasi', 'agunan'])
            ->findOrFail($id);
        
        return view('teller.pinjaman.pengajuan.show', compact('pengajuan'));
    }

    public function getKonfigurasi($pinjamanId)
    {
        try {
            $konfigurasi = KonfigurasiPinjaman::where('pinjaman_id', $pinjamanId)->first();
            
            if (!$konfigurasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi pinjaman tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $konfigurasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function kalkulasi(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pinjaman_id' => 'required|exists:pinjaman,id',
                'plafon' => 'required|numeric|min:0',
                'tenor' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $konfigurasi = KonfigurasiPinjaman::where('pinjaman_id', $request->pinjaman_id)->first();
            
            if (!$konfigurasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi tidak ditemukan'
                ], 404);
            }

            $plafon = floatval($request->plafon);
            $tenor = intval($request->tenor);
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

            return response()->json([
                'success' => true,
                'data' => [
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
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat kalkulasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required|exists:nasabah,id',
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah_pengajuan' => 'required|numeric|min:0',
            'tenor' => 'required|integer|min:1',
        ], [
            'pengguna_id.required' => 'Nasabah wajib dipilih',
            'pinjaman_id.required' => 'Produk pinjaman wajib dipilih',
            'jumlah_pengajuan.required' => 'Plafon wajib diisi',
            'tenor.required' => 'Tenor wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $lastPengajuan = PengajuanPinjaman::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->first();
            
            $lastNumber = $lastPengajuan ? intval(substr($lastPengajuan->nomor_pengajuan, -4)) : 0;
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $nomorPengajuan = 'PJM-' . date('Ym') . '-' . $newNumber;

            $konfigurasi = KonfigurasiPinjaman::where('pinjaman_id', $request->pinjaman_id)->first();
            
            $plafon = floatval($request->jumlah_pengajuan);
            $tenor = intval($request->tenor);
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

            PengajuanPinjaman::create([
                'nomor_pengajuan' => $nomorPengajuan,
                'pengguna_id' => $request->pengguna_id,
                'pinjaman_id' => $request->pinjaman_id,
                'jumlah_pengajuan' => $plafon,
                'tenor' => $tenor,
                'tanggal_pengajuan' => Carbon::now(),
                'total_angsuran' => round($angsuranPerBulan, 2),
                'total_bunga' => round($totalBunga, 2),
                'total_kewajiban' => round($totalKewajiban, 2),
                'biaya_provisi' => round($biayaProvisi, 2),
                'biaya_administrasi' => round($biayaAdministrasi, 2),
                'biaya_asuransi' => round($biayaAsuransi, 2),
                'biaya_meterai' => round($biayaMeterai, 2),
                'total_biaya' => round($totalBiaya, 2),
                'status' => 0,
                'catatan_pengajuan_teller' => $request->catatan,
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Pengajuan pinjaman berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat pengajuan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_disetujui' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Validasi gagal');
        }

        DB::beginTransaction();
        try {
            $pengajuan = PengajuanPinjaman::findOrFail($id);
            
            $konfigurasi = KonfigurasiPinjaman::where('pinjaman_id', $pengajuan->pinjaman_id)->first();
            if ($konfigurasi && $konfigurasi->wajib_agunan == 1) {
                $agunan = Agunan::where('pengajuan_pinjaman_id', $id)
                    ->where('status', 1)
                    ->first();
                
                if (!$agunan) {
                    return redirect()->back()
                        ->with('error', 'Agunan harus disetujui terlebih dahulu sebelum menyetujui pengajuan');
                }
            }

            $pengajuan->update([
                'jumlah_disetujui' => $request->jumlah_disetujui,
                'status_approval_teller' => 1,
                'status' => 1,
                'catatan_pengajuan_teller' => $request->catatan
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Pengajuan pinjaman berhasil disetujui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyetujui pengajuan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Catatan penolakan wajib diisi');
        }

        DB::beginTransaction();
        try {
            $pengajuan = PengajuanPinjaman::findOrFail($id);

            $pengajuan->update([
                'status_approval_teller' => 2,
                'status' => 2,
                'catatan_pengajuan_teller' => $request->catatan
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Pengajuan pinjaman berhasil ditolak');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menolak pengajuan: ' . $e->getMessage());
        }
    }
}