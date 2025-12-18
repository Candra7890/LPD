<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiPinjaman extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'konfigurasi_pinjaman';

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }
}