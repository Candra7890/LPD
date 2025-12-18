@extends('layouts.app')

@section('page-name', 'Detail Pengajuan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pengajuan-pinjaman.index') }}">Pengajuan Pinjaman</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Informasi Pengajuan -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Informasi Pengajuan</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Nomor Pengajuan</th>
                        <td>: {{ $pengajuan->nomor_pengajuan }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>: {{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: <span class="badge {{ $pengajuan->status_badge }}">{{ $pengajuan->status_text }}</span></td>
                    </tr>
                    <tr>
                        <th>Produk Pinjaman</th>
                        <td>: {{ $pengajuan->pinjaman->nama ?? '-' }}</td>
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
                        <td>: {{ $pengajuan->pengguna->kode_nasabah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>: {{ $pengajuan->pengguna->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>: {{ $pengajuan->pengguna->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>: {{ $pengajuan->pengguna->no_telepon ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Pinjaman -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Detail Pinjaman</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Plafon Pengajuan</th>
                        <td>: Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                    </tr>
                    @if($pengajuan->jumlah_disetujui)
                    <tr>
                        <th>Jumlah Disetujui</th>
                        <td>: Rp {{ number_format($pengajuan->jumlah_disetujui, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Tenor</th>
                        <td>: {{ $pengajuan->tenor }} Bulan</td>
                    </tr>
                    <tr>
                        <th>Angsuran Per Bulan</th>
                        <td>: Rp {{ number_format($pengajuan->total_angsuran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Bunga</th>
                        <td>: Rp {{ number_format($pengajuan->total_bunga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Kewajiban</th>
                        <td>: Rp {{ number_format($pengajuan->total_kewajiban, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Biaya-Biaya -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Rincian Biaya</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Biaya Provisi</th>
                        <td>: Rp {{ number_format($pengajuan->biaya_provisi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Biaya Administrasi</th>
                        <td>: Rp {{ number_format($pengajuan->biaya_administrasi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Biaya Asuransi</th>
                        <td>: Rp {{ number_format($pengajuan->biaya_asuransi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th><strong>Total Biaya</strong></th>
                        <td>: <strong>Rp {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <th><strong>Jumlah Diterima Bersih</strong></th>
                        <td>: <strong>Rp {{ number_format($pengajuan->jumlah_pengajuan - $pengajuan->total_biaya, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Agunan (jika ada) -->
        @if($pengajuan->pinjaman->konfigurasi && $pengajuan->pinjaman->konfigurasi->wajib_agunan == 1)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Informasi Agunan</h4>
            </div>
            <div class="card-body">
                @if($pengajuan->agunan->count() > 0)
                    @php $agunan = $pengajuan->agunan->first(); @endphp
                    <table class="table table-borderless">
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
                            <th>Status Kepemilikan</th>
                            <td>: 
                                @if($agunan->status_kepemilikan == 1) Pribadi
                                @elseif($agunan->status_kepemilikan == 2) Keluarga
                                @elseif($agunan->status_kepemilikan == 3) Perusahaan
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Pemilik</th>
                            <td>: {{ $agunan->nama_pemilik }}</td>
                        </tr>
                        <tr>
                            <th>Status Agunan</th>
                            <td>: <span class="badge {{ $pengajuan->agunan_status_badge }}">{{ $pengajuan->agunan_status_text }}</span></td>
                        </tr>
                        @if($agunan->file_agunan)
                        <tr>
                            <th>Dokumen Agunan</th>
                            <td>: 
                                <a href="{{ Storage::url($agunan->file_agunan) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i> Lihat Dokumen
                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>
                @else
                    <div class="alert alert-warning">
                        Agunan belum diunggah. Silakan unggah agunan untuk melanjutkan proses.
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Catatan -->
        @if($pengajuan->catatan_pengajuan_teller)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Catatan Teller</h4>
            </div>
            <div class="card-body">
                <p>{{ $pengajuan->catatan_pengajuan_teller }}</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Aksi</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('teller.pengajuan-pinjaman.index') }}" 
                   class="btn btn-secondary btn-block">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                
                @php
                    $needsAgunan = $pengajuan->pinjaman->konfigurasi && $pengajuan->pinjaman->konfigurasi->wajib_agunan == 1;
                    $hasAgunan = $pengajuan->agunan->count() > 0;
                    $agunanApproved = $hasAgunan && $pengajuan->agunan->first()->status == 1;
                @endphp
                
                @if($pengajuan->status == 0)
                    @if($needsAgunan && !$hasAgunan)
                        <a href="{{ route('teller.agunan.create', $pengajuan->id) }}" 
                           class="btn btn-primary btn-block mt-2">
                            <i class="fa fa-upload"></i> Upload Agunan
                        </a>
                    @endif
                    
                    @if(!$needsAgunan || $agunanApproved)
                        <button type="button" 
                                class="btn btn-success btn-block mt-2" 
                                onclick="showApproveModal()">
                            <i class="fa fa-check-circle"></i> Setujui Pengajuan
                        </button>
                        <button type="button" 
                                class="btn btn-danger btn-block mt-2" 
                                onclick="showRejectModal()">
                            <i class="fa fa-times-circle"></i> Tolak Pengajuan
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="modalApprove" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('teller.pengajuan-pinjaman.approve', $pengajuan->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jumlah Disetujui <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_disetujui" 
                               class="form-control" required step="0.01" min="0"
                               value="{{ $pengajuan->jumlah_pengajuan }}">
                        <small class="text-muted">Plafon Pengajuan: Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</small>
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

<!-- Modal Reject -->
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('teller.pengajuan-pinjaman.reject', $pengajuan->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
@endsection

@section('js')
<script>
function showApproveModal() {
    $('#modalApprove').modal('show');
}

function showRejectModal() {
    $('#modalReject').modal('show');
}
</script>
@endsection