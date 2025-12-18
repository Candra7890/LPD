@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Provinsi
@endsection
@section('page-name')
    Data Provinsi
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Provinsi</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('insert'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses</h3>
            {{ session()->get('insert') }}
        </div>
    @elseif(session()->has('edit'))
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <h3 class="text-success"><i class="fa fa-check-circle"></i> Sukses</h3>
            {{ session()->get('edit') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h5 class="m-b-0 text-white">Filter</h5>
                </div>
                <div class="card-body">
                    <form class="" action="{{ route('provinsi.index') }}" method="get" id="form-filter">
                        <form class="" id="form-filter">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <label>Nama Provinsi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nama_prov" value="{{ request()->nama_prov }}">

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="form-actions mt-3">
                                <button class="btn btn-sm btn-info waves-effect waves-light" type="submit" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>
                                <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
                            </div>
                        </form>
                </div>
            </div>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Daftar Provinsi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="30px">#</th>
                                    <th>Nama Provinsi</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($provinsis as $key => $provinsi)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $provinsi->nama_provinsi }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_prov(this, {{ $provinsi->provinsi_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_prov(this, {{ $provinsi->provinsi_id }})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right mt-2">
                        {{ $provinsis->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-provinsi" action="{{ route('provinsi.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group m-t-20">
                            <label for="provinsi" class="control-label">Nama Provinsi</label>

                            <input type="text" class="form-control" id="provinsi" name="provinsi" required="" placeholder="Contoh: Bali">
                            <span class="bar"></span>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal insert --}}

    {{-- modal edit --}}
    <div id="modal-edit" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-edit-provinsi" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="provinsi_id_edit" name="provinsi_id" required="" readonly="" hidden="">

                        <div class="form-group m-t-20">
                            <label for="provinsi_edit" class="control-label">Nama Provinsi</label>

                            <input type="text" class="form-control" id="provinsi_edit" name="provinsi" required="">
                            <span class="bar"></span>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal edit --}}

@endsection

@section('js')
    <script src="{{ asset('/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        // $('#table').DataTable();

        function edit_prov(e, prov_id) {
            var id_prov = prov_id;
            var row = $(e).closest('tr').find('td');
            var nama_prov = row[1].innerHTML;


            $('#form-edit-provinsi').attr('action', '{{ route('provinsi.index') }}' + '/' + id_prov);
            $('#provinsi_id_edit').val(id_prov);
            $('#provinsi_edit').val(nama_prov);
            $('#modal-edit').modal('show');

        }

        function delete_prov(e, prov_id) {
            var id_prov = prov_id;
            var row = $(e).closest('tr').find('td');
            var nama_prov = row[1].innerHTML;

            swal({
                title: "Hapus " + nama_prov + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/provinsi/' + id_prov;
                var token = $('input[name=_token]').val();

                $.post({
                    url: url,
                    data: {
                        _token: token,
                        _method: 'DELETE'
                    },
                    success: function(data) {
                        if (data == 'sukses') {
                            swal("Sukses!",
                                "Sukses menghapus " + nama_prov,
                                "success")
                            location.reload();
                        }
                    },
                    error: function() {
                        swal("Error", "Terjadi kesalahan sistem. Silakan hubungi pihak terkait", "error");
                    }
                })
            });
        }

    </script>
@endsection
