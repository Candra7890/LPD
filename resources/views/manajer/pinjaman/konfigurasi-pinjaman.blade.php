@extends('layouts.app')

@section('page-name', 'Konfigurasi Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item"><a href="{{ route('manajer.pinjaman.index') }}">Produk Pinjaman</a></li>
    <li class="breadcrumb-item active">Konfigurasi Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1">Konfigurasi: {{ $pinjaman->nama }}</h4>
                        <small class="text-muted">{{ $pinjaman->jenisPinjaman->nama }}</small>
                    </div>
                    <a href="{{ route('manajer.pinjaman.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                @if($konfigurasi)
                    <!-- Display Configuration -->
                    <div class="configuration-display">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-warning btn-lg btn-block" onclick="editKonfigurasi()">
                                    <i class="fa fa-edit"></i> Edit Konfigurasi
                                </button>
                            </div>
                        </div>

                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 fw-bold text-white"><i class="fa fa-money"></i> Plafon & Tenor</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Plafon Minimum:</strong><br>Rp {{ number_format($konfigurasi->plafon_minimum, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Plafon Maksimum:</strong><br>Rp {{ number_format($konfigurasi->plafon_maksimum, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tenor Minimum:</strong><br>{{ $konfigurasi->tenor_minimum }} bulan</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tenor Maksimum:</strong><br>{{ $konfigurasi->tenor_maksimum }} bulan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-success mb-3">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0 fw-bold text-white"><i class="fa fa-percent"></i> Suku Bunga</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Suku Bunga:</strong><br>{{ $konfigurasi->sukubunga_minimum }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-info mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0 fw-bold text-white"><i class="fa fa-credit-card"></i> Biaya-Biaya</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Provisi:</strong><br>{{ $konfigurasi->persentase_provisi }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Administrasi:</strong><br>{{ $konfigurasi->persentase_administrasi }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Asuransi:</strong><br>{{ $konfigurasi->persentase_asuransi }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Biaya Meterai:</strong><br>Rp {{ number_format($konfigurasi->biaya_meterai, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-warning mb-3">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0 fw-bold text-white"><i class="fa fa-exclamation-triangle"></i> Denda</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Denda Harian:</strong><br>{{ $konfigurasi->persentase_denda_harian }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Denda Bulanan:</strong><br>{{ $konfigurasi->persentase_denda_bulanan }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Denda Maksimal:</strong><br>Rp {{ number_format($konfigurasi->denda_maksimal, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Toleransi Periode Denda:</strong><br>{{ $konfigurasi->toleransi_periode_denda }} hari</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-secondary mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0 fw-bold text-white"><i class="fa fa-check-circle"></i> Pelunasan & Pengaturan Lainnya</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pelunasan Dipercepat:</strong><br>
                                            <span class="badge badge-{{ $konfigurasi->pelunasandipercepat ? 'success' : 'danger' }}">
                                                {{ $konfigurasi->pelunasandipercepat ? 'Diperbolehkan' : 'Tidak Diperbolehkan' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Pinalti Pelunasan:</strong><br>{{ $konfigurasi->persentase_pinalti_pelunasan }}%</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Wajib Agunan:</strong><br>
                                            <span class="badge badge-{{ $konfigurasi->wajib_agunan ? 'success' : 'secondary' }}">
                                                {{ $konfigurasi->wajib_agunan ? 'Wajib' : 'Tidak Wajib' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-cog fa-5x text-muted mb-3"></i>
                        <h5>Belum Ada Konfigurasi</h5>
                        <p class="text-muted">Silakan buat konfigurasi untuk produk pinjaman ini</p>
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalForm">
                            <i class="fa fa-plus"></i> Buat Konfigurasi
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Form (Create/Edit) -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ $konfigurasi ? route('manajer.konfigurasi-pinjaman.update', $konfigurasi->id) : route('manajer.konfigurasi-pinjaman.store') }}" id="formKonfigurasi">
                @csrf
                @if($konfigurasi)
                    @method('PUT')
                @endif
                <input type="hidden" name="pinjaman_id" value="{{ $pinjaman->id }}">
                
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white fw-bold">{{ $konfigurasi ? 'Edit' : 'Buat' }} Konfigurasi Pinjaman</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-primary"><i class="fa fa-money"></i> Plafon & Tenor</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Plafon Minimum (Rp) <span class="text-danger">*</span></label>
                                <input type="text" name="plafon_minimum" class="form-control rupiah-format" value="{{ $konfigurasi ? number_format($konfigurasi->plafon_minimum, 0, ',', '.') : '0' }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Plafon Maksimum (Rp) <span class="text-danger">*</span></label>
                                <input type="text" name="plafon_maksimum" class="form-control rupiah-format" value="{{ $konfigurasi ? number_format($konfigurasi->plafon_maksimum, 0, ',', '.') : '0' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tenor Minimum (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="tenor_minimum" class="form-control" value="{{ $konfigurasi->tenor_minimum ?? 1 }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tenor Maksimum (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="tenor_maksimum" class="form-control" value="{{ $konfigurasi->tenor_maksimum ?? 12 }}" required>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary"><i class="fa fa-percent"></i> Suku Bunga</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Suku Bunga (%) <span class="text-danger">*</span></label>
                                <input type="number" name="sukubunga_minimum" class="form-control" value="{{ $konfigurasi->sukubunga_minimum ?? 0 }}" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary"><i class="fa fa-credit-card"></i> Biaya-Biaya</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provisi (%)</label>
                                <input type="number" name="persentase_provisi" class="form-control" value="{{ $konfigurasi->persentase_provisi ?? 0 }}" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Administrasi (%)</label>
                                <input type="number" name="persentase_administrasi" class="form-control" value="{{ $konfigurasi->persentase_administrasi ?? 0 }}" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Asuransi (%)</label>
                                <input type="number" name="persentase_asuransi" class="form-control" value="{{ $konfigurasi->persentase_asuransi ?? 0 }}" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Biaya Meterai (Rp) <span class="text-danger">*</span></label>
                        <input type="text" name="biaya_meterai" class="form-control rupiah-format" value="{{ $konfigurasi ? number_format($konfigurasi->biaya_meterai, 0, ',', '.') : '10.000' }}" required>
                    </div>

                    <hr>
                    <h6 class="text-primary"><i class="fa fa-exclamation-triangle"></i> Denda</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Denda Harian (%)</label>
                                <input type="number" name="persentase_denda_harian" class="form-control" value="{{ $konfigurasi->persentase_denda_harian ?? 0 }}" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Denda Bulanan (%)</label>
                                <input type="number" name="persentase_denda_bulanan" class="form-control" value="{{ $konfigurasi->persentase_denda_bulanan ?? 0 }}" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Denda Maksimal (Rp)</label>
                                <input type="text" name="denda_maksimal" class="form-control rupiah-format" value="{{ $konfigurasi ? number_format($konfigurasi->denda_maksimal, 0, ',', '.') : '0' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Toleransi Periode Denda (Hari)</label>
                                <input type="number" name="toleransi_periode_denda" class="form-control" value="{{ $konfigurasi->toleransi_periode_denda ?? 0 }}">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary"><i class="fa fa-check-circle"></i> Pelunasan Dipercepat</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pelunasan Dipercepat <span class="text-danger">*</span></label>
                                <select name="pelunasandipercepat" id="pelunasandipercepat" class="form-control" required>
                                    <option value="1" {{ ($konfigurasi->pelunasandipercepat ?? 1) == 1 ? 'selected' : '' }}>Diperbolehkan</option>
                                    <option value="0" {{ ($konfigurasi->pelunasandipercepat ?? 1) == 0 ? 'selected' : '' }}>Tidak Diperbolehkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="pinalti_pelunasan_group">
                                <label>Pinalti Pelunasan (%)</label>
                                <input type="number" name="persentase_pinalti_pelunasan" class="form-control" value="{{ $konfigurasi->persentase_pinalti_pelunasan ?? 0 }}" step="0.01">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary"><i class="fa fa-cog"></i> Pengaturan Lainnya</h6>
                    <div class="form-group">
                        <label>Wajib Agunan <span class="text-danger">*</span></label>
                        <select name="wajib_agunan" class="form-control" required>
                            <option value="0" {{ ($konfigurasi->wajib_agunan ?? 0) == 0 ? 'selected' : '' }}>Tidak Wajib</option>
                            <option value="1" {{ ($konfigurasi->wajib_agunan ?? 0) == 1 ? 'selected' : '' }}>Wajib</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">{{ $konfigurasi ? 'Update' : 'Simpan' }} Konfigurasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('.rupiah-format').on('keyup', function() {
        formatRupiah(this);
    });

    togglePelunasan();
    $('#pelunasandipercepat').on('change', function() {
        togglePelunasan();
    });

    @if(!$konfigurasi && request('action') == 'create')
        $('#modalForm').modal('show');
    @endif
});

function formatRupiah(input) {
    let value = input.value.replace(/[^,\d]/g, '');
    let split = value.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    input.value = rupiah;
}

function togglePelunasan() {
    const isRequired = $('#pelunasandipercepat').val() == '1';
    const $group = $('#pinalti_pelunasan_group');
    const $input = $('#persentase_pinalti_pelunasan');
    
    if(isRequired) {
        $group.show();
        $input.prop('disabled', false);
    } else {
        $group.hide();
        $input.prop('disabled', true);
        $input.val('0');
    }
}

function editKonfigurasi() {
    $('#modalForm').modal('show');
}

// Before form submit, convert rupiah format to number
$('#formKonfigurasi').on('submit', function(e) {
    $('.rupiah-format').each(function() {
        let value = $(this).val().replace(/\./g, '').replace(/,/g, '.');
        $(this).val(value);
    });
});
</script>
@endsection