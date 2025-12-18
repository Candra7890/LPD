<?php

namespace App\Http\Controllers;

use App\Models\PencairanPinjaman;
use App\Models\PengajuanPinjaman;
use App\Models\PinjamanAktif;
use App\Models\JadwalAngsuran;
use App\Models\Agunan;
use App\Models\KonfigurasiPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PencairanPinjamanController extends Controller
{
    public function index()
    {
        $pengajuanSiapCair = PengajuanPinjaman::with(['pengguna', 'pinjaman', 'agunan'])
            ->whereIn('status', [1, 3])
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();
        
        return view('teller.pinjaman.pencairan.index', compact('pengajuanSiapCair'));
    }

    public function create($pengajuanId)
    {
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman', 'agunan'])
            ->findOrFail($pengajuanId);
        
        if ($pengajuan->status != 1) {
            return redirect()->route('teller.pencairan-pinjaman.index')
                ->with('error', 'Pengajuan belum disetujui atau sudah dicairkan');
        }
        
        return view('teller.pinjaman.pencairan.create', compact('pengajuan'));
    }

    public function store(Request $request, $pengajuanId)
    {
        $validator = Validator::make($request->all(), [
            'metode_pencairan' => 'required|in:1,2',
            'bank_tujuan' => 'required_if:metode_pencairan,1|nullable|string',
            'nomor_rekening' => 'required_if:metode_pencairan,1|nullable|string',
            'nama_rekening' => 'required_if:metode_pencairan,1|nullable|string',
        ], [
            'metode_pencairan.required' => 'Metode pencairan wajib dipilih',
            'bank_tujuan.required_if' => 'Bank tujuan wajib diisi untuk transfer',
            'nomor_rekening.required_if' => 'Nomor rekening wajib diisi untuk transfer',
            'nama_rekening.required_if' => 'Nama rekening wajib diisi untuk transfer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $pengajuan = PengajuanPinjaman::with(['pinjaman.konfigurasi', 'agunan'])
                ->findOrFail($pengajuanId);
            
            if ($pengajuan->status != 1) {
                return redirect()->back()
                    ->with('error', 'Pengajuan tidak dapat dicairkan');
            }

            $tanggalPencairan = Carbon::now();
            $jumlahDisetujui = floatval($pengajuan->jumlah_disetujui);
            $totalBiaya = floatval($pengajuan->total_biaya);
            $jumlahDiterima = $jumlahDisetujui - $totalBiaya;

            $lastPencairan = PencairanPinjaman::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->first();
            
            $lastNumber = $lastPencairan ? intval(substr($lastPencairan->nomor_pencairan, -4)) : 0;
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $nomorPencairan = 'CAIR-' . date('Ym') . '-' . $newNumber;

            $lastPinjamanAktif = PinjamanAktif::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->first();
            
            $lastNumberPinjaman = $lastPinjamanAktif ? intval(substr($lastPinjamanAktif->nomor_pinjaman, -4)) : 0;
            $newNumberPinjaman = str_pad($lastNumberPinjaman + 1, 4, '0', STR_PAD_LEFT);
            $nomorPinjaman = 'PJM-' . date('Ym') . '-' . $newNumberPinjaman;

            $konfigurasi = $pengajuan->pinjaman->konfigurasi;
            $tenor = intval($pengajuan->tenor);
            $sukuBunga = floatval($konfigurasi->sukubunga_minimum);
            
            $tanggalJatuhTempoPertama = Carbon::now()->addMonth();
            
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
                'status' => 1, // 1 = aktif
            ]);

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
                'metode_pencairan' => $request->metode_pencairan,
                'bank_tujuan' => $request->bank_tujuan,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_rekening' => $request->nama_rekening,
                'status' => 1, // 1 = selesai
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
                    'status' => 0, // 0 = belum bayar
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

            if ($pengajuan->agunan->count() > 0) {
                foreach ($pengajuan->agunan as $agunan) {
                    $agunan->update([
                        'status' => 4, // 4 = aktif
                        'tanggal_pengikatan' => $tanggalPencairan,
                        'pinjaman_aktif_id' => $pinjamanAktif->id,
                    ]);
                }
            }

            $pengajuan->update([
                'status' => 3, // 3 = dicairkan
                'tanggal_pencairan' => $tanggalPencairan,
            ]);

            DB::commit();

            return redirect()->route('teller.pencairan-pinjaman.index')
                ->with('success', 'Pencairan pinjaman berhasil. Pinjaman aktif dan jadwal angsuran telah dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal melakukan pencairan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showPengajuan($id)
    {
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman.konfigurasi', 'agunan'])
            ->findOrFail($id);
        
        return view('teller.pinjaman.pencairan.showpengajuan', compact('pengajuan'));
    }

    public function show($id)
    {
        $pencairan = PencairanPinjaman::with([
            'pengajuan_pinjaman.pengguna',
            'pengajuan_pinjaman.pinjaman',
            'pinjaman_aktif'
        ])->findOrFail($id);
        
        return view('teller.pinjaman.pencairan.show', compact('pencairan'));
    }
}