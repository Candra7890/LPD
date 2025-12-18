@extends('layouts.app')

@section('page-name', 'Detail Tunggakan Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('teller.tunggakan-pinjaman.index') }}">Tunggakan Pinjaman</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4 class="m-b-0 text-white">Info Peminjam</h4>
            </div>
            <div class="card-body">
                <center class="m-t-30"> 
                    <img src="{{ $pinjamanAktif->pengguna->foto_url ?? asset('assets/images/users/1.jpg') }}" class="img-circle" width="150" />
                    <h4 class="card-title m-t-10">{{ $pinjamanAktif->pengguna->name }}</h4>
                    <h6 class="card-subtitle">{{ $pinjamanAktif->pengguna->role_name }}</h6>
                </center>
            </div>
            <div>
                <hr> 
            </div>
            <div class="card-body"> 
                <small class="text-muted">Nomor Pinjaman</small>
                <h6>{{ $pinjamanAktif->nomor_pinjaman }}</h6> 
                
                <small class="text-muted p-t-30 db">Produk Pinjaman</small>
                <h6>{{ $pinjamanAktif->pinjaman->nama }}</h6> 
                
                <small class="text-muted p-t-30 db">Total Pinjaman</small>
                <h6>Rp {{ number_format($pinjamanAktif->pokok_pinjaman, 0, ',', '.') }}</h6>
                
                <small class="text-muted p-t-30 db">Tanggal Pencairan</small>
                <h6>{{ $pinjamanAktif->tanggal_pencairan->format('d F Y') }}</h6>
                
                <small class="text-muted p-t-30 db">Status</small>
                <h6><span class="badge {{ $pinjamanAktif->status_badge }}">{{ $pinjamanAktif->status_text }}</span></h6>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="m-b-0 text-white">Ringkasan Tunggakan</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Total Angsuran Tertunggak</span>
                    <span class="font-weight-bold text-danger">Rp {{ number_format($totalAngsuranTunggak, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>Total Denda</span>
                    <span class="font-weight-bold text-danger">Rp {{ number_format($totalDendaTunggak, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="h5">Total Harus Dibayar</span>
                    <span class="h5 font-weight-bold text-danger">Rp {{ number_format($totalAngsuranTunggak + $totalDendaTunggak, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Tabungan Jadwal -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="m-b-0 text-white">Jadwal Angsuran Tertunggak</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ke</th>
                                <th>Jatuh Tempo</th>
                                <th>Pokok</th>
                                <th>Bunga</th>
                                <th>Denda</th>
                                <th>Total Tagihan</th>
                                <th>Hari Terlambat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalTunggakan as $jadwal)
                            <tr>
                                <td>{{ $jadwal->angsuran_ke }}</td>
                                <td>{{ $jadwal->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($jadwal->angsuran_pokok - $jadwal->pokok_terbayar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($jadwal->angsuran_bunga - $jadwal->bunga_terbayar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($jadwal->denda - $jadwal->denda_terbayar, 0, ',', '.') }}</td>
                                <td>
                                    <strong>Rp {{ number_format($jadwal->sisa_belum_terbayar + ($jadwal->denda - $jadwal->denda_terbayar), 0, ',', '.') }}</strong>
                                </td>
                                <td><span class="badge badge-danger">{{ $jadwal->hari_keterlambatan }} Hari</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada jadwal tertunggak (Data mungkin tidak sinkron)</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Form Sita Agunan -->
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4 class="m-b-0 text-white">Tindakan Penyitaan jaminan</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="mdi mdi-alert-circle"></i> Perhatian! Tindakan ini akan mengubah status semua agunan aktif pada pinjaman ini menjadi <strong>Disita</strong>. Pastikan prosedur penyitaan telah dilakukan sesuai aturan.
                </div>
                
                <h5 class="card-title">Daftar Agunan:</h5>
                <ul>
                    @foreach($pinjamanAktif->agunan as $agunan)
                        <li>
                            <strong>{{ $agunan->nama_agunan }}</strong> 
                            - {{ $agunan->deskripsi }} 
                            (Nilai Taksiran: Rp {{ number_format($agunan->nilai_penjaminan, 0, ',', '.') }})
                            @if($agunan->status == 6)
                                <span class="badge badge-danger">Sudah Disita</span>
                            @elseif($agunan->status == 4)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">{{ $agunan->status }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if($pinjamanAktif->agunan->where('status', 4)->count() > 0)
                    <hr>
                    <form action="{{ route('teller.tunggakan-pinjaman.sita-agunan', $pinjamanAktif->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyita agunan ini? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        <div class="form-group">
                            <label>Tanggal Penyitaan</label>
                            <input type="date" name="tanggal_penyitaan" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Alasan Penyitaan</label>
                            <textarea name="alasan_penyitaan" class="form-control" rows="3" required placeholder="Contoh: Nasabah tidak dapat melunasi tunggakan setelah diberikan surat peringatan ke-3..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="mdi mdi-gavel"></i> Lakukan Penyitaan Agunan
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        Semua agunan sudah disita atau tidak ada agunan aktif.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
