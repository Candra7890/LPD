@extends('layouts.app')

@section('page-name', 'Pembayaran Angsuran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.pinjaman-aktif.index') }}">Pinjaman Aktif</a></li>
    <li class="breadcrumb-item active">Pembayaran Angsuran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 fw-bold text-white">Form Pembayaran Angsuran</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                <form action="{{ route('teller.pembayaran-angsuran.store', $pinjamanAktif->id) }}" method="POST" id="formPembayaran">
                    @csrf
                    
                    <div class="form-group">
                        <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_pembayaran" class="form-control @error('jumlah_pembayaran') is-invalid @enderror" 
                               placeholder="Masukkan jumlah pembayaran" required min="0" step="1000" id="jumlahPembayaran">
                        @error('jumlah_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Minimal: Rp {{ number_format($jadwalAngsuranBelumLunas->first()->sisa_belum_terbayar ?? 0, 0, ',', '.') }}
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pembayaran <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pembayaran" class="form-control" 
                            value="{{ date('Y-m-d') }}" readonly required>
                    </div>

                    <div class="form-group">
                        <label>Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" required>
                            <option value="">Pilih Metode</option>
                            <option value="1">Tunai</option>
                            <option value="2">Transfer Bank</option>
                            <option value="3">Virtual Account</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="groupReferensi" style="display: none;">
                        <label>Nomor Referensi <span class="text-danger" id="reqBintang">*</span></label>
                        <input type="text" name="referensi_pembayaran" id="inputReferensi" 
                            class="form-control" placeholder="Nomor referensi bank">
                        <small class="form-text text-muted">
                            Masukkan nomor referensi transaksi dari bank/VA.
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" 
                                  placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Informasi:</strong> Jika jumlah pembayaran melebihi angsuran yang harus dibayar, 
                        kelebihan akan otomatis dialokasikan ke angsuran bulan berikutnya.
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i> Proses Pembayaran
                        </button>
                        <a href="{{ route('teller.pinjaman-aktif.show', $pinjamanAktif->id) }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Info Pinjaman -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pinjaman</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>No. Pinjaman:</th>
                        <td>{{ $pinjamanAktif->nomor_pinjaman }}</td>
                    </tr>
                    <tr>
                        <th>Nasabah:</th>
                        <td>{{ $pinjamanAktif->pengguna->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Produk:</th>
                        <td>{{ $pinjamanAktif->pinjaman->nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Summary Tunggakan -->
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0 text-white">Total Yang Harus Dibayar</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th>Total Angsuran:</th>
                        <td class="text-right">
                            <strong>Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                    @if($totalDenda > 0)
                    <tr>
                        <th>Total Denda:</th>
                        <td class="text-right text-danger">
                            <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                    <tr class="border-top">
                        <th>TOTAL:</th>
                        <td class="text-right">
                            <h5 class="mb-0 text-danger">Rp {{ number_format($totalTunggakan + $totalDenda, 0, ',', '.') }}</h5>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Daftar Angsuran Belum Lunas -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Angsuran Belum Lunas</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @foreach($jadwalAngsuranBelumLunas as $jadwal)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>Angsuran ke-{{ $jadwal->angsuran_ke }}</strong>
                        <span class="badge {{ $jadwal->status == 3 ? 'badge-danger' : 'badge-warning' }}">
                            {{ $jadwal->status == 3 ? 'Menunggak' : 'Belum Bayar' }}
                        </span>
                    </div>
                    <small class="text-muted">Jatuh Tempo: {{ $jadwal->tanggal_jatuh_tempo->format('d/m/Y') }}</small>
                    <div class="mt-1">
                        <small>Sisa: <strong>Rp {{ number_format($jadwal->sisa_belum_terbayar, 0, ',', '.') }}</strong></small>
                        @if($jadwal->denda > 0)
                            <br><small class="text-danger">Denda: Rp {{ number_format($jadwal->denda - $jadwal->denda_terbayar, 0, ',', '.') }}</small>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
$(document).ready(function() {
    const totalTunggakan = {{ $totalTunggakan + $totalDenda }};
    const angsuranPertama = {{ $jadwalAngsuranBelumLunas->first()->sisa_belum_terbayar ?? 0 }};

    function toggleReferensi() {
        const metode = $('select[name="metode_pembayaran"]').val();
        const groupReferensi = $('#groupReferensi');
        const inputReferensi = $('#inputReferensi');

        if (metode === "2" || metode === "3") { // 2: Transfer, 3: VA
            groupReferensi.slideDown();
            inputReferensi.attr('required', true);
        } else {
            groupReferensi.slideUp();
            inputReferensi.attr('required', false);
            inputReferensi.val(''); // Kosongkan input jika pindah ke Tunai
        }
    }

    // Jalankan saat metode pembayaran berubah
    $('select[name="metode_pembayaran"]').on('change', function() {
        toggleReferensi();
    });

    // Jalankan saat halaman pertama kali dimuat (antisipasi jika ada error validation)
    toggleReferensi();
});
</script>
@endsection
@endsection