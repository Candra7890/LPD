@extends('layouts.app')

@section('page-name', 'Jenis Pinjaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Pinjaman</a></li>
    <li class="breadcrumb-item active">Jenis Pinjaman</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Data Jenis Pinjaman</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Jenis Pinjaman
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Jenis Pinjaman</th>
                                <th>Keterangan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jenisPinjaman as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="editData({{ $item->id }}, '{{ $item->nama }}', '{{ $item->keterangan }}')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteData({{ $item->id }}, '{{ $item->nama }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
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
            <form method="POST" action="{{ route('manajer.jenis-pinjaman.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis Pinjaman <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
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
                    <h5 class="modal-title">Edit Jenis Pinjaman</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jenis Pinjaman <span class="text-danger">*</span></label>
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
});

function editData(id, nama, keterangan) {
    $('#edit_nama').val(nama);
    $('#edit_keterangan').val(keterangan);
    $('#formEdit').attr('action', '{{ url("manajer/pinjaman/jenis-pinjaman") }}/' + id);
    $('#modalEdit').modal('show');
}

function deleteData(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus jenis pinjaman "' + nama + '"?')) {
        $('#formDelete').attr('action', '{{ url("manajer/pinjaman/jenis-pinjaman") }}/' + id);
        $('#formDelete').submit();
    }
}
</script>
@endsection