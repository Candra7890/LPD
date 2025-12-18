<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'agunan';

    protected $casts = [
        'tanggal_pengikatan' => 'date',
        'tanggal_pelepasan' => 'date',
    ];

    public function pengajuan_pinjaman()
    {
        return $this->belongsTo(PengajuanPinjaman::class, 'pengajuan_pinjaman_id');
    }

    public function pinjaman_aktif()
    {
        return $this->belongsTo(PinjamanAktif::class, 'pinjaman_aktif_id');
    }
}
