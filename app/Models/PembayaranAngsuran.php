<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranAngsuran extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pembayaran_angsuran';

    public function pinjamanAktif()
    {
        return $this->belongsTo(PinjamanAktif::class, 'pinjaman_aktif_id');
    }

    public function jadwalAngsuran()
    {
        return $this->belongsTo(JadwalAngsuran::class, 'jadwal_angsuran_id');
    }
}