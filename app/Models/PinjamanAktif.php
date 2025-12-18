<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamanAktif extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pinjaman_aktif';

    protected $casts = [
        'tanggal_jatuh_tempo_pertama' => 'date',
        'tanggal_jatuh_tempo_berikutnya' => 'date',
        'tanggal_pencairan' => 'date',
    ];

    public function pengajuan_pinjaman()
    {
        return $this->belongsTo(PengajuanPinjaman::class, 'pengajuan_pinjaman_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Nasabah::class, 'pengguna_id');
    }

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }

    public function jadwal_angsuran()
    {
        return $this->hasMany(JadwalAngsuran::class, 'pinjaman_aktif_id');
    }

    public function agunan()
    {
        return $this->hasMany(Agunan::class, 'pinjaman_aktif_id');
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            1 => 'Aktif',
            2 => 'Menunggak',
            3 => 'Lunas',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            1 => 'badge-success',
            2 => 'badge-danger',
            3 => 'badge-info',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }
}