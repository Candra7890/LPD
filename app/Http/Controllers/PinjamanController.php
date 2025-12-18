<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\JenisPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::with('jenisPinjaman')->orderBy('created_at', 'desc')->get();
        $jenisPinjaman = JenisPinjaman::all();
        return view('manajer.pinjaman.pinjaman', compact('pinjaman', 'jenisPinjaman'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pinjaman_id' => 'required|exists:jenis_pinjaman,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_pinjaman_id.required' => 'Jenis pinjaman wajib dipilih',
            'jenis_pinjaman_id.exists' => 'Jenis pinjaman tidak valid',
            'nama.required' => 'Nama produk pinjaman wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Pinjaman::create([
            'jenis_pinjaman_id' => $request->jenis_pinjaman_id,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pinjaman_id' => 'required|exists:jenis_pinjaman,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'jenis_pinjaman_id.required' => 'Jenis pinjaman wajib dipilih',
            'jenis_pinjaman_id.exists' => 'Jenis pinjaman tidak valid',
            'nama.required' => 'Nama produk pinjaman wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update([
            'jenis_pinjaman_id' => $request->jenis_pinjaman_id,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil diupdate');
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        
        if ($pinjaman->konfigurasi()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Produk pinjaman tidak dapat dihapus karena sudah memiliki konfigurasi');
        }

        $pinjaman->delete();

        return redirect()->route('manajer.pinjaman.index')
            ->with('success', 'Produk pinjaman berhasil dihapus');
    }
}