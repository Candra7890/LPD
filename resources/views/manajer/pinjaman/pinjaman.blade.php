@extends('layouts.app')

@section('page-name', 'Produk Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Produk Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Data Produk Pinjaman</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Produk Pinjaman
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Jenis Pinjaman</th>
                                <th>Nama Produk</th>
                                <th>Keterangan</th>
                                <th width="10%">Status Konfigurasi</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjaman as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->jenisPinjaman->nama }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->hasKonfigurasi)
                                        <span class="badge badge-success">
                                            <i class="fa fa-check"></i> Sudah Dikonfigurasi
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Belum Dikonfigurasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="editData({{ $item->id }}, {{ $item->jenis_pinjaman_id }}, '{{ $item->nama }}', '{{ addslashes($item->keterangan) }}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        @if($item->hasKonfigurasi)
                                            <a href="{{ route('manajer.konfigurasi-pinjaman.index', ['pinjaman_id' => $item->id]) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Edit Konfigurasi">
                                                <i class="fa fa-cog"></i> Edit
                                            </a>
                                        @else
                                            <a href="{{ route('manajer.konfigurasi-pinjaman.index', ['pinjaman_id' => $item->id, 'action' => 'create']) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Set Konfigurasi">
                                                <i class="fa fa-cog"></i> Set
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteData({{ $item->id }}, '{{ $item->nama }}', {{ $item->hasKonfigurasi ? '1' : '0' }})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('manajer.pinjaman.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Pinjaman <span class="text-danger">*</span></label>
                        <select name="jenis_pinjaman_id" class="form-control" required>
                            <option value="">-- Pilih Jenis Pinjaman --</option>
                            @foreach($jenisPinjaman as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_pinjaman_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_pinjaman_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Nama Produk Pinjaman <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="formEdit">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Pinjaman <span class="text-danger">*</span></label>
                        <select name="jenis_pinjaman_id" id="edit_jenis_pinjaman_id" class="form-control" required>
                            <option value="">-- Pilih Jenis Pinjaman --</option>
                            @foreach($jenisPinjaman as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Produk Pinjaman <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form Delete (Hidden) -->
<form method="POST" id="formDelete" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        }
    });

    // Re-open modal if there are validation errors
    @if($errors->any() && old('_method') != 'PUT')
        $('#modalTambah').modal('show');
    @endif
});

function editData(id, jenisPinjamanId, nama, keterangan) {
    $('#edit_jenis_pinjaman_id').val(jenisPinjamanId);
    $('#edit_nama').val(nama);
    $('#edit_keterangan').val(keterangan);
    $('#formEdit').attr('action', '{{ url("manajer/pinjaman/produk") }}/' + id);
    $('#modalEdit').modal('show');
}

function deleteData(id, nama, hasKonfigurasi) {
    if (hasKonfigurasi == 1) {
        alert('Produk ini sudah memiliki konfigurasi, tidak dapat dihapus.');
        return;
    }

    if (confirm('Yakin ingin menghapus produk "' + nama + '"?')) {
        $('#formDelete').attr('action', '{{ url("manajer/pinjaman/produk") }}/' + id);
        $('#formDelete').submit();
    }
}
</script>
@endsection