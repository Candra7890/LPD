@extends('layouts.app')

@section('page-name', 'Riwayat Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Riwayat Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Riwayat Pinjaman Lunas</h4>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
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
                                <th>No. Pinjaman</th>
                                <th>Nasabah</th>
                                <th>Produk</th>
                                <th>Pokok Pinjaman</th>
                                <th>Total Dibayar</th>
                                <th>Tenor</th>
                                <th>Tanggal Pencairan</th>
                                <th>Tanggal Pelunasan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPinjaman as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pinjaman }}</td>
                                <td>
                                    <strong>{{ $item->pengguna->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->pengguna->kode_nasabah ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pinjaman->nama ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($item->pokok_pinjaman, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->tenor }} Bulan</td>
                                <td>{{ $item->tanggal_pencairan->format('d/m/Y') }}</td>
                                <td>{{ $item->tanggal_pelunasan->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('teller.riwayat-pinjaman.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail Riwayat">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada riwayat pinjaman</td>
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
        order: [[8, 'desc']]
    });
});
</script>
@endsection