<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAngsuran extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'jadwal_angsuran';

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function pinjamanAktif()
    {
        return $this->belongsTo(PinjamanAktif::class, 'pinjaman_aktif_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranAngsuran::class, 'jadwal_angsuran_id');
    }
}