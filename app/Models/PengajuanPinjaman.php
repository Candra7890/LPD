<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPinjaman extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pengajuan_pinjaman';

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_pencairan' => 'date',
        'jumlah_pengajuan' => 'decimal:2',
        'jumlah_disetujui' => 'decimal:2',
        'total_angsuran' => 'decimal:2',
        'total_bunga' => 'decimal:2',
        'total_kewajiban' => 'decimal:2',
        'biaya_provisi' => 'decimal:2',
        'biaya_administrasi' => 'decimal:2',
        'biaya_asuransi' => 'decimal:2',
        'total_biaya' => 'decimal:2',
        'tenor' => 'integer',
        'status' => 'integer',
        'status_approval_teller' => 'integer',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Nasabah::class, 'pengguna_id');
    }

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }

    public function agunan()
    {
        return $this->hasMany(Agunan::class, 'pengajuan_pinjaman_id');
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            0 => 'Pengajuan',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Dicairkan',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            0 => 'badge-warning',
            1 => 'badge-success',
            2 => 'badge-danger',
            3 => 'badge-primary',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getAgunanStatusTextAttribute()
    {
        $agunan = $this->agunan()->first();
        
        if (!$agunan) {
            return null;
        }

        $statuses = [
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Menunggu Persetujuan',
            4 => 'Aktif',
            5 => 'Dilepaskan',
            6 => 'Disita',
        ];

        return $statuses[$agunan->status] ?? 'Unknown';
    }

    public function getAgunanStatusBadgeAttribute()
    {
        $agunan = $this->agunan()->first();
        
        if (!$agunan) {
            return null;
        }

        $badges = [
            1 => 'badge-success',
            2 => 'badge-danger',
            3 => 'badge-warning',
            4 => 'badge-info',
            5 => 'badge-secondary',
            6 => 'badge-dark',
        ];

        return $badges[$agunan->status] ?? 'badge-secondary';
    }
}