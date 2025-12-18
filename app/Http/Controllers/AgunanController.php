<?php

namespace App\Http\Controllers;

use App\Models\Agunan;
use App\Models\PengajuanPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AgunanController extends Controller
{
    /**
     * Show the form for creating agunan
     */
    public function create($pengajuanId)
    {
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
            // Generate nomor agunan
            $lastAgunan = Agunan::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->first();
            
            $lastNumber = $lastAgunan ? intval(substr($lastAgunan->nomor_agunan, -4)) : 0;
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $nomorAgunan = 'AGN-' . date('Ym') . '-' . $newNumber;

            // Upload file
            $file = $request->file('file_agunan');
            $fileName = time() . '_' . $nomorAgunan . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('agunan', $fileName, 'public');

            Agunan::create([
                'nomor_agunan' => $nomorAgunan,
                'pengajuan_pinjaman_id' => $request->pengajuan_pinjaman_id,
                'nama_agunan' => $request->nama_agunan,
                'deskripsi' => $request->deskripsi,
                'nilai_pasar' => $request->nilai_pasar,
                'nilai_penjaminan' => $request->nilai_penjaminan,
                'status_kepemilikan' => $request->status_kepemilikan,
                'nama_pemilik' => $request->nama_pemilik,
                'alamat_agunan' => $request->alamat_agunan,
                'file_agunan' => $filePath,
                'lokasi_agunan_tersimpan' => $request->lokasi_agunan_tersimpan,
                'status' => 3, // Status pengajuan
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan berhasil diunggah dan menunggu persetujuan');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded file if exists
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
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
        $agunan = Agunan::with(['pengajuan_pinjaman.pengguna', 'pengajuan_pinjaman.pinjaman'])
            ->findOrFail($id);
        
        return view('teller.pinjaman.agunan.show', compact('agunan'));
    }

    /**
     * Approve agunan
     */
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $agunan = Agunan::findOrFail($id);

            $agunan->update([
                'status' => 1, // Diterima
                'tanggal_pengikatan' => Carbon::now()
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan berhasil disetujui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyetujui agunan: ' . $e->getMessage());
        }
    }

    /**
     * Reject agunan
     */
    public function reject(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $agunan = Agunan::findOrFail($id);

            $agunan->update([
                'status' => 2, // Ditolak
            ]);

            DB::commit();

            return redirect()->route('teller.pengajuan-pinjaman.index')
                ->with('success', 'Agunan ditolak');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menolak agunan: ' . $e->getMessage());
        }
    }
}