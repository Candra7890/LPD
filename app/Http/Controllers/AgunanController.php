<?php

namespace App\Http\Controllers;


use App\Models\PengajuanPinjaman;
use App\Services\LayananAgunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AgunanController extends Controller
{
    protected $layananAgunan;

    public function __construct(LayananAgunan $layananAgunan)
    {
        $this->layananAgunan = $layananAgunan;
    }

    /**
     * Show the form for creating agunan
     */
    public function create($pengajuanId)
    {
        // Note: Idealnya ini via LayananPinjaman, tapi karena belum dibuat, kita skip refactor bagian ini dulu
        $pengajuan = PengajuanPinjaman::with(['pengguna', 'pinjaman'])
            ->findOrFail($pengajuanId);
        
        return view('teller.pinjaman.agunan.create', compact('pengajuan'));
    }

    /**
     * Store agunan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengajuan_pinjaman_id' => 'required|exists:pengajuan_pinjaman,id',
            'nama_agunan' => 'required|string|max:255',
            'nilai_pasar' => 'required|numeric|min:0',
            'nilai_penjaminan' => 'required|numeric|min:0',
            'status_kepemilikan' => 'required|in:1,2,3',
            'nama_pemilik' => 'required|string|max:255',
            'lokasi_agunan_tersimpan' => 'required|string|max:255',
            'file_agunan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'deskripsi' => 'nullable|string|max:255',
            'alamat_agunan' => 'nullable|string|max:255',
        ], [
            'nama_agunan.required' => 'Nama agunan wajib diisi',
            'nilai_pasar.required' => 'Nilai pasar wajib diisi',
            'nilai_penjaminan.required' => 'Nilai penjaminan wajib diisi',
            'status_kepemilikan.required' => 'Status kepemilikan wajib dipilih',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi',
            'lokasi_agunan_tersimpan.required' => 'Lokasi penyimpanan agunan wajib diisi',
            'file_agunan.required' => 'File agunan wajib diunggah',
            'file_agunan.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG',
            'file_agunan.max' => 'Ukuran file maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $this->layananAgunan->createAgunan($request->all(), $request->file('file_agunan'));

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan berhasil diunggah dan menunggu persetujuan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengunggah agunan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show agunan detail
     */
    public function show($id)
    {
        $agunan = $this->layananAgunan->getAgunanById($id);
        
        return view('teller.pinjaman.agunan.show', compact('agunan'));
    }

    /**
     * Approve agunan
     */
    public function approve($id)
    {
        try {
            $this->layananAgunan->approveAgunan($id);

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan berhasil disetujui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui agunan: ' . $e->getMessage());
        }
    }

    /**
     * Reject agunan
     */
    public function reject(Request $request, $id)
    {
        try {
            $this->layananAgunan->rejectAgunan($id);

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan ditolak');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak agunan: ' . $e->getMessage());
        }
    }
}