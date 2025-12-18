<?php

namespace App\Http\Controllers;


use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;
use App\Services\LayananPinjaman;
use App\Services\LayananPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PengajuanPinjamanController extends Controller
{
    protected $layananPinjaman;
    protected $layananPengguna;

    public function __construct(LayananPinjaman $layananPinjaman, LayananPengguna $layananPengguna)
    {
        $this->layananPinjaman = $layananPinjaman;
        $this->layananPengguna = $layananPengguna;
    }

    public function index()
    {
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman.konfigurasi', 'agunan'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('teller.pinjaman.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $nasabahList = $this->layananPengguna->getAllActiveNasabah();
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
            $konfigurasi = $this->layananPinjaman->getKonfigurasiByPinjamanId($pinjamanId);
            
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

            $result = $this->layananPinjaman->kalkulasiAngsuran(
                $request->pinjaman_id,
                $request->plafon,
                $request->tenor
            );

            return response()->json([
                'success' => true,
                'data' => $result
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
            $this->layananPinjaman->createPengajuan($request->all());

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
            $this->layananPinjaman->approvePengajuan(
                $id, 
                $request->jumlah_disetujui, 
                $request->catatan
            );

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
            $this->layananPinjaman->rejectPengajuan($id, $request->catatan);

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