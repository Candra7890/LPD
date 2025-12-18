@extends('layouts.app')

@section('page-name', 'Pencairan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Pencairan Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Daftar Pengajuan Siap Dicairkan</h4>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>No. Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nasabah</th>
                                <th>Produk</th>
                                <th>Jumlah Disetujui</th>
                                <th>Tenor</th>
                                <th>Status Agunan</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanSiapCair as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pengajuan }}</td>
                                <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $item->pengguna->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->pengguna->kode_nasabah ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pinjaman->nama ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($item->jumlah_disetujui, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->tenor }} Bulan</td>
                                <td>
                                    @if($item->pinjaman->konfigurasi && $item->pinjaman->konfigurasi->wajib_agunan == 1)
                                        @if($item->agunan_status_text)
                                            <span class="badge {{ $item->agunan_status_badge }}">
                                                {{ $item->agunan_status_text }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Belum Upload</span>
                                        @endif
                                    @else
                                        <span class="badge badge-light">Tidak Perlu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 1)
                                        <a href="{{ route('teller.pencairan-pinjaman.create', $item->id) }}" 
                                        class="btn btn-sm btn-success" title="Proses Pencairan">
                                            <i class="fa fa-money"></i> Cairkan
                                        </a>
                                    @endif

                                    <a href="{{ route('teller.pencairan-pinjaman.showPengajuan', $item->id) }}" 
                                    class="btn btn-sm btn-info" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada pengajuan yang siap dicairkan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        order: [[2, 'desc']]
    });
});
</script>
@endsection