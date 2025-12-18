@extends('layouts.app')

@section('page-name', 'Pengajuan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pengajuan-pinjaman.index') }}">Pengajuan Pinjaman</a></li>
    <li class="breadcrumb-item active">Buat Pengajuan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('teller.pengajuan-pinjaman.store') }}" id="formPengajuan">
            @csrf
            
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Form Pengajuan Pinjaman</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nasabah <span class="text-danger">*</span></label>
                                <select name="pengguna_id" id="pengguna_id" class="form-control select2" required>
                                    <option value="">-- Pilih Nasabah --</option>
                                    @foreach($nasabahList as $nasabah)
                                        <option value="{{ $nasabah->id }}" {{ old('pengguna_id') == $nasabah->id ? 'selected' : '' }}>
                                            {{ $nasabah->kode_nasabah }} - {{ $nasabah->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pengguna_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Produk Pinjaman <span class="text-danger">*</span></label>
                                <select name="pinjaman_id" id="pinjaman_id" class="form-control" required>
                                    <option value="">-- Pilih Produk Pinjaman --</option>
                                    @foreach($produkPinjaman as $produk)
                                        <option value="{{ $produk->id }}" {{ old('pinjaman_id') == $produk->id ? 'selected' : '' }}>
                                            {{ $produk->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pinjaman_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Plafon Pinjaman <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_pengajuan" id="jumlah_pengajuan" 
                                       class="form-control" placeholder="Masukkan jumlah plafon" 
                                       value="{{ old('jumlah_pengajuan') }}" min="0" step="0.01" required>
                                <small class="text-muted" id="plafonRange"></small>
                                @error('jumlah_pengajuan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tenor (Bulan) <span class="text-danger">*</span></label>
                                <input type="number" name="tenor" id="tenor" 
                                       class="form-control" placeholder="Masukkan tenor dalam bulan" 
                                       value="{{ old('tenor') }}" min="1" required>
                                <small class="text-muted" id="tenorRange"></small>
                                @error('tenor')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3" 
                                          placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-info btn-lg" id="btnKalkulator">
                                <i class="fa fa-calculator"></i> Hitung Simulasi Pinjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Hasil Kalkulasi -->
            <div class="card" id="cardHasil" style="display: none;">
                <div class="card-body">
                    <h4 class="card-title mb-4">Hasil Simulasi Pinjaman</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="50%"><strong>Plafon Pinjaman</strong></td>
                                    <td width="50%" class="text-right">Rp <span id="result_plafon">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tenor</strong></td>
                                    <td class="text-right"><span id="result_tenor">0</span> Bulan</td>
                                </tr>
                                <tr>
                                    <td><strong>Suku Bunga</strong></td>
                                    <td class="text-right"><span id="result_bunga">0</span>%</td>
                                </tr>
                                <tr class="bg-light">
                                    <td><strong>Angsuran Per Bulan</strong></td>
                                    <td class="text-right"><strong>Rp <span id="result_angsuran">0</span></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Bunga</strong></td>
                                    <td class="text-right">Rp <span id="result_total_bunga">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Kewajiban</strong></td>
                                    <td class="text-right">Rp <span id="result_total_kewajiban">0</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="50%"><strong>Biaya Provisi</strong></td>
                                    <td width="50%" class="text-right">Rp <span id="result_biaya_provisi">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Biaya Administrasi</strong></td>
                                    <td class="text-right">Rp <span id="result_biaya_admin">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Biaya Asuransi</strong></td>
                                    <td class="text-right">Rp <span id="result_biaya_asuransi">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Biaya Meterai</strong></td>
                                    <td class="text-right">Rp <span id="result_biaya_meterai">0</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Biaya</strong></td>
                                    <td class="text-right">Rp <span id="result_total_biaya">0</span></td>
                                </tr>
                                <tr class="bg-success text-white">
                                    <td><strong>Diterima Bersih</strong></td>
                                    <td class="text-right"><strong>Rp <span id="result_diterima_bersih">0</span></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Catatan:</strong> Perhitungan menggunakan metode bunga flat. 
                        Angsuran per bulan terdiri dari pokok dan bunga yang tetap setiap bulannya.
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teller.pengajuan-pinjaman.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: '-- Pilih Nasabah --'
    });

    let konfigurasi = null;

    // Load konfigurasi when produk pinjaman selected
    $('#pinjaman_id').on('change', function() {
        const pinjamanId = $(this).val();
        
        if (!pinjamanId) {
            $('#plafonRange').text('');
            $('#tenorRange').text('');
            konfigurasi = null;
            return;
        }

        $.ajax({
            url: '{{ url("teller/pengajuan-pinjaman/konfigurasi") }}/' + pinjamanId,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    konfigurasi = response.data;
                    
                    // Update range info
                    $('#plafonRange').text(
                        'Min: Rp ' + formatNumber(konfigurasi.plafon_minimum) + 
                        ' - Max: Rp ' + formatNumber(konfigurasi.plafon_maksimum)
                    );
                    $('#tenorRange').text(
                        'Min: ' + konfigurasi.tenor_minimum + 
                        ' bulan - Max: ' + konfigurasi.tenor_maksimum + ' bulan'
                    );

                    // Set min/max attributes
                    $('#jumlah_pengajuan').attr('min', konfigurasi.plafon_minimum);
                    $('#jumlah_pengajuan').attr('max', konfigurasi.plafon_maksimum);
                    $('#tenor').attr('min', konfigurasi.tenor_minimum);
                    $('#tenor').attr('max', konfigurasi.tenor_maksimum);
                }
            },
            error: function() {
                alert('Gagal mengambil konfigurasi pinjaman');
            }
        });
    });

    // Kalkulator
    $('#btnKalkulator').on('click', function() {
        const pinjamanId = $('#pinjaman_id').val();
        const plafon = $('#jumlah_pengajuan').val();
        const tenor = $('#tenor').val();

        if (!pinjamanId) {
            alert('Silakan pilih produk pinjaman terlebih dahulu');
            return;
        }

        if (!plafon || plafon <= 0) {
            alert('Silakan masukkan plafon yang valid');
            return;
        }

        if (!tenor || tenor <= 0) {
            alert('Silakan masukkan tenor yang valid');
            return;
        }

        // Validasi range
        if (konfigurasi) {
            if (parseFloat(plafon) < parseFloat(konfigurasi.plafon_minimum) || 
                parseFloat(plafon) > parseFloat(konfigurasi.plafon_maksimum)) {
                alert('Plafon harus antara Rp ' + formatNumber(konfigurasi.plafon_minimum) + 
                      ' - Rp ' + formatNumber(konfigurasi.plafon_maksimum));
                return;
            }

            if (parseInt(tenor) < parseInt(konfigurasi.tenor_minimum) || 
                parseInt(tenor) > parseInt(konfigurasi.tenor_maksimum)) {
                alert('Tenor harus antara ' + konfigurasi.tenor_minimum + 
                      ' - ' + konfigurasi.tenor_maksimum + ' bulan');
                return;
            }
        }

        // Call kalkulasi API
        $.ajax({
            url: '{{ route("teller.pengajuan-pinjaman.kalkulasi") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                pinjaman_id: pinjamanId,
                plafon: plafon,
                tenor: tenor
            },
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Update hasil kalkulasi
                    $('#result_plafon').text(formatNumber(data.plafon));
                    $('#result_tenor').text(data.tenor);
                    $('#result_bunga').text(data.suku_bunga);
                    $('#result_angsuran').text(formatNumber(data.angsuran_per_bulan));
                    $('#result_total_bunga').text(formatNumber(data.total_bunga));
                    $('#result_total_kewajiban').text(formatNumber(data.total_kewajiban));
                    $('#result_biaya_provisi').text(formatNumber(data.biaya_provisi));
                    $('#result_biaya_admin').text(formatNumber(data.biaya_administrasi));
                    $('#result_biaya_asuransi').text(formatNumber(data.biaya_asuransi));
                    $('#result_biaya_meterai').text(formatNumber(data.biaya_meterai));
                    $('#result_total_biaya').text(formatNumber(data.total_biaya));
                    $('#result_diterima_bersih').text(formatNumber(data.jumlah_diterima_bersih));

                    // Show card hasil
                    $('#cardHasil').slideDown();
                    
                    // Scroll to hasil
                    $('html, body').animate({
                        scrollTop: $('#cardHasil').offset().top - 100
                    }, 500);
                }
            },
            error: function(xhr) {
                alert('Gagal melakukan kalkulasi: ' + 
                      (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    });

    // Format number helper
    function formatNumber(num) {
        return parseFloat(num).toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }
});
</script>
@endsection