@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Ruangan
@endsection

@section('page-name')
    Data Ruangan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Ruangan</li>
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
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline-danger">
                <div class="card-header">
                    <h5 class="m-b-0 text-white">Filter</h5>
                </div>
                <div class="card-body">
                    <form class="" action="{{ route('ruangan.index') }}" method="get" id="form-filter">
                        <div class="row">
                            <div class="col-md-12">
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
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Gedung</label>
                                        <span style="padding-right:3px; padding-top: 3px;">
                                            <img id="load-gedung_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="gedung_f" id="gedung_f">
                                            @if ($tipe == 'admin')
                                                <option value="">Semua</option>
                                            @elseif($tipe = 'operator')
                                                @foreach ($gedungs as $gedung)
                                                    <option {{ $gedung->gedung_id == $request->gedung_f ? 'selected' : '' }} value="{{ $gedung->gedung_id }}">{{ $gedung->nama_gedung }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="row mt-1">
                          <div class="col-md-4">
                            <label>Range Kapasitas</label>
                          </div>
                          
                          <div class="col-md-2">
                            <input type="number" class="form-control" id="range_start" name="range_start" required="" {{(0 == $request->range_start ? 'value=0':'value='.$request->range_start)}} >  
                          </div>
                          <div class="col-md-1">
                            <label>s/d</label>
                          </div>
                          <div class="col-md-3">
                            <input type="number" class="form-control" id="range_end" name="range_end" required="" {{(0 == $request->range_end ? 'value=10000':'value='.$request->range_end)}} > 
                          </div>
                            
                          
                        </div> --}}
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
                                    <a class="dropdown-item" href="print-ruangan{{ $parameter }}">Cetak PDF</a>
                                </div>
                            </div>
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
                    <h4 class="m-b-0 text-white">Daftar Ruangan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="30px">#</th>
                                    <th>Nama Ruangan</th>
                                    <th>Gedung</th>
                                    <th>Kapasitas</th>
                                    <th width="15%"  class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruangans as $key => $ruangan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{$ruangan->ruangan_id}}</td> --}}
                                        <td>{{ $ruangan->nama_ruangan }}</td>
                                        <td>{{ $ruangan->gedung->nama_gedung ?? '' }}</td>
                                        <td>{{ $ruangan->kapasitas }}</td>
                                        <td  class="text-center">
                                            <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_ruangan(this, {{ $ruangan->ruangan_id . ',' . $ruangan->gedung_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_ruangan(this, {{ $ruangan->ruangan_id }})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pull-right mt-2">
                        {{ $ruangans->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-ruangan" action="{{ route('ruangan.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="gedung">Gedung</label>
                            <select class="select2 form-control custom-select" name="gedung_id" required="" style="width: 100%">
                                <option value="">Pilih Gedung</option>
                                @foreach ($gedungs as $gedung)
                                    <option value={{ $gedung->gedung_id }}>{{ $gedung->nama_gedung }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="ruangan" class="control-label">Ruangan Baru</label>

                            <input type="text" class="form-control" id="ruangan" name="nama_ruangan" required="" placeholder="Contoh: Ruangan 1">
                            <span class="bar"></span>

                        </div>
                        <div class="form-group">
                            <label for="kapasitas" class="control-label">Kapasitas</label>

                            <input type="number" class="form-control" name="kapasitas" required="" placeholder="Contoh: 30">
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
    <div id="modal-edit" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-edit-ruangan" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="ruangan_id_edit" name="ruangan_id" required="" hidden="" readonly="">

                        <div class="form-group">
                            <label for="gedung">Gedung</label>
                            <select class="select2 form-control custom-select p-0" name="gedung_id" required="" id="gedung_id_edit" style="width: 100%">
                                {{-- <option value=""></option> --}}
                                {{-- @foreach ($gedungs as $gedung)
                    <option value={{$gedung->gedung_id}} id="gedung{{$gedung->gedung_id}}">{{$gedung->nama_gedung}}</option>
                  @endforeach --}}
                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="ruangan_edit" class="control-label">Ruangan</label>

                            <input type="text" class="form-control" id="ruangan_edit" name="nama_ruangan" required="" autofocus">
                            <span class="bar"></span>

                        </div>
                        <div class="form-group">
                            <label for="kapasitas" class="control-label">Kapasitas</label>

                            <input type="number" class="form-control" id="kapasitas_edit" name="kapasitas" required="">
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

        function edit_ruangan(e, ruangan_id, gedung_id) {
            var id_ruangan = ruangan_id;
            var row = $(e).closest('tr').find('td');
            var nama_gedung = row[2].innerHTML;
            var nama_ruangan = row[1].innerHTML;
            var kapasitas = row[3].innerHTML;

            var gedunglist = '';
            var selected;
            $('#gedung' + gedung_id).attr('selected', '');
            $.get({
                url: '{{ route('gedung.index') }}' + '/' + id_ruangan,
                success: function(data) {
                    // console.log(data);
                    $.each(data['gedung'], function(key, value) {
                        selected = (value['gedung_id'] == gedung_id) ? 'selected' : '';
                        gedunglist += '<option value="' + value['gedung_id'] + '"' + selected + '>' + value['nama_gedung'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#gedung_id_edit').html(gedunglist);


                }
            })


            $('#form-edit-ruangan').attr('action', '{{ route('ruangan.index') }}' + '/' + id_ruangan);
            $('#ruangan_id_edit').val(id_ruangan);
            $('#ruangan_edit').val(nama_ruangan);
            $('#kapasitas_edit').val(kapasitas);
            $('#modal-edit').modal('show');

        }

        function delete_ruangan(e, ruangan_id) {
            var id_ruangan = ruangan_id;
            var row = $(e).closest('tr').find('td');
            var nama_gedung = row[2].innerHTML;
            var nama_ruangan = row[1].innerHTML;

            swal({
                title: "Hapus Ruangan " + nama_ruangan + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/ruangan/' + id_ruangan;
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
                                "Sukses menghapus ruangan " + nama_ruangan,
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

        $(document).ready(function() {
            var f_id = $('#fakultas_id_filter').val();
            var tipe = {!! json_encode($tipe) !!};
            if (f_id && tipe == 'admin') {
                $('#load-prodi_filter').show();
                get_prodi_by_fak_id(f_id, '#prodi_id_filter', '#load-prodi_filter');

                var g_id = $('#gedung_f').val();
                get_gedung_by_prodi_id(g_id, '#gedung_f', '#load-gedung_filter');

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
                        prodi_list += '<option value="' + value['prodi_id'] + '" >' + value['nama_prodi'] + '</option>'
                    })

                    $(tag_prodi_id).html(prodi_list);
                    $(tag_prodi_id).removeAttr('disabled');
                    $(tag_loading).hide();

                    var p_id = {!!json_encode(request()->prodi_id_filter) !!};
                    if (p_id) {
                        $('#prodi_id_filter').val(p_id).trigger('change');

                    }
                }
            })
        }

        function get_gedung_by_prodi_id(id, tag_target_id, tag_loading) {
            var url = '{{ route('gedung.index') }}' + '/prodi/' + id;
            var gedung_list = '<option value="">Pilih Gedung</option>';

            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        gedung_list += '<option value="' + value['gedung_id'] + '" >' + value['nama_gedung'] + '</option>'
                    })

                    $(tag_target_id).html(gedung_list);
                    $(tag_loading).hide();

                    var g_id = {!!json_encode(request()->gedung_f)!!};
                    if (g_id) {
                        $(tag_target_id).val(g_id).trigger('change');

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

        $('#prodi_id_filter').change(function() {
            $('#load-gedung_filter').show();
            var id = $('#prodi_id_filter').val();
            $('#gedung_f').empty();
            get_gedung_by_prodi_id(id, '#gedung_f', '#load-gedung_filter');
        })

    </script>
@endsection
