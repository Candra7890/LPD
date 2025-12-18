<?php

namespace App\Http\Controllers;


use App\Services\LayananAngsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranAngsuranController extends Controller
{
    protected $layananAngsuran;

    public function __construct(LayananAngsuran $layananAngsuran)
    {
        $this->layananAngsuran = $layananAngsuran;
    }

    public function create($pinjamanAktifId)
    {
        $info = $this->layananAngsuran->getPembayaranInfo($pinjamanAktifId);
        
        // Extract variables for view
        $pinjamanAktif = $info['pinjamanAktif'];
        $jadwalAngsuranBelumLunas = $info['jadwalAngsuranBelumLunas'];
        $totalTunggakan = $info['totalTunggakan'];
        $totalDenda = $info['totalDenda'];
        
        return view('teller.pinjaman.pembayaran.create', compact(
            'pinjamanAktif',
            'jadwalAngsuranBelumLunas',
            'totalTunggakan',
            'totalDenda'
        ));
    }
    
    public function store(Request $request, $pinjamanAktifId)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|in:1,2,3,4',
            'referensi_pembayaran' => $request->metode_pembayaran == '2' || $request->metode_pembayaran == '3' 
                ? 'required|string|max:255' 
                : 'nullable|string|max:255',
            'keterangan' => 'nullable|string'
        ], [
            'referensi_pembayaran.required' => 'Nomor referensi bank wajib diisi untuk metode Transfer/VA.'
        ]);

        DB::beginTransaction();
        try {
            $result = $this->layananAngsuran->processPembayaran($pinjamanAktifId, $request->all());
            
            DB::commit();
            
            $message = "Pembayaran berhasil! Total: Rp " . number_format($result['jumlah_bayar'], 0, ',', '.');
            if ($result['sisa_lebih'] > 0) {
                $message .= " (Kelebihan Rp " . number_format($result['sisa_lebih'], 0, ',', '.') . " otomatis dialokasikan ke angsuran berikutnya)";
            }
            
            return redirect()->route('teller.pinjaman-aktif.show', $pinjamanAktifId)
                ->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function history($pinjamanAktifId)
    {
        $pinjamanAktif = $this->layananAngsuran->getPinjamanAktifById($pinjamanAktifId);
        $pembayaran = $this->layananAngsuran->getHistoryPembayaran($pinjamanAktifId);
        
        return view('teller.pinjaman.pembayaran.history', compact('pinjamanAktif', 'pembayaran'));
    }
}