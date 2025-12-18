@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Honor
@endsection
@section('page-name')
    Data Honor
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Honor</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Data Honor</h4> --}}
                    <div class="table-responsive">
                        {{-- <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal"
                            data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                            Data</button> --}}

                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="30px">#</th>
                                    <th>Nama Tarif</th>
                                    <th>Besaran</th>
                                    <th width="20%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($honors as $key => $honor)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$honor->nama_kegiatan}}</td>
                                        <td>{{ number_format($honor->besaran, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm waves-effect waves-light" type="button"
                                                onclick="edit_honor(this, {{ $honor->id_honor }})" data-toggle="tooltip"
                                                title="Sunting"><i class="fa fa-pencil"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div id="modal-edit" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-edit-honor" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" class="form-control" id="id_honor_edit" name="id_honor" required=""
                                readonly="" value="{{ old('id_honor') }}">
                            <span class="bar"></span>


                        <div
                            class="form-group m-t-20 focus {{ $errors->has('nama_kegiatan_edit') ? 'has-danger has-error has-feedback' : '' }}">
                            <label for="nama_kegiatan_edit" class="control-label">Nama Kegiatan:</label>

                            <input type="text" class="form-control" disabled id="nama_kegiatan_edit" name="nama_kegiatan_edit" required=""
                                value="{{ old('nama_kegiatan_edit') }}">
                            <span class="bar"></span>
                            @if ($errors->has('nama_kegiatan_edit'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('nama_kegiatan_edit') }}</strong>
                                </span>
                            @endif

                        </div>

                        <div
                            class="form-group m-t-20 focus {{ $errors->has('besaran_edit') ? 'has-danger has-error has-feedback' : '' }}">
                            <label for="besaran_edit" class="control-label">Besaran:</label>

                            <input type="number" class="form-control" id="besaran_edit" name="besaran_edit" required=""
                                value="{{ old('besaran_edit') }}">
                            <span class="bar"></span>
                            @if ($errors->has('besaran_edit'))
                                <span class="input-error">
                                    <strong>{{ $errors->first('besaran_edit') }}</strong>
                                </span>
                            @endif

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
        $('#table').DataTable();

        function edit_honor(e, honor_id) {
            var honor_id = honor_id;
            var row = $(e).closest('tr').find('td');
            var honor = row[1].innerHTML;
            var besaran = row[2].innerHTML;
            // 2.000.001 to 2000001
            // remove . and ,
            besaran = besaran.replace(/\./g, "");
            besaran = besaran.replace(/,/g, ".");

            $('#form-edit-honor').attr('action', '{{ route('honor.index') }}' + '/' + honor_id);
            $('#id_honor_edit').val(honor_id);
            $('#nama_kegiatan_edit').val(honor);
            $('#besaran_edit').val(parseInt(besaran));
            $('.focus').attr('class', 'form-group m-t-20 focused');
            $('#modal-edit').modal('show');

        }

        function delete_honor(e, honor_id) {
            var honor_id = honor_id;
            var row = $(e).closest('tr').find('td');
            var honor = row[1].innerHTML;
            var besaran = row[2].innerHTML;

            swal({
                title: "Hapus " + honor + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/honor/' + honor_id;
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
                                "Sukses menghapus " + agama,
                                "success")
                            location.reload();
                        }
                    },
                    error: function() {
                        swal("Error", "Terjadi kesalahan sistem. Silakan hubungi pihak terkait",
                            "error");
                    }
                })
            });
        }

        @if ($errors->has('honor'))
            insert_error();
        @endif

        @if ($errors->has('honor_edit'))
            edit_error();
        @endif

        @if (Session::has('insert'))
            success('Berhasil menyimpan data baru');
        @endif

        @if (Session::has('edit'))
            success('Berhasil menyunting data');
        @endif

        @if (Session::has('delete'))
            success('Berhasil menghapus data');
        @endif
    </script>
@endsection
