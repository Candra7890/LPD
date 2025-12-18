<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pinjaman';

    public function jenisPinjaman()
    {
        return $this->belongsTo(JenisPinjaman::class, 'jenis_pinjaman_id');
    }

    public function konfigurasi()
    {
        return $this->hasOne(KonfigurasiPinjaman::class, 'pinjaman_id');
    }

    public function getHasKonfigurasiAttribute()
    {
        return $this->konfigurasi()->exists();
    }
}