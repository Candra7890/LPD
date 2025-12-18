<?php

namespace App\Services;

use App\Models\Agunan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class LayananAgunan
{
    /**
     * Ambil Agunan by ID
     */
    public function getAgunanById($id)
    {
        return Agunan::with(['pengajuan_pinjaman.pengguna', 'pengajuan_pinjaman.pinjaman'])
            ->findOrFail($id);
    }
    
    public function getAgunanByPinjamanAktifId($pinjamanAktifId)
    {
        return Agunan::where('pinjaman_aktif_id', $pinjamanAktifId)->get();
    }

    /**
     * Sita Agunan berdasarkan Pinjaman Aktif ID
     */
    public function sitaAgunanByPinjamanId($pinjamanAktifId, $data)
    {
        $agunanList = Agunan::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->where('status', 4) // Status Aktif
            ->get();
            
        $count = 0;
        foreach ($agunanList as $agunan) {
            $agunan->update([
                'status' => 6, // Status: Disita
                'tanggal_penyitaan' => $data['tanggal_penyitaan'],
                'alasan_penyitaan' => $data['alasan_penyitaan'],
                'updated_at' => now()
            ]);
            $count++;
        }
        
        return $count;
    }

    /**
     * Release Agunan (Lunas) berdasarkan Pinjaman Aktif ID
     */
    public function releaseAgunanByPinjamanId($pinjamanAktifId, $tanggalPelepasan)
    {
        return Agunan::where('pinjaman_aktif_id', $pinjamanAktifId)
            ->where('status', 4)
            ->update([
                'status' => 5, // Lunas / Dikembalikan
                'tanggal_pelepasan' => $tanggalPelepasan,
                'updated_at' => now()
            ]);
    }

    /**
     * Ambil Agunan by Pengajuan ID (untuk Service A)
     */
    public function getAgunanByPengajuanId($pengajuanId)
    {
        return Agunan::where('pengajuan_pinjaman_id', $pengajuanId)->get();
    }

    /**
     * Buat Agunan Baru
     */
    public function createAgunan(array $data, $file)
    {
        // Generate nomor agunan
        $lastAgunan = Agunan::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('id', 'desc')
            ->first();

        $lastNumber = $lastAgunan ? intval(substr($lastAgunan->nomor_agunan, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorAgunan = 'AGN-' . date('Ym') . '-' . $newNumber;

        // Upload file
        $fileName = time() . '_' . $nomorAgunan . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('agunan', $fileName, 'public');

        return Agunan::create([
            'nomor_agunan' => $nomorAgunan,
            'pengajuan_pinjaman_id' => $data['pengajuan_pinjaman_id'],
            'nama_agunan' => $data['nama_agunan'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'nilai_pasar' => $data['nilai_pasar'],
            'nilai_penjaminan' => $data['nilai_penjaminan'],
            'status_kepemilikan' => $data['status_kepemilikan'],
            'nama_pemilik' => $data['nama_pemilik'],
            'alamat_agunan' => $data['alamat_agunan'] ?? null,
            'file_agunan' => $filePath,
            'lokasi_agunan_tersimpan' => $data['lokasi_agunan_tersimpan'],
            'status' => 3, // Status pengajuan
        ]);
    }

    /**
     * Setujui Agunan
     */
    public function approveAgunan($id)
    {
        $agunan = Agunan::findOrFail($id);
        $agunan->update([
            'status' => 1, // Diterima
            'tanggal_pengikatan' => Carbon::now()
        ]);
        return $agunan;
    }

    /**
     * Tolak Agunan
     */
    public function rejectAgunan($id)
    {
        $agunan = Agunan::findOrFail($id);
        $agunan->update([
            'status' => 2, // Ditolak
        ]);
        return $agunan;
    }
}
