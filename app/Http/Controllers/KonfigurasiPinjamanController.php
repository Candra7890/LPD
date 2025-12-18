<?php

namespace App\Http\Controllers;


use App\Models\Pinjaman;
use App\Services\LayananPinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonfigurasiPinjamanController extends Controller
{
    protected $layananPinjaman;

    public function __construct(LayananPinjaman $layananPinjaman)
    {
        $this->layananPinjaman = $layananPinjaman;
    }

    public function index(Request $request)
    {
        $pinjamanId = $request->query('pinjaman_id');
        
        if (!$pinjamanId) {
            return redirect()->route('manajer.pinjaman.index')
                ->with('error', 'Produk pinjaman tidak ditemukan');
        }

        $pinjaman = Pinjaman::with('jenisPinjaman')->findOrFail($pinjamanId);
        $konfigurasi = $this->layananPinjaman->getKonfigurasiByPinjamanId($pinjamanId);
        
        return view('manajer.pinjaman.konfigurasi-pinjaman', compact('pinjaman', 'konfigurasi'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pinjaman_id' => 'required|exists:pinjaman,id|unique:konfigurasi_pinjaman,pinjaman_id',
            'plafon_minimum' => 'required|numeric|min:0',
            'plafon_maksimum' => 'required|numeric|min:0',
            'tenor_minimum' => 'required|integer|min:0',
            'tenor_maksimum' => 'required|integer|min:0',
            'sukubunga_minimum' => 'required|numeric|min:0|max:100',
            'persentase_provisi' => 'required|numeric|min:0|max:100',
            'persentase_administrasi' => 'required|numeric|min:0|max:100',
            'persentase_asuransi' => 'required|numeric|min:0|max:100',
            'biaya_meterai' => 'required|numeric|min:0',
            'persentase_denda_harian' => 'required|numeric|min:0|max:100',
            'persentase_denda_bulanan' => 'required|numeric|min:0|max:100',
            'denda_maksimal' => 'required|numeric|min:0',
            'toleransi_periode_denda' => 'required|integer|min:0',
            'pelunasandipercepat' => 'required|in:0,1',
            'persentase_pinalti_pelunasan' => 'required|numeric|min:0|max:100',
            'wajib_agunan' => 'required|in:0,1',
        ], [
            'pinjaman_id.required' => 'Produk pinjaman wajib dipilih',
            'pinjaman_id.exists' => 'Produk pinjaman tidak valid',
            'pinjaman_id.unique' => 'Konfigurasi untuk produk ini sudah ada',
            'biaya_meterai.required' => 'Biaya meterai wajib diisi',
            'pelunasandipercepat.required' => 'Pelunasan dipercepat wajib dipilih',
            'wajib_agunan.required' => 'Wajib agunan wajib dipilih',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->plafon_maksimum <= $request->plafon_minimum) {
                $validator->errors()->add('plafon_maksimum', 'Plafon maksimum harus lebih besar dari minimum');
            }
            if ($request->tenor_maksimum <= $request->tenor_minimum) {
                $validator->errors()->add('tenor_maksimum', 'Tenor maksimum harus lebih besar dari minimum');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->layananPinjaman->storeKonfigurasi($request->all());

        return redirect()
            ->route('manajer.konfigurasi-pinjaman.index', ['pinjaman_id' => $request->pinjaman_id])
            ->with('success', 'Konfigurasi pinjaman berhasil diupdate');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pinjaman_id' => 'required|exists:pinjaman,id|unique:konfigurasi_pinjaman,pinjaman_id,' . $id,
            'plafon_minimum' => 'required|numeric|min:0',
            'plafon_maksimum' => 'required|numeric|min:0',
            'tenor_minimum' => 'required|integer|min:0',
            'tenor_maksimum' => 'required|integer|min:0',
            'sukubunga_minimum' => 'required|numeric|min:0|max:100',
            'persentase_provisi' => 'required|numeric|min:0|max:100',
            'persentase_administrasi' => 'required|numeric|min:0|max:100',
            'persentase_asuransi' => 'required|numeric|min:0|max:100',
            'biaya_meterai' => 'required|numeric|min:0',
            'persentase_denda_harian' => 'required|numeric|min:0|max:100',
            'persentase_denda_bulanan' => 'required|numeric|min:0|max:100',
            'denda_maksimal' => 'required|numeric|min:0',
            'toleransi_periode_denda' => 'required|integer|min:0',
            'pelunasandipercepat' => 'required|in:0,1',
            'persentase_pinalti_pelunasan' => 'required|numeric|min:0|max:100',
            'wajib_agunan' => 'required|in:0,1',
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->plafon_maksimum <= $request->plafon_minimum) {
                $validator->errors()->add('plafon_maksimum', 'Plafon maksimum harus lebih besar dari minimum');
            }
            if ($request->tenor_maksimum <= $request->tenor_minimum) {
                $validator->errors()->add('tenor_maksimum', 'Tenor maksimum harus lebih besar dari minimum');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->layananPinjaman->updateKonfigurasi($id, $request->all());

        return redirect()
            ->route('manajer.konfigurasi-pinjaman.index', ['pinjaman_id' => $request->pinjaman_id])
            ->with('success', 'Konfigurasi pinjaman berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->layananPinjaman->deleteKonfigurasi($id);

        return redirect()->route('manajer.konfigurasi-pinjaman.index')
            ->with('success', 'Konfigurasi pinjaman berhasil dihapus');
    }
}