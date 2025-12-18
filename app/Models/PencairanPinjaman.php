<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencairanPinjaman extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pencairan_pinjaman';

    public function pengajuan_pinjaman()
    {
        return $this->belongsTo(PengajuanPinjaman::class, 'pengajuan_pinjaman_id');
    }

    public function pinjaman_aktif()
    {
        return $this->belongsTo(PinjamanAktif::class, 'pinjaman_aktif_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Nasabah::class, 'pengguna_id');
    }

    public function getMetodePencairanTextAttribute()
    {
        $methods = [
            1 => 'Transfer Bank',
            2 => 'Tunai',
        ];

        return $methods[$this->metode_pencairan] ?? 'Unknown';
    }
}