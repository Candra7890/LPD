<?php

namespace App\Http\Controllers;

use App\Models\JenisSimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisSimpananController extends Controller
{
    public function index()
    {
        $jenisSimpanan = JenisSimpanan::orderBy('created_at', 'desc')->get();
        return view('manajer.simpanan.jenis-simpanan', compact('jenisSimpanan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama jenis simpanan wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        JenisSimpanan::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.jenis-simpanan.index')
            ->with('success', 'Jenis simpanan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama jenis simpanan wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jenisSimpanan = JenisSimpanan::findOrFail($id);
        $jenisSimpanan->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('manajer.jenis-simpanan.index')
            ->with('success', 'Jenis simpanan berhasil diupdate');
    }

    public function destroy($id)
    {
        $jenisSimpanan = JenisSimpanan::findOrFail($id);
        
        if ($jenisSimpanan->simpanan()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Jenis simpanan tidak dapat dihapus karena masih digunakan');
        }

        $jenisSimpanan->delete();

        return redirect()->route('manajer.jenis-simpanan.index')
            ->with('success', 'Jenis simpanan berhasil dihapus');
    }
}