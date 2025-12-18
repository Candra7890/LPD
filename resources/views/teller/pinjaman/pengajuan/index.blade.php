@extends('layouts.app')

@section('page-name', 'Pengajuan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Pengajuan Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Data Pengajuan Pinjaman</h4>
                    <a href="{{ route('teller.pengajuan-pinjaman.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Buat Pengajuan Baru
                    </a>
                </div>
                
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
                                <th>Tanggal</th>
                                <th>Nasabah</th>
                                <th>Produk</th>
                                <th>Plafon</th>
                                <th>Status Agunan</th>
                                <th>Status Pengajuan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nomor_pengajuan }}</td>
                                <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $item->pengguna->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->pengguna->kode_nasabah ?? '-' }}</small>
                                </td>
                                <td>{{ $item->pinjaman->nama ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($item->jumlah_pengajuan, 0, ',', '.') }}</td>
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
                                    <span class="badge {{ $item->status_badge }}">
                                        {{ $item->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('teller.pengajuan-pinjaman.show', $item->id) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    @php
                                        $needsAgunan = $item->pinjaman->konfigurasi && $item->pinjaman->konfigurasi->wajib_agunan == 1;
                                        $hasAgunan = $item->agunan->count() > 0;
                                        $agunanApproved = $hasAgunan && $item->agunan->first()->status == 1;
                                        $agunanPending = $hasAgunan && $item->agunan->first()->status == 3;
                                    @endphp
                                    
                                    {{-- Upload Agunan Button --}}
                                    @if($item->status == 0 && $needsAgunan && !$hasAgunan)
                                        <a href="{{ route('teller.agunan.create', $item->id) }}" 
                                           class="btn btn-sm btn-primary" title="Upload Agunan">
                                            <i class="fa fa-upload"></i>
                                        </a>
                                    @endif
                                    
                                    {{-- Approve/Reject Agunan Buttons --}}
                                    @if($item->status == 0 && $needsAgunan && $agunanPending)
                                        <button type="button" 
                                                class="btn btn-sm btn-success" 
                                                onclick="approveAgunan({{ $item->agunan->first()->id }})"
                                                title="Setujui Agunan">
                                            <i class="fa fa-check"></i> Agunan
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="rejectAgunan({{ $item->agunan->first()->id }})"
                                                title="Tolak Agunan">
                                            <i class="fa fa-times"></i> Agunan
                                        </button>
                                    @endif
                                    
                                    {{-- Approve/Reject Pengajuan Buttons --}}
                                    @if($item->status == 0 && (!$needsAgunan || $agunanApproved))
                                        <button type="button" 
                                                class="btn btn-sm btn-success" 
                                                onclick="showApproveModal({{ $item->id }}, '{{ $item->nomor_pengajuan }}', {{ $item->jumlah_pengajuan }})"
                                                title="Setujui Pengajuan">
                                            <i class="fa fa-check-circle"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="showRejectModal({{ $item->id }}, '{{ $item->nomor_pengajuan }}')"
                                                title="Tolak Pengajuan">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data pengajuan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve Pengajuan -->
<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formApprove">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Setujui pengajuan <strong id="nomorPengajuanApprove"></strong>?</p>
                    <div class="form-group">
                        <label>Jumlah Disetujui <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_disetujui" id="jumlahDisetujui" 
                               class="form-control" required step="0.01" min="0">
                        <small class="text-muted">Plafon Pengajuan: Rp <span id="plafonPengajuan"></span></small>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject Pengajuan -->
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formReject">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tolak pengajuan <strong id="nomorPengajuanReject"></strong>?</p>
                    <div class="form-group">
                        <label>Catatan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Forms for Agunan Actions -->
<form method="POST" id="formApproveAgunan" style="display: none;">
    @csrf
    @method('PUT')
</form>

<form method="POST" id="formRejectAgunan" style="display: none;">
    @csrf
    @method('PUT')
</form>
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

function showApproveModal(id, nomorPengajuan, plafon) {
    $('#formApprove').attr('action', '{{ url("teller/pengajuan-pinjaman") }}/' + id + '/approve');
    $('#nomorPengajuanApprove').text(nomorPengajuan);
    $('#jumlahDisetujui').val(plafon);
    $('#plafonPengajuan').text(formatRupiah(plafon));
    $('#modalApprove').modal('show');
}

function showRejectModal(id, nomorPengajuan) {
    $('#formReject').attr('action', '{{ url("teller/pengajuan-pinjaman") }}/' + id + '/reject');
    $('#nomorPengajuanReject').text(nomorPengajuan);
    $('#modalReject').modal('show');
}

function approveAgunan(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui agunan ini?')) {
        $('#formApproveAgunan').attr('action', '{{ url("teller/agunan") }}/' + id + '/approve');
        $('#formApproveAgunan').submit();
    }
}

function rejectAgunan(id) {
    if (confirm('Apakah Anda yakin ingin menolak agunan ini?')) {
        $('#formRejectAgunan').attr('action', '{{ url("teller/agunan") }}/' + id + '/reject');
        $('#formRejectAgunan').submit();
    }
}

function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID').format(amount);
}
</script>
@endsection