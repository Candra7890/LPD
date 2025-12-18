<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPinjaman extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'riwayat_pinjaman';

    protected $casts = [
        'tanggal_pencairan' => 'date',
        'tanggal_pelunasan' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }

    public function pinjaman_aktif()
    {
        return $this->belongsTo(PinjamanAktif::class, 'pinjaman_aktif_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Nasabah::class, 'pengguna_id');
    }
}