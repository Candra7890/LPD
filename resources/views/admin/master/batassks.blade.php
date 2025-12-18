@extends('layouts.app_admin2')
@section('title')
    SIMAK - Batas Pengambilan SKS
@endsection

@section('page-name')
    Data Master Batas Pengambilan SKS
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Batas Pengambilan SKS</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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

    <div class="card card-outline-danger">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Maksimal Pengambilan SKS</h4>
        </div>
        <div class="card-body">

            <div class="table-responsive">

                <table id="table" class="table table-bordered table-hover table-sm mt-4">
                    <thead>
                        <tr align="center">
                            <th width="30px">#</th>
                            <th>Batas Atas IP</th>
                            <th>Batas Bawah IP</th>
                            <th>SKS Dapat Diambil</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maks_sks as $key => $max_sks)
                            <tr align="center">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $max_sks->batasatas_ip }}</td>
                                <td>{{ $max_sks->batasbawah_ip }}</td>
                                <td>{{ $max_sks->maksimalsks }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_batassks(this, {{ $max_sks->maksimalsks_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_batassks(this, {{ $max_sks->maksimalsks_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-right mt-2">
                <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
                {{-- {{ $masternilais->links() }} --}}
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-masternilai" action="{{ route('batas-sks.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <label for="batas_atas" class="control-label">Batas Atas IP</label>
                            <input type="number" min="0" max="4" class="form-control" name="batas_atas" step="0.01" required="" placeholder="Contoh: 3">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="batas_bawah" class="control-label">Batas Bawah IP</label>
                            <input type="number" min="0" max="4" class="form-control" name="batas_bawah" step="0.01" required="" placeholder="Contoh: 2">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="sks" class="control-label">SKS Dapat Diambil</label>
                            <input type="number" min="0" max="100" step="1" class="form-control" name="sks" required="" placeholder="Contoh: 20">
                            <span class="bar"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><span class="btn-label"><i class="fa fa-close"></i></span>Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>
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
                <form class="" id="form-edit-maksimalsks" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="maksimalsks_id_edit" name="maksimalsks_id" required="" hidden="" readonly="">
                        <div class="form-group">
                            <label for="batas_atas_edit" class="control-label">Batas Atas IP</label>

                            <input type="number" min="0" max="4" class="form-control" id="batas_atas_edit" step="0.01" name="batas_atas" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="batas_bawah_edit" class="control-label">Batas Bawah IP</label>

                            <input type="number" min="0" max="4" class="form-control" id="batas_bawah_edit" step="0.01" name="batas_bawah" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="sks_edit" class="control-label">SKS Dapat Diambil</label>
                            <input type="number" min="0" max="24" step="1" class="form-control" id="sks_edit" name="sks" required="">
                            <span class="bar"></span>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><span class="btn-label"><i class="fa fa-close"></i></span>Tutup</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>
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
    <script src="{{ asset('/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        // $('#table').DataTable();
        $('.select2').select2();

        function edit_batassks(e, m_id) {
            var id_mn = m_id;
            var row = $(e).closest('tr').find('td');
            var batasatas = row[1].innerHTML;
            var batasbawah = row[2].innerHTML;
            var sks = row[3].innerHTML;

            $('#form-edit-maksimalsks').attr('action', '{{ route('batas-sks.index') }}' + '/' + id_mn);
            $('#maksimalsks_id_edit').val(id_mn);
            $('#batas_atas_edit').val(batasatas);
            $('#batas_bawah_edit').val(batasbawah);
            $('#sks_edit').val(sks);
            $('.focus').attr('class', 'form-group m-t-20 focused');
            $('#modal-edit').modal('show');

        }

        function delete_batassks(e, m_id) {
            var id_mn = m_id;
            var row = $(e).closest('tr').find('td');
            var sks = row[3].innerHTML;

            swal({
                title: "Hapus Batas untuk Jumlah SKS "+ sks + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/batas-sks/' + id_mn;
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
                                "Sukses menghapus Batas SKS" + sks,
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
