@extends('layouts.app')

@section('page-name', 'Detail Riwayat Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.riwayat-pinjaman.index') }}">Riwayat Pinjaman</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Informasi Pinjaman</h4>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>No. Pinjaman</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $riwayatPinjaman->nomor_pinjaman }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Produk Pinjaman</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $riwayatPinjaman->pinjaman->nama ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Pokok Pinjaman</strong>
                    </div>
                    <div class="col-md-8">
                        Rp {{ number_format($riwayatPinjaman->pokok_pinjaman, 0, ',', '.') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tenor</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $riwayatPinjaman->tenor }} Bulan
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tanggal Pencairan</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $riwayatPinjaman->tanggal_pencairan->format('d/m/Y') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tanggal Pelunasan</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $riwayatPinjaman->tanggal_pelunasan->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Ringkasan Pembayaran</h4>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Total Pokok Dibayar</strong></td>
                            <td class="text-right">Rp {{ number_format($riwayatPinjaman->total_pokok_dibayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Bunga Dibayar</strong></td>
                            <td class="text-right">Rp {{ number_format($riwayatPinjaman->total_bunga_dibayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Denda Dibayar</strong></td>
                            <td class="text-right">Rp {{ number_format($riwayatPinjaman->total_denda_dibayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>TOTAL DIBAYAR</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($riwayatPinjaman->total_dibayar, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Data Nasabah</h4>
                
                <div class="mb-3">
                    <small class="text-muted">Kode Nasabah</small>
                    <p class="mb-0"><strong>{{ $riwayatPinjaman->pengguna->kode_nasabah ?? '-' }}</strong></p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Nama Lengkap</small>
                    <p class="mb-0"><strong>{{ $riwayatPinjaman->pengguna->nama_lengkap ?? '-' }}</strong></p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">NIK</small>
                    <p class="mb-0">{{ $riwayatPinjaman->pengguna->nik ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">No. HP</small>
                    <p class="mb-0">{{ $riwayatPinjaman->pengguna->no_hp ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Alamat</small>
                    <p class="mb-0">{{ $riwayatPinjaman->pengguna->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <span class="badge badge-success badge-pill" style="font-size: 16px; padding: 10px 20px;">
                    <i class="fa fa-check-circle"></i> LUNAS
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="{{ route('teller.riwayat-pinjaman.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection