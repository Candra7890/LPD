@extends('layouts.app')

@section('page-name', 'Tunggakan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Tunggakan Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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

                <!-- Summary Cards -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="text-white">{{ $pinjamanTunggakan->count() }}</h5>
                                <small>Total Pinjaman Menunggak</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="text-white">Rp {{ number_format($pinjamanTunggakan->sum('sisa_pokok'), 0, ',', '.') }}</h5>
                                <small>Total Sisa Pokok</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="text-white">Rp {{ number_format($pinjamanTunggakan->sum('denda_belum_terbayar'), 0, ',', '.') }}</h5>
                                <small>Total Denda</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h5 class="text-white">{{ $pinjamanTunggakan->where('agunan', '!=', null)->count() }}</h5>
                                <small>Pinjaman Dengan Agunan</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>No. Pinjaman</th>
                                <th>Nasabah</th>
                                <th>Produk</th>
                                <th>Sisa Pokok</th>
                                <th>Hari Tunggakan</th>
                                <th>Denda</th>
                                <th>Agunan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjamanTunggakan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pinjaman }}</td>
                                <td>
                                    <strong>{{ $item->pengguna->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->pengguna->kode_nasabah ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pinjaman->nama ?? '-' }}</td>
                                <td class="text-right">
                                    <strong class="text-danger">Rp {{ number_format($item->sisa_pokok, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-danger">{{ $item->hari_tunggakan }} Hari</span>
                                </td>
                                <td class="text-right">
                                    <span class="text-danger">Rp {{ number_format($item->denda_belum_terbayar, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    @if($item->agunan->count() > 0)
                                        <span class="badge badge-success">Ada ({{ $item->agunan->count() }})</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('teller.tunggakan-pinjaman.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teller.pembayaran-angsuran.create', $item->id) }}" 
                                       class="btn btn-sm btn-success" title="Bayar">
                                        <i class="fa fa-money"></i>
                                    </a>
                                    @if($item->agunan->count() > 0 && $item->agunan->first()->status != 6)
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            data-toggle="modal" 
                                            data-target="#sitaModal{{ $item->id }}"
                                            title="Sita Agunan">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Sita Agunan -->
                            <div class="modal fade" id="sitaModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title text-white">Konfirmasi Penyitaan Agunan</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('teller.tunggakan-pinjaman.sita-agunan', $item->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="alert alert-warning">
                                                    <i class="fa fa-warning"></i> 
                                                    <strong>Peringatan!</strong> Anda akan menyita agunan untuk pinjaman <strong>{{ $item->nomor_pinjaman }}</strong>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Tanggal Penyitaan <span class="text-danger">*</span></label>
                                                    <input type="date" name="tanggal_penyitaan" class="form-control" 
                                                           value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Alasan Penyitaan <span class="text-danger">*</span></label>
                                                    <textarea name="alasan_penyitaan" class="form-control" rows="3" 
                                                              placeholder="Masukkan alasan penyitaan agunan" required></textarea>
                                                </div>

                                                <div class="mb-2">
                                                    <strong>Agunan yang akan disita:</strong>
                                                    <ul class="mt-2">
                                                        @foreach($item->agunan as $agunan)
                                                        <li>{{ $agunan->nama_agunan }} - Rp {{ number_format($agunan->nilai_penjaminan, 0, ',', '.') }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-check"></i> Ya, Sita Agunan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada pinjaman yang menunggak</td>
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
        order: [[5, 'desc']] // Sort by hari tunggakan descending
    });
});
</script>
@endsection