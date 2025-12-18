@extends('layouts.app')

@section('page-name', 'Upload Agunan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pengajuan-pinjaman.index') }}">Pengajuan Pinjaman</a></li>
    <li class="breadcrumb-item active">Upload Agunan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Form Upload Agunan</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('teller.agunan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pengajuan_pinjaman_id" value="{{ $pengajuan->id }}">

                    <div class="form-group">
                        <label>Nama Agunan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_agunan" class="form-control" 
                               value="{{ old('nama_agunan') }}" required>
                        <small class="text-muted">Contoh: Sertifikat Rumah, BPKB Motor, dll</small>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai Pasar <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_pasar" class="form-control" 
                                       value="{{ old('nilai_pasar') }}" required step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai Penjaminan <span class="text-danger">*</span></label>
                                <input type="number" name="nilai_penjaminan" class="form-control" 
                                       value="{{ old('nilai_penjaminan') }}" required step="0.01" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Kepemilikan <span class="text-danger">*</span></label>
                        <select name="status_kepemilikan" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="1" {{ old('status_kepemilikan') == 1 ? 'selected' : '' }}>Pribadi</option>
                            <option value="2" {{ old('status_kepemilikan') == 2 ? 'selected' : '' }}>Keluarga</option>
                            <option value="3" {{ old('status_kepemilikan') == 3 ? 'selected' : '' }}>Perusahaan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemilik" class="form-control" 
                               value="{{ old('nama_pemilik') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Agunan</label>
                        <textarea name="alamat_agunan" class="form-control" rows="2">{{ old('alamat_agunan') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Lokasi Penyimpanan Agunan <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_agunan_tersimpan" class="form-control" 
                               value="{{ old('lokasi_agunan_tersimpan') }}" required>
                        <small class="text-muted">Contoh: Lemari Besi Kantor Cabang, Safe Deposit Box, dll</small>
                    </div>

                    <div class="form-group">
                        <label>File Dokumen Agunan <span class="text-danger">*</span></label>
                        <input type="file" name="file_agunan" class="form-control-file" 
                               accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB</small>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Agunan
                        </button>
                        <a href="{{ route('teller.pengajuan-pinjaman.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Informasi Pengajuan</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>No. Pengajuan</th>
                        <td>{{ $pengajuan->nomor_pengajuan }}</td>
                    </tr>
                    <tr>
                        <th>Nasabah</th>
                        <td>{{ $pengajuan->pengguna->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Produk</th>
                        <td>{{ $pengajuan->pinjaman->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Plafon</th>
                        <td>Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tenor</th>
                        <td>{{ $pengajuan->tenor }} Bulan</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card bg-light">
            <div class="card-body">
                <h6 class="font-weight-bold mb-3">Panduan Upload Agunan:</h6>
                <ol class="pl-3 mb-0">
                    <li>Pastikan dokumen agunan jelas dan terbaca</li>
                    <li>File dalam format PDF, JPG, JPEG, atau PNG</li>
                    <li>Ukuran file maksimal 5MB</li>
                    <li>Nilai penjaminan biasanya 70-80% dari nilai pasar</li>
                    <li>Dokumen akan diverifikasi oleh petugas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection