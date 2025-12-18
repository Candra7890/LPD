@extends('layouts.app')

@section('page-name', 'Detail Pinjaman Aktif')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pinjaman-aktif.index') }}">Pinjaman Aktif</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Informasi Pinjaman -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Informasi Pinjaman</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Nomor Pinjaman</th>
                        <td>: {{ $pinjamanAktif->nomor_pinjaman }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Pengajuan</th>
                        <td>: {{ $pinjamanAktif->pengajuan_pinjaman->nomor_pengajuan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pencairan</th>
                        <td>: {{ $pinjamanAktif->tanggal_pencairan->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: <span class="badge {{ $pinjamanAktif->status_badge }}">{{ $pinjamanAktif->status_text }}</span></td>
                    </tr>
                    <tr>
                        <th>Produk Pinjaman</th>
                        <td>: {{ $pinjamanAktif->pinjaman->nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Informasi Nasabah -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Informasi Nasabah</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Kode Nasabah</th>
                        <td>: {{ $pinjamanAktif->pengguna->kode_nasabah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $pinjamanAktif->pengguna->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ $pinjamanAktif->pengguna->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>: {{ $pinjamanAktif->pengguna->no_telepon ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Pinjaman -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Detail Pinjaman</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Pokok Pinjaman</th>
                        <td>: Rp {{ number_format($pinjamanAktif->pokok_pinjaman, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Sisa Pokok</th>
                        <td>: <strong class="text-danger">Rp {{ number_format($pinjamanAktif->sisa_pokok, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tenor</th>
                        <td>: {{ $pinjamanAktif->tenor_bulan }} Bulan</td>
                    </tr>
                    <tr>
                        <th>Sisa Tenor</th>
                        <td>: {{ $pinjamanAktif->sisa_tenor }} Bulan</td>
                    </tr>
                    <tr>
                        <th>Suku Bunga</th>
                        <td>: {{ $pinjamanAktif->suku_bunga }}% per bulan</td>
                    </tr>
                    <tr>
                        <th>Angsuran Per Bulan</th>
                        <td>: Rp {{ number_format($pinjamanAktif->angsuran_per_bulan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Bunga</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_bunga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Kewajiban</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_kewajiban, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Status Pembayaran</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Total Dibayar</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Pokok Terbayar</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_pokok_dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Bunga Terbayar</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_bunga_dibayar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Jatuh Tempo Berikutnya</th>
                        <td>: {{ $pinjamanAktif->tanggal_jatuh_tempo_berikutnya ? $pinjamanAktif->tanggal_jatuh_tempo_berikutnya->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @if($pinjamanAktif->hari_tunggakan > 0)
                    <tr>
                        <th>Hari Tunggakan</th>
                        <td>: <span class="badge badge-danger">{{ $pinjamanAktif->hari_tunggakan }} Hari</span></td>
                    </tr>
                    <tr>
                        <th>Total Denda</th>
                        <td>: Rp {{ number_format($pinjamanAktif->total_denda, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Denda Belum Terbayar</th>
                        <td>: <span class="text-danger">Rp {{ number_format($pinjamanAktif->denda_belum_terbayar, 0, ',', '.') }}</span></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Agunan (jika ada) -->
        @if($pinjamanAktif->agunan->count() > 0)
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="card-title mb-0 fw-bold text-white">Informasi Agunan</h4>
            </div>
            <div class="card-body">
                @foreach($pinjamanAktif->agunan as $agunan)
                <div class="mb-3 pb-3 border-bottom">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <th width="35%">Nomor Agunan</th>
                            <td>: {{ $agunan->nomor_agunan }}</td>
                        </tr>
                        <tr>
                            <th>Nama Agunan</th>
                            <td>: {{ $agunan->nama_agunan }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Pasar</th>
                            <td>: Rp {{ number_format($agunan->nilai_pasar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Penjaminan</th>
                            <td>: Rp {{ number_format($agunan->nilai_penjaminan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengikatan</th>
                            <td>: {{ $agunan->tanggal_pengikatan ? $agunan->tanggal_pengikatan->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Tersimpan</th>
                            <td>: {{ $agunan->lokasi_agunan_tersimpan }}</td>
                        </tr>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Action Buttons -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Aksi</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('teller.pinjaman-aktif.index') }}" 
                   class="btn btn-secondary btn-block">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                
                <a href="{{ route('teller.pinjaman-aktif.jadwal', $pinjamanAktif->id) }}" 
                   class="btn btn-primary btn-block mt-2">
                    <i class="fa fa-calendar"></i> Lihat Jadwal Angsuran
                </a>
            </div>
        </div>

        <!-- Progress Pembayaran -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Progress Pembayaran</h4>
            </div>
            <div class="card-body">
                @php
                    $progress = ($pinjamanAktif->pokok_pinjaman > 0) 
                        ? (($pinjamanAktif->total_pokok_dibayar / $pinjamanAktif->pokok_pinjaman) * 100) 
                        : 0;
                    
                    $progressTenor = ($pinjamanAktif->tenor_bulan > 0) 
                        ? ((($pinjamanAktif->tenor_bulan - $pinjamanAktif->sisa_tenor) / $pinjamanAktif->tenor_bulan) * 100) 
                        : 0;
                @endphp

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>Pokok Terbayar</strong>
                        <small class="fw-bold">{{ number_format($progress, 1) }}%</small>
                    </div>
                    <div class="progress mt-2" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                            style="width: {{ $progress }}%; min-width: 2em;" 
                            aria-valuenow="{{ $progress }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            {{ $progress > 0 ? number_format($progress, 1) . '%' : '' }}
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <strong>Tenor Berjalan</strong>
                        <small class="fw-bold">{{ number_format($progressTenor, 1) }}%</small>
                    </div>
                    <div class="progress mt-2" style="height: 25px;">
                        <div class="progress-bar bg-info" role="progressbar" 
                            style="width: {{ $progressTenor }}%; min-width: 2em;" 
                            aria-valuenow="{{ $progressTenor }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                            {{ $progressTenor > 0 ? number_format($progressTenor, 1) . '%' : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection