@extends('layouts.app')

@section('page-name', 'Proses Pencairan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pencairan-pinjaman.index') }}">Pencairan Pinjaman</a></li>
    <li class="breadcrumb-item active">Proses Pencairan</li>
@endsection

@section('content')
<form method="POST" action="{{ route('teller.pencairan-pinjaman.store', $pengajuan->id) }}">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <!-- Informasi Pengajuan -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0 fw-bold text-white">Informasi Pengajuan</h4>
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
                            <th>Produk Pinjaman</th>
                            <td>: {{ $pengajuan->pinjaman->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Nasabah</th>
                            <td>: <strong>{{ $pengajuan->pengguna->nama_lengkap ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <th>Kode Nasabah</th>
                            <td>: {{ $pengajuan->pengguna->kode_nasabah ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Detail Pencairan -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="card-title mb-0 fw-bold text-white">Detail Pencairan</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Jumlah Disetujui</th>
                            <td>: <strong class="text-primary">Rp {{ number_format($pengajuan->jumlah_disetujui, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Biaya Provisi</th>
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
                            <th>Biaya Meterai</th>
                            <td>: Rp {{ number_format($pengajuan->biaya_meterai, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th><strong>Total Biaya</strong></th>
                            <td>: <strong class="text-danger">Rp {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr class="bg-light">
                            <th><strong>Jumlah Diterima Bersih</strong></th>
                            <td>: <strong class="text-success">Rp {{ number_format($pengajuan->jumlah_disetujui - $pengajuan->total_biaya, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>

                    <hr>

                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">Tenor</th>
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
                            <th><strong>Total Kewajiban</strong></th>
                            <td>: <strong>Rp {{ number_format($pengajuan->total_kewajiban, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Form Metode Pencairan -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="card-title mb-0 fw-bold text-white">Metode Pencairan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Metode Pencairan <span class="text-danger">*</span></label>
                        <select name="metode_pencairan" id="metodePencairan" class="form-control @error('metode_pencairan') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="1" {{ old('metode_pencairan') == 1 ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="2" {{ old('metode_pencairan') == 2 ? 'selected' : '' }}>Tunai</option>
                        </select>
                        @error('metode_pencairan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="transferFields" style="display: none;">
                        <div class="form-group">
                            <label>Bank Tujuan <span class="text-danger">*</span></label>
                            <input type="text" name="bank_tujuan" class="form-control @error('bank_tujuan') is-invalid @enderror" 
                                   value="{{ old('bank_tujuan', $pengajuan->pengguna->bank ?? '') }}">
                            @error('bank_tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" 
                                   value="{{ old('nomor_rekening', $pengajuan->pengguna->no_rekening ?? '') }}">
                            @error('nomor_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Pemilik Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nama_rekening" class="form-control @error('nama_rekening') is-invalid @enderror" 
                                   value="{{ old('nama_rekening', $pengajuan->pengguna->nama_lengkap ?? '') }}">
                            @error('nama_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Agunan Info (jika ada) -->
            @if($pengajuan->pinjaman->konfigurasi && $pengajuan->pinjaman->konfigurasi->wajib_agunan == 1 && $pengajuan->agunan->count() > 0)
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="card-title fw-bold text-white">Status Agunan</h4>
                </div>
                <div class="card-body">
                    @php $agunan = $pengajuan->agunan->first(); @endphp
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th>Nama Agunan</th>
                            <td>: {{ $agunan->nama_agunan }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Penjaminan</th>
                            <td>: Rp {{ number_format($agunan->nilai_penjaminan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: <span class="badge {{ $pengajuan->agunan_status_badge }}">{{ $pengajuan->agunan_status_text }}</span></td>
                        </tr>
                    </table>
                    <div class="alert alert-info mb-0 mt-2">
                        <small><i class="fa fa-info-circle"></i> Agunan akan otomatis berstatus <strong>Aktif</strong> setelah pencairan</small>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Konfirmasi</h4>
                </div>
                <div class="card-body">
                    <button type="submit" class="btn btn-success btn-block btn-lg">
                        <i class="fa fa-check-circle"></i> Proses Pencairan
                    </button>
                    <a href="{{ route('teller.pencairan-pinjaman.index') }}" class="btn btn-secondary btn-block">
                        <i class="fa fa-arrow-left"></i> Batal
                    </a>
                    
                    <div class="alert alert-warning mt-3 mb-0">
                        <small><strong>Perhatian:</strong> Proses pencairan akan membuat pinjaman aktif dan jadwal angsuran secara otomatis.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#metodePencairan').on('change', function() {
        if ($(this).val() == '1') {
            $('#transferFields').show();
            $('#transferFields input').prop('required', true);
        } else {
            $('#transferFields').hide();
            $('#transferFields input').prop('required', false);
        }
    });
    
    // Trigger on page load if old value exists
    if ($('#metodePencairan').val() == '1') {
        $('#transferFields').show();
    }
});
</script>
@endsection