<?php

namespace App\Services;

use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LayananPengguna
{
    // =========================================================================
    // MANAJEMEN NASABAH
    // =========================================================================

    /**
     * Ambil semua data nasabah
     */
    public function getAllNasabah()
    {
        return Nasabah::with('pekerjaan')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Ambil semua data nasabah aktif
     */
    public function getAllActiveNasabah()
    {
        return Nasabah::where('is_active', 1)
            ->with('pekerjaan')
            ->orderBy('nama_lengkap', 'asc')
            ->get();
    }

    /**
     * Ambil data nasabah berdasarkan ID
     */
    public function getNasabahById($id)
    {
        return Nasabah::findOrFail($id);
    }

    /**
     * Buat nasabah baru
     */
    public function createNasabah(array $data, $fotoFile = null)
    {
        $kodeNasabah = $this->generateKodeNasabah();
        $fotoPath = null;

        if ($fotoFile) {
            $filename = 'nasabah_' . time() . '.' . $fotoFile->getClientOriginalExtension();
            $fotoPath = $fotoFile->storeAs('nasabah', $filename, 'public');
        }

        return Nasabah::create(array_merge($data, [
            'kode_nasabah' => $kodeNasabah,
            'foto' => $fotoPath,
            'is_active' => 1,
        ]));
    }

    /**
     * Update data nasabah
     */
    public function updateNasabah($id, array $data, $fotoFile = null)
    {
        $nasabah = Nasabah::findOrFail($id);
        $updateData = $data;

        if ($fotoFile) {
            // Hapus foto lama jika ada
            if ($nasabah->foto && Storage::disk('public')->exists($nasabah->foto)) {
                Storage::disk('public')->delete($nasabah->foto);
            }

            $filename = 'nasabah_' . time() . '.' . $fotoFile->getClientOriginalExtension();
            $fotoPath = $fotoFile->storeAs('nasabah', $filename, 'public');
            $updateData['foto'] = $fotoPath;
        }

        $nasabah->update($updateData);
        return $nasabah;
    }

    /**
     * Hapus nasabah
     */
    public function deleteNasabah($id)
    {
        $nasabah = Nasabah::findOrFail($id);

        // Hapus foto jika ada
        if ($nasabah->foto && Storage::disk('public')->exists($nasabah->foto)) {
            Storage::disk('public')->delete($nasabah->foto);
        }

        return $nasabah->delete();
    }

    /**
     * Generate Kode Nasabah
     */
    private function generateKodeNasabah()
    {
        $prefix = 'NSB';
        $year = date('Y');
        $month = date('m');

        $lastNasabah = Nasabah::where('kode_nasabah', 'like', $prefix . $year . $month . '%')
            ->orderBy('kode_nasabah', 'desc')
            ->first();

        if ($lastNasabah) {
            $lastNumber = intval(substr($lastNasabah->kode_nasabah, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // =========================================================================
    // MANAJEMEN PEGAWAI (TELLER)
    // =========================================================================

    /**
     * Ambil semua teller
     */
    public function getAllTellers()
    {
        return User::where('role', 1) // 1 = teller
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Ambil teller berdasarkan ID
     */
    public function getTellerById($id)
    {
        return User::where('role', 1)->findOrFail($id);
    }

    /**
     * Buat teller baru
     */
    public function createTeller(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 1, // Set role sebagai teller
            'is_active' => $data['is_active'],
        ]);
    }

    /**
     * Update teller
     */
    public function updateTeller($id, array $data)
    {
        $user = User::where('role', 1)->findOrFail($id);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_active' => $data['is_active'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        return $user;
    }

    /**
     * Hapus teller
     */
    public function deleteTeller($id)
    {
        $user = User::where('role', 1)->findOrFail($id);
        return $user->delete();
    }
}
