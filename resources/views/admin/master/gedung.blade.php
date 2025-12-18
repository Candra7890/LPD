@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Gedung
@endsection

@section('page-name')
    Data Gedung
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Gedung</li>
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
    <div class="row">

        <div class="col-md-12">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h5 class="m-b-0 text-white">Filter</h5>
                </div>
                <div class="card-body">
                    <form class="" action="{{ route('gedung.index') }}" method="get" id="form-filter">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Fakultas</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="fakultas_id_filter" id="fakultas_id_filter">
                                            @if ($tipe == 'admin')
                                                <option value="">Semua</option>
                                            @endif
                                            @foreach ($faks as $fak)
                                                <option {{ $fak->fakultas_id == request()->fakultas_id_filter ? 'selected' : '' }} value="{{ $fak->fakultas_id }}">{{ $fak->nama_fakultas }}</option>

                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Program Studi</label>
                                        <span style="padding-right:3px; padding-top: 3px;">
                                            <img id="load-prodi_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="prodi_id_filter" id="prodi_id_filter">
                                            @if ($tipe == 'admin')
                                                <option value="">Semua</option>
                                            @elseif($tipe = 'operator')
                                                @foreach ($prodis as $prodi)
                                                    <option {{ $prodi->prodi_id == request()->prodi_id_filter ? 'selected' : '' }} value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>

                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="form-actions mt-3">
                            <button class="btn btn-sm btn-info waves-effect waves-light" type="submit" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>

                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="print-gedung{{ $parameter }} ">Cetak PDF</a>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Daftar Gedung</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        


                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="30px">#</th>
                                    <th>Nama Gedung</th>
                                    <th>Nama Prodi</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gedungs as $key => $gedung)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{$gedung->gedung_id}}</td> --}}
                                        <td>{{ $gedung->nama_gedung }}</td>
                                        <td>{{ $gedung->prodi->nama_prodi }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_gedung(this, {{ $gedung->gedung_id . ',' . $gedung->prodi_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_gedung(this, {{ $gedung->gedung_id }})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="ruangan?gedung_f={{ $gedung->gedung_id }} ">Cari Ruangan</a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            {{ $gedungs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-gedung" action="{{ route('gedung.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="gedung" class="control-label">Gedung Baru</label>

                            <input type="text" class="form-control" id="gedung" name="nama_gedung" required="" placeholder="Contoh: Gedung A">

                        </div>

                        <div class="form-group">
                            <label for="prodi">Nama Prodi</label>
                            <select class="form-control p-0" name="prodi_id" id="prodi_id" required>
                                <option value="">Pilih Prodi</option>
                                @foreach ($prodis as $prodi)
                                    <option value={{ $prodi->prodi_id }}>{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>

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
                <form class="" id="form-edit-gedung" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="gedung_id_edit" name="gedung_id" required="" hidden="" readonly="">

                        <div class="form-group">
                            <label for="gedung_edit" class="control-label">Gedung</label>
                            <input type="text" class="form-control" id="gedung_edit" name="nama_gedung" required="">
                        </div>

                        <div class="form-group">
                            <label for="prodi">Nama Prodi</label>
                            <select class="form-control p-0" name="prodi_id" id="prodi_id_edit" required>

                            </select>

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

        function edit_gedung(e, gedung_id, prodi_id) {
            var id_gedung = gedung_id;
            var row = $(e).closest('tr').find('td');
            var gedung = row[1].innerHTML;

            var prodilist = '';
            var selected;
            $.get({
                url: '{{ route('get_allprodi') }}',
                success: function(data) {
                    console.log(data);
                    $.each(data, function(key, value) {
                        selected = (value['prodi_id'] == prodi_id) ? 'selected' : '';
                        prodilist += '<option value="' + value['prodi_id'] + '"' + selected + '>' +
                            value['nama_prodi'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#prodi_id_edit').html(prodilist);


                }
            })

            $('#form-edit-gedung').attr('action', '{{ route('gedung.index') }}' + '/' + id_gedung);
            $('#gedung_id_edit').val(id_gedung);
            $('#gedung_edit').val(gedung);
            $('.focus').attr('class', 'form-group m-t-20 focused');
            $('#modal-edit').modal('show');

        }

        function delete_gedung(e, gedung_id) {
            var id_gedung = gedung_id;
            var row = $(e).closest('tr').find('td');
            var gedung = row[1].innerHTML;

            swal({
                title: "Hapus Gedung " + gedung + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/gedung/' + id_gedung;
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
                                "Sukses menghapus Gedung " + gedung,
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

        $(document).ready(function() {
            var f_id = $('#fakultas_id_filter').val();
            var tipe = {!! json_encode($tipe) !!};
            if (f_id && tipe == 'admin') {
                $('#load-prodi_filter').show();
                get_prodi_by_fak_id(f_id, '#prodi_id_filter', '#load-prodi_filter');

            }

        });

        function get_prodi_by_fak_id(id, tag_prodi_id, tag_loading) {
            var url = '{{ route('prodi.index') }}' + '/fakultas/' + id;
            var prodi_list = '<option value="">Pilih Prodi</option>';

            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        prodi_list += '<option value="' + value['prodi_id'] + '" >' + value[
                            'nama_prodi'] + '</option>'
                    })

                    $(tag_prodi_id).html(prodi_list);
                    $(tag_prodi_id).removeAttr('disabled');
                    $(tag_loading).hide();

                    var p_id = {!! json_encode(request()->prodi_id_filter) !!};
                    if (p_id) {
                        $('#prodi_id_filter').val(p_id).trigger('change');

                    }
                }
            })
        }

        $('#fakultas_id_filter').change(function() {
            $('#load-prodi_filter').show();
            var id = $('#fakultas_id_filter').val();
            $('#prodi_id_filter').empty();
            get_prodi_by_fak_id(id, '#prodi_id_filter', '#load-prodi_filter');
        })

    </script>
@endsection
