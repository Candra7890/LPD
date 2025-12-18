<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'nasabah';

    public function getFullIdentityAttribute()
    {
        return $this->kode_nasabah . ' - ' . $this->nama_lengkap;
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto)) {
            return \Illuminate\Support\Facades\Storage::url($this->foto);
        }
        return asset('assets/images/users/1.jpg');
    }


    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Non-Aktif';
    }

    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusPerkawinanTextAttribute()
    {
        $status = [
            'belum_kawin' => 'Belum Kawin',
            'kawin' => 'Kawin',
            'cerai' => 'Cerai',
        ];
        return $status[$this->status_perkawinan] ?? '-';
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
}