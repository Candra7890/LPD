<?php

namespace App\Http\Controllers;


use App\Models\PencairanPinjaman;
use App\Models\PengajuanPinjaman;
use App\Services\LayananPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PencairanPinjamanController extends Controller
{
    protected $layananPinjaman;

    public function __construct(LayananPinjaman $layananPinjaman)
    {
        $this->layananPinjaman = $layananPinjaman;
    }

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
            $this->layananPinjaman->cairkanPinjaman($pengajuanId, $request->all());

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