@extends('layouts.app')

@section('page-name', 'Jadwal Angsuran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pinjaman-aktif.index') }}">Pinjaman Aktif</a></li>
    <li class="breadcrumb-item active">Jadwal Angsuran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Info -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Informasi Pinjaman</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th width="40%">Nomor Pinjaman</th>
                                <td>: {{ $pinjamanAktif->nomor_pinjaman }}</td>
                            </tr>
                            <tr>
                                <th>Nasabah</th>
                                <td>: {{ $pinjamanAktif->pengguna->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Produk</th>
                                <td>: {{ $pinjamanAktif->pinjaman->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th width="40%">Pokok Pinjaman</th>
                                <td>: Rp {{ number_format($pinjamanAktif->pokok_pinjaman, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Angsuran/Bulan</th>
                                <td>: Rp {{ number_format($pinjamanAktif->angsuran_per_bulan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span class="badge {{ $pinjamanAktif->status_badge }}">{{ $pinjamanAktif->status_text }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Angsuran Table -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Jadwal Angsuran</h4>
                    <a href="{{ route('teller.pinjaman-aktif.show', $pinjamanAktif->id) }}" 
                       class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Angsuran Ke</th>
                                <th>Jatuh Tempo</th>
                                <th>Saldo Awal</th>
                                <th>Angsuran Pokok</th>
                                <th>Angsuran Bunga</th>
                                <th>Total Angsuran</th>
                                <th>Saldo Akhir</th>
                                <th>Status</th>
                                <th>Terbayar</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalAngsuran as $jadwal)
                            <tr class="{{ $jadwal->status == 3 ? 'table-danger' : '' }}">
                                <td class="text-center">{{ $jadwal->angsuran_ke }}</td>
                                <td>{{ $jadwal->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                <td class="text-right">Rp {{ number_format($jadwal->saldo_awal, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($jadwal->angsuran_pokok, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($jadwal->angsuran_bunga, 0, ',', '.') }}</td>
                                <td class="text-right"><strong>Rp {{ number_format($jadwal->total_angsuran, 0, ',', '.') }}</strong></td>
                                <td class="text-right">Rp {{ number_format($jadwal->saldo_akhir, 0, ',', '.') }}</td>
                                <td>
                                    @if($jadwal->status == 0)
                                        <span class="badge badge-warning">Belum Bayar</span>
                                    @elseif($jadwal->status == 1)
                                        <span class="badge badge-info">Bayar Sebagian</span>
                                    @elseif($jadwal->status == 2)
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($jadwal->status == 3)
                                        <span class="badge badge-danger">Menunggak</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($jadwal->jumlah_terbayar > 0)
                                        <span class="text-success">Rp {{ number_format($jadwal->jumlah_terbayar, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($jadwal->sisa_belum_terbayar > 0)
                                        <span class="text-danger">Rp {{ number_format($jadwal->sisa_belum_terbayar, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="3" class="text-right">TOTAL:</td>
                                <td class="text-right">Rp {{ number_format($jadwalAngsuran->sum('angsuran_pokok'), 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($jadwalAngsuran->sum('angsuran_bunga'), 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($jadwalAngsuran->sum('total_angsuran'), 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                                <td class="text-right text-success">Rp {{ number_format($jadwalAngsuran->sum('jumlah_terbayar'), 0, ',', '.') }}</td>
                                <td class="text-right text-danger">Rp {{ number_format($jadwalAngsuran->sum('sisa_belum_terbayar'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-3">
                    <h6>Keterangan:</h6>
                    <ul class="list-unstyled">
                        <li><span class="badge badge-warning">Belum Bayar</span> - Angsuran belum dibayar</li>
                        <li><span class="badge badge-info">Bayar Sebagian</span> - Angsuran dibayar sebagian</li>
                        <li><span class="badge badge-success">Lunas</span> - Angsuran sudah lunas</li>
                        <li><span class="badge badge-danger">Menunggak</span> - Angsuran melewati jatuh tempo dan belum dibayar</li>
                    </ul>
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
        paging: false,
        searching: false,
        info: false,
        order: [[0, 'asc']]
    });
});
</script>
@endsection