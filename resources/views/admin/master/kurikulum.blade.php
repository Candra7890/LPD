@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Kurikulum
@endsection

@section('page-name')
    Data Kurikulum
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Kurikulum</li>
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
                    <form class="" action="{{ route('kurikulum.index') }}" method="get" id="form-filter">
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Fakultas</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="fakultas_id_filter" id="fakultas_id_filter" style="width: 100%">
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
                                        <select class="select2 form-control custom-select" name="prodi_id_filter" id="prodi_id_filter" style="width: 100%">
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
                                        <select class="form-control custom-select" name="cari_f">
                                            <option value="">Cari</option>
                                            <option {{ request()->cari_f == 'nama_kurikulum' ? 'selected' : '' }} value="nama_kurikulum">Nama Kurikulum</option>
                                            <option {{ request()->cari_f == 'tahun' ? 'selected' : '' }} value="tahun">Tahun</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="keterangan_f" value="{{ request()->keterangan_f }}">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="form-actions mt-3">
                            <button class="btn btn-sm btn-info waves-effect waves-light" type="submit" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>
                            <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i
                                        class="fa fa-plus"></i></span>Tambah Data</button>

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
                    <h4 class="m-b-0 text-white">Daftar Kurikulum</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                        <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Bantuan</h3> Klik nama kurikulum untuk melihat daftar matakuliah yang ada pada kurikulum tersebut.
                    </div>
                    <div class="">

                        <div class="table-responsive">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="30px">#</th>
                                        <th>Nama Kurikulum</th>
                                        <th>Tahun</th>
                                        <th>Nama Fakultas</th>
                                        <th>Nama Prodi</th>
                                        <th align="center">Status Aktif</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kurikulums as $key => $kurikulum)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('matakuliah.index') . '?kur_f=' . $kurikulum->kurikulum_id . '&fak_f=-&prodi_f=-&cari_f=-&keterangan_f=&klp_f=-&smt_f=-&jns_f=-' }}">{{ $kurikulum->nama_kurikulum }}</a>
                                            </td>
                                            <td>{{ $kurikulum->tahun }}</td>
                                            <td>{{ $kurikulum->fakultas->nama_fakultas }}</td>
                                            <td>{{ $kurikulum->prodi->nama_prodi }}</td>
                                            <td align="center">
                                                <input type="checkbox" id="md_checkbox_{{ $kurikulum->kurikulum_id }}" data-id='{{ $kurikulum->kurikulum_id }}'
                                                    class="filled-in chk-col-light-blue cb-isaktif" {{ $kurikulum->status_aktif == 1 ? 'checked=""' : '' }}>
                                                <label for="md_checkbox_{{ $kurikulum->kurikulum_id }}"></label>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm waves-effect waves-light" type="button"
                                                    onclick="edit_kurikulum(this, {{ $kurikulum->fakultas_id . ',' . $kurikulum->prodi_id . ',' . $kurikulum->kurikulum_id }})" data-toggle="tooltip"
                                                    title="Sunting"><i class="fa fa-pencil"></i></button>
                                                <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_kurikulum(this, {{ $kurikulum->kurikulum_id }})"
                                                    data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="pull-right mt-2">
                            {{ $kurikulums->appends(request()->query())->links() }}
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
                <form class="" id="form-add-kurikulum" action="{{ route('kurikulum.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fak">Fakultas</label>
                            <select class="form-control" name="fakultas_id" required="" id="fakultas_id_ins">
                                <option value="">Pilih Fakultas</option>
                                @foreach ($faks as $fak)
                                    <option value={{ $fak->fakultas_id }}>{{ $fak->nama_fakultas }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi</label>
                            <div id="load-prodi_ins"
                                style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif') }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;">
                            </div>
                            <select class="form-control" id="prodi_id_ins" disabled="" name="prodi_id" required="">

                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="kurikulum" class="control-label">Nama Kurikulum</label>

                            <input type="text" class="form-control" id="kurikulum" name="kurikulum" required="" placeholder="Contoh: Kurikulum 2018">
                            <span class="bar"></span>

                        </div>
                        <div class="form-group">

                            <label for="tahun" class="control-label">Tahun</label>
                            <input type="number" min="1900" max="2199" class="form-control" name="tahun" required="" placeholder="Contoh: 2018">
                            <span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="gedung">Status Aktif</label>
                            <select class="form-control" name="status_aktif" required="">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select><span class="bar"></span>
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
                <form class="" id="form-edit-kurikulum" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="kurikulum_id_edit" name="kurikulum_id" required="" readonly="" hidden="">

                        <div class="form-group">
                            <label for="fak">Fakultas</label>
                            <select class="form-control p-0" name="fakultas_id" required="" id="fakultas_edit">
                                <option value=""></option>
                                @foreach ($faks as $fak)
                                    <option value={{ $fak->fakultas_id }} id="fak{{ $fak->fakultas_id }}">{{ $fak->nama_fakultas }}</option>
                                @endforeach

                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="prodi">Prodi</label>
                            <div id="load-prodi_edit"
                                style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif') }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;">
                            </div>
                            <select class="form-control p-0" name="prodi_id" required="" id="prodi_edit">

                            </select><span class="bar"></span>
                        </div>



                        <div class="form-group">
                            <label for="kurikulum_edit" class="control-label">Kurikulum</label>

                            <input type="text" class="form-control" id="kurikulum_edit" name="kurikulum" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="tahun_edit" class="control-label">Tahun</label>

                            <input type="number" class="form-control" id="tahun_edit" name="tahun" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="gedung">Status Aktif</label>
                            <select class="form-control" id="status_edit" name="status_aktif" required="">
                                <option value="">Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select><span class="bar"></span>
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
        $('#table').DataTable({
            paging: false,
            bInfo: false
        });
        $('.select2').select2();

        $(document).ready(function() {
            var f_id = $('#fakultas_id_filter').val();
            var tipe = {!! json_encode($tipe) !!};
            if (f_id && tipe == 'admin') {
                $('#load-prodi_filter').show();
                get_prodi_by_fak_id(f_id, '#prodi_id_filter', '#load-prodi_filter');

            }

        });

        function edit_kurikulum(e, fakultas_id, prodi_id, kurikulum_id) {
            var id_kurikulum = kurikulum_id;
            var row = $(e).closest('tr').find('td');
            var nama_kurikulum = row[1].innerText;
            var tahun = row[2].innerText;
            var nama_fakultas = row[3].innerText;
            var nama_prodi = row[4].innerText;
            var status_aktif = '';

            var list_prodi = '';
            console.log(nama_kurikulum)

            $('#fak' + fakultas_id).attr('selected', '');
            var selected;

            $.get({
                url: '{{ route('prodi.index') }}' + '/fakultas/' + fakultas_id,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        selected = (value['prodi_id'] == prodi_id) ? 'selected' : '';
                        list_prodi += '<option value="' + value['prodi_id'] + '"' + selected + '>' + value['nama_prodi'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#prodi_edit').html(list_prodi);

                }
            })

            $.get({
                url: '{{ route('kurikulum.index') }}' + '/idx/' + id_kurikulum,
                success: function(data) {
                    console.log(data);
                    status_aktif = data['status_aktif'];
                    $('#status_edit').val(status_aktif).trigger('change');

                }
            })


            $('#form-edit-kurikulum').attr('action', '{{ route('kurikulum.index') }}' + '/' + id_kurikulum);
            $('#kurikulum_id_edit').val(id_kurikulum);
            $('#kurikulum_edit').val(nama_kurikulum);
            $('#tahun_edit').val(tahun);
            $('#prodi_edit').val(nama_prodi).trigger('change');
            // $('#status_edit').val(status_aktif);
            $('#modal-edit').modal('show');

        }

        function delete_kurikulum(e, kurikulum_id) {
            var id_kur = kurikulum_id;
            var row = $(e).closest('tr').find('td');
            var nama_kur = row[1].innerText;
            var tahun = row[2].innerText;

            swal({
                title: "Hapus " + nama_kur + " - " + tahun + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/kurikulum/' + id_kur;
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
                                "Sukses menghapus " + nama_kur + " - " + tahun,
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

                    var p_id = {!! json_encode(request()->prodi_id_filter) !!};
                    if (p_id) {
                        $('#prodi_id_filter').val(p_id).trigger('change');

                    }
                }
            })
        }

        $('#fakultas_id_ins').change(function() {
            $('#load-prodi_ins').show();
            // id_provinsi
            var id = $('#fakultas_id_ins').val();
            // alert('iseng: ' + id);
            // console.log('iseng: ' + id);
            get_prodi_by_fak_id(id, '#prodi_id_ins', '#load-prodi_ins');

        })

        $('#fakultas_edit').change(function() {

            var id = $('#fakultas_edit').val();
            get_prodi_by_fak_id(id, '#prodi_edit', '#load-prodi_edit');
        })

        $('#fakultas_id_filter').change(function() {
            $('#load-prodi_filter').show();
            var id = $('#fakultas_id_filter').val();
            $('#prodi_id_filter').empty();
            get_prodi_by_fak_id(id, '#prodi_id_filter', '#load-prodi_filter');
        })


        $(document).on('change', '.cb-isaktif', function() {
            let id = $(this).data('id')
            let divId = $(this).attr('id');
            let checked = $(this).is(":checked");
            cb = $(this)
            $.post({
                url: '/master/kurikulum/' + id,
                data: {
                    _method: 'PUT',
                    _token: $('meta[name=csrf-token]').attr('content'),
                    service: "toggle_stat"
                },
                beforeSend: function() {
                    $('label[for=' + divId + ']').html('<span class="fa fa-spinner fa-spin"></span>');
                },
                success: function(data) {
                    alert(data.msg)
                    location.reload()
                },
                error: function(data) {
                    if (checked) {
                        cb.prop('checked', false);
                    } else {
                        cb.prop('checked', true);
                    }
                    alert("Gagal mengubah status aktif kurikulum");
                }
            }).always(function() {
                $('label[for=' + divId + ']').html('');
            })
        })
    </script>
@endsection
