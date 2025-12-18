@extends('layouts.app')

@section('page-name', 'History Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pinjaman-aktif.index') }}">Pinjaman Aktif</a></li>
    <li class="breadcrumb-item active">History Pembayaran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Info Pinjaman -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Informasi Pinjaman</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
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
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Pokok Pinjaman</th>
                                <td>: Rp {{ number_format($pinjamanAktif->pokok_pinjaman, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total Dibayar</th>
                                <td>: <strong class="text-success">Rp {{ number_format($pinjamanAktif->total_dibayar, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <th>Sisa Pokok</th>
                                <td>: <strong class="text-danger">Rp {{ number_format($pinjamanAktif->sisa_pokok, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Pembayaran -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">History Pembayaran Angsuran</h4>
                    <a href="{{ route('teller.pinjaman-aktif.show', $pinjamanAktif->id) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Pembayaran</th>
                                <th>Tanggal Bayar</th>
                                <th>Angsuran Ke</th>
                                <th>Jumlah Bayar</th>
                                <th>Pembayaran Pokok</th>
                                <th>Pembayaran Bunga</th>
                                <th>Pembayaran Denda</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaran as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pembayaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d/m/Y') }}</td>
                                <td class="text-center">{{ $item->jadwalAngsuran->angsuran_ke ?? '-' }}</td>
                                <td class="text-right">
                                    <strong>Rp {{ number_format($item->jumlah_pembayaran, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-right">Rp {{ number_format($item->pembayaran_pokok, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item->pembayaran_bunga, 0, ',', '.') }}</td>
                                <td class="text-right">
                                    @if($item->pembayaran_denda > 0)
                                        <span class="text-danger">Rp {{ number_format($item->pembayaran_denda, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $metode = [
                                            1 => 'Tunai',
                                            2 => 'Transfer',
                                            3 => 'Auto Debet',
                                            4 => 'Virtual Account'
                                        ];
                                    @endphp
                                    {{ $metode[$item->metode_pembayaran] ?? '-' }}
                                    @if($item->referensi_pembayaran)
                                        <br><small class="text-muted">{{ $item->referensi_pembayaran }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="badge badge-success">Berhasil</span>
                                    @elseif($item->status == 2)
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($item->status == 3)
                                        <span class="badge badge-danger">Gagal</span>
                                    @else
                                        <span class="badge badge-secondary">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada history pembayaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="4" class="text-right">TOTAL:</td>
                                <td class="text-right">Rp {{ number_format($pembayaran->sum('jumlah_pembayaran'), 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($pembayaran->sum('pembayaran_pokok'), 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($pembayaran->sum('pembayaran_bunga'), 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($pembayaran->sum('pembayaran_denda'), 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
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