@extends('layouts.app')

@section('page-name', 'Pinjaman Aktif')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Pinjaman Aktif</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Pinjaman Aktif</h4>
                    <div>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#dendaCheckerModal">
                            <i class="fa fa-sync"></i> Cek & Update Denda
                        </button>
                    </div>
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
                                <th>Tanggal Pencairan</th>
                                <th>Nasabah</th>
                                <th>Produk</th>
                                <th>Pokok Pinjaman</th>
                                <th>Sisa Pokok</th>
                                <th>Tenor</th>
                                <th>Status</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjamanAktif as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pinjaman }}</td>
                                <td>{{ $item->tanggal_pencairan->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $item->pengguna->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->pengguna->kode_nasabah ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pinjaman->nama ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($item->pokok_pinjaman, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->sisa_pokok, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->sisa_tenor }}/{{ $item->tenor_bulan }} Bulan</td>
                                <td>
                                    <span class="badge {{ $item->status_badge }}">
                                        {{ $item->status_text }}
                                    </span>
                                    @if($item->status == 2 && $item->hari_tunggakan > 0)
                                        <br><small class="text-danger">{{ $item->hari_tunggakan }} hari</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('teller.pinjaman-aktif.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail Pinjaman">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teller.pinjaman-aktif.jadwal', $item->id) }}" 
                                       class="btn btn-sm btn-primary" title="Jadwal Angsuran">
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                    <a href="{{ route('teller.pembayaran-angsuran.create', $item->id) }}" 
                                       class="btn btn-sm btn-success" title="Bayar Angsuran">
                                        <i class="fa fa-money"></i>
                                    </a>
                                    <a href="{{ route('teller.pembayaran-angsuran.history', $item->id) }}" 
                                       class="btn btn-sm btn-secondary" title="History Pembayaran">
                                        <i class="fa fa-history"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada pinjaman aktif</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Denda Checker -->
<div class="modal fade" id="dendaCheckerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">Cek & Update Denda Otomatis</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('teller.denda-checker.check') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Informasi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Sistem akan mengecek semua pinjaman aktif</li>
                            <li>Membandingkan tanggal jatuh tempo dengan tanggal hari ini</li>
                            <li>Menghitung denda sesuai konfigurasi produk pinjaman</li>
                            <li>Mempertimbangkan toleransi periode denda</li>
                            <li>Update status menjadi "Menunggak" jika perlu</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i> 
                        <strong>Peringatan!</strong> Proses ini akan mengupdate data denda untuk semua pinjaman yang terlambat.
                    </div>

                    <p class="mb-0">Apakah Anda yakin ingin menjalankan pengecekan denda?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-sync"></i> Ya, Jalankan Sekarang
                    </button>
                </div>
            </form>
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