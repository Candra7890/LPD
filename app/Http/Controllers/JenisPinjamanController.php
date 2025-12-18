<?php

namespace App\Http\Controllers;

use App\Models\JenisPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisPinjamanController extends Controller
{
    public function index()
    {
        $jenisPinjaman = JenisPinjaman::orderBy('created_at', 'desc')->get();
        return view('manajer.pinjaman.jenis-pinjaman', compact('jenisPinjaman'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama jenis pinjaman wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        JenisPinjaman::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.jenis-pinjaman.index')
            ->with('success', 'Jenis pinjaman berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama jenis pinjaman wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jenisPinjaman = JenisPinjaman::findOrFail($id);
        $jenisPinjaman->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.jenis-pinjaman.index')
            ->with('success', 'Jenis pinjaman berhasil diupdate');
    }

    public function destroy($id)
    {
        $jenisPinjaman = JenisPinjaman::findOrFail($id);
        
        if ($jenisPinjaman->pinjaman()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Jenis pinjaman tidak dapat dihapus karena masih dipergunakan pada data pinjaman');
        }

        $jenisPinjaman->delete();

        return redirect()->route('manajer.jenis-pinjaman.index')
            ->with('success', 'Jenis pinjaman berhasil dihapus');
    }
}