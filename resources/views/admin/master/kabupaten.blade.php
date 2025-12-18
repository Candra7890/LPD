@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Kabupaten
@endsection
@section('page-name')
    Data Kabupaten
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Kabupaten</li>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h5 class="m-b-0 text-white">Filter</h5>
                </div>
                <div class="card-body">
                    <form class="" action="{{ route('kabupaten.index') }}" method="get" id="form-filter">
                        {{-- <form class="" id="form-filter"> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Provinsi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" style="width: 100%" name="prov_f">
                                            <option value="">Semua</option>
                                            @foreach ($provinsis as $prov)
                                                <option {{ $prov->provinsi_id == request()->prov_f ? 'selected' : '' }} value="{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Cari Kabupaten</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="nama_kab" value="{{ request()->nama_kab }}">

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
    <div class="card">
        <div class="card card-outline-danger">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Daftar Kabupaten</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="30px">#</th>
                                <th>Nama Kabupaten</th>
                                <th>Provinsi</th>
                                <th widht="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kabupatens as $key => $kabupaten)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    {{-- <td>{{$kabupaten->kabupaten_id}}</td> --}}
                                    <td>{{ $kabupaten->nama_kabupaten }}</td>
                                    <td>{{ $kabupaten->provinsi->nama_provinsi }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_kabupaten(this, {{ $kabupaten->kabupaten_id . ',' . $kabupaten->provinsi_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_kabupaten(this, {{ $kabupaten->kabupaten_id }})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pull-right mt-2">
                    {{ $kabupatens->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-kabupaten" action="{{ route('kabupaten.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group m-t-20">
                            <label for="provinsi">Provinsi</label>
                            <select class="form-control p-0" name="provinsi_id" required="">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsis as $provinsi)
                                    <option value={{ $provinsi->provinsi_id }}>{{ $provinsi->nama_provinsi }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>
                        <div class="form-group m-t-20 ">
                            <label for="kabupaten" class="control-label">Kabupaten Baru</label>

                            <input type="text" class="form-control" id="kabupaten" name="kabupaten" required="" placeholder="-- Masukkan Nama Kabupaten --">
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
                <form class="" id="form-edit-kabupaten" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="kabupaten_id_edit" name="kabupaten_id" required="" readonly="" hidden="">

                        <div class="form-group m-t-20">
                            <label for="provinsi">Provinsi</label>
                            <select class="form-control p-0" name="provinsi_id" required="" id="provinsi_id_edit">
                                <option value=""></option>
                                @foreach ($provinsis as $prov)
                                    <option value={{ $prov->provinsi_id }} id="prov{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group m-t-20 ">
                            <label for="kabupaten_edit" class="control-label">Kabupaten</label>

                            <input type="text" class="form-control" id="kabupaten_edit" name="kabupaten" required="">
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

        function edit_kabupaten(e, kab_id, prov_id) {
            var id_kab = kab_id;
            var row = $(e).closest('tr').find('td');
            var nama_kab = row[1].innerHTML;
            var nama_prov = row[2].innerHTML;

            var selected;
            $('#prov' + prov_id).attr('selected', '');


            $('#form-edit-kabupaten').attr('action', '{{ route('kabupaten.index') }}' + '/' + id_kab);
            $('#kabupaten_id_edit').val(id_kab);
            $('#kabupaten_edit').val(nama_kab);
            $('#modal-edit').modal('show');

        }

        function delete_kabupaten(e, kab_id) {
            var id_kab = kab_id;
            var row = $(e).closest('tr').find('td');
            var nama_kab = row[1].innerHTML;
            var nama_prov = row[2].innerHTML;

            swal({
                title: "Hapus " + nama_kab + " - " + nama_prov + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/kabupaten/' + id_kab;
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
                                "Sukses menghapus " + nama_kab + " - " + nama_prov,
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
