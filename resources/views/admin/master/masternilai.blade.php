@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Nilai
@endsection

@section('page-name')
    Data Master Nilai
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Nilai</li>
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
                    <form class="" action="{{ route('masternilai.index') }}" method="get" id="form-filter">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Fakultas</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="fak_f" id="fak_f" required="">
                                            @if ($tipe == 'admin')
                                                <option value="-">Semua</option>
                                            @endif
                                            @foreach ($faks as $fak)
                                                <option {{ $fak->fakultas_id == $request->fak_f ? 'selected' : '' }} value="{{ $fak->fakultas_id }}">{{ $fak->nama_fakultas }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Jenjang</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="jen_f" id="jen_f" required="">
                                            <option value="-">Semua</option>
                                            @foreach ($jenjangprodis as $jenjang)
                                                <option {{ $jenjang->jenjangprodi_id == $request->jen_f ? 'selected' : '' }} value="{{ $jenjang->jenjangprodi_id }}">{{ $jenjang->jenjang }}</option>

                                            @endforeach
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
                                    <a class="dropdown-item" href="print-masternilai{{ $parameter }}">Cetak PDF</a>
                                </div>
                            </div>
                            
                            <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <div class="card card-outline-danger">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Master Nilai</h4>
        </div>
        <div class="card-body">

            <div class="table-responsive">

                <table id="table" class="table table-bordered table-hover table-sm mt-4">
                    <thead>
                        <tr align="center">
                            <th width="30px">#</th>
                            <th>Nama Fakultas</th>
                            <th>Jenjang Prodi</th>
                            <th>Nilai Huruf</th>
                            <th>Batas Atas</th>
                            <th>Batas Bawah</th>
                            <th>Bobot</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masternilais as $key => $masternilai)
                            <tr align="center">
                                <td>{{ $key + 1 }}</td>
                                {{-- <td>{{$masternilai->masternilai_id}}</td> --}}
                                <td>{{ $masternilai->fakultas->nama_fakultas }}</td>
                                <td>{{ $masternilai->jenjangprodi->jenjang }}</td>
                                <td>{{ $masternilai->nilai_huruf }}</td>
                                <td>{{ $masternilai->nilai_atas }}</td>
                                <td>{{ $masternilai->nilai_bawah }}</td>
                                <td>{{ $masternilai->nilai_angka }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_masternilai(this, {{ $masternilai->masternilai_id . ',' . $masternilai->jenjangprodi_id . ',' . $masternilai->fakultas_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_masternilai(this, {{ $masternilai->masternilai_id }})" data-toggle="tooltip" title="Sunting"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-right mt-2">
                {{ $masternilais->links() }}
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-add-masternilai" action="{{ route('masternilai.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenjangprodi">Jenjang Prodi</label>
                            <select class="form-control p-0" name="jenjangprodi_id" required="">
                                @if ($tipe == 'admin')
                                    <option value="">Pilih Jenjang Prodi</option>
                                @endif
                                @foreach ($jenjangprodis as $jenjang)
                                    <option value={{ $jenjang->jenjangprodi_id }}>{{ $jenjang->jenjang }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="fak">Fakultas</label>
                            <select class="form-control p-0" name="fakultas_id" required="">
                                @if ($tipe == 'admin')
                                    <option value="">Pilih Fakultas</option>
                                @endif
                                @foreach ($faks as $fak)
                                    <option value={{ $fak->fakultas_id }}>{{ $fak->nama_fakultas }}</option>
                                @endforeach
                            </select><span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="masternilai" class="control-label">Nilai Huruf</label>

                            <input type="text" class="form-control" id="nilai_huruf" name="nilai_huruf" required="" placeholder="Contoh: A">
                            <span class="bar"></span>

                        </div>
                        <div class="form-group">

                            <label for="nilai_atas" class="control-label">Batas Atas</label>
                            <input type="number" min="0" max="100" class="form-control" name="nilai_atas" step="0.01" required="" placeholder="Contoh: 100">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="nilai_bawah" class="control-label">Batas Bawah</label>
                            <input type="number" min="0" max="100" class="form-control" name="nilai_bawah" step="0.01" required="" placeholder="Contoh: 81">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="nilai_angka" class="control-label">Bobot</label>
                            <input type="number" min="0" max="4" step="0.01" class="form-control" name="nilai_angka" required="" placeholder="Contoh: 4">
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
                <form class="" id="form-edit-masternilai" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="masternilai_id_edit" name="masternilai_id" required="" hidden="" readonly="">

                        <div class="form-group">
                            <label for="jenjangprodi">Jenjang Prodi</label>
                            <select class="form-control p-0" name="jenjangprodi_id" required="" id="jenjangprodi_edit">

                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="fak">Fakultas</label>
                            <select class="form-control p-0" name="fakultas_id" required="" id="fakultas_edit">

                            </select><span class="bar"></span>
                        </div>

                        <div class="form-group">
                            <label for="nilaihuruf_edit" class="control-label">Nilai Huruf</label>

                            <input type="text" class="form-control" id="nilaihuruf_edit" name="nilai_huruf" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="nilaiatas_edit" class="control-label">Batas Atas</label>

                            <input type="number" min="0" max="100" class="form-control" id="nilaiatas_edit" step="0.01" name="nilai_atas" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">
                            <label for="nilaibawah_edit" class="control-label">Batas Bawah</label>

                            <input type="number" min="0" max="100" class="form-control" id="nilaibawah_edit" step="0.01" name="nilai_bawah" required="">
                            <span class="bar"></span>
                        </div>
                        <div class="form-group">

                            <label for="nilaiangka_edit" class="control-label">Bobot</label>
                            <input type="number" min="0" max="4" step="0.01" class="form-control" id="nilaiangka_edit" name="nilai_angka" required="" placeholder="Contoh: 4">
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

        function edit_masternilai(e, m_id, jenjang_id, fakultas_id) {
            var id_mn = m_id;
            var row = $(e).closest('tr').find('td');
            var nama_jenjang = row[2].innerHTML;
            var nama_fakultas = row[1].innerHTML;
            var nilaihuruf = row[3].innerHTML;
            var nilaiatas = row[4].innerHTML;
            var nilaibawah = row[5].innerHTML;
            var nilaiangka = row[6].innerHTML;

            var list_jenjang = '';
            var list_fak = '';
            var selected;

            $.get({
                url: '{{ route('masternilai.index') }}' + '/' + id_mn,
                success: function(data) {
                    // console.log(data);
                    $.each(data['jenjang'], function(key, value) {
                        selected = (value['jenjangprodi_id'] == jenjang_id) ? 'selected' : '';
                        list_jenjang += '<option value="' + value['jenjangprodi_id'] + '"' + selected + '>' + value['jenjang'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#jenjangprodi_edit').html(list_jenjang);

                    $.each(data['fakultas'], function(key, value) {
                        selected = (value['fakultas_id'] == fakultas_id) ? 'selected' : '';
                        list_fak += '<option value="' + value['fakultas_id'] + '"' + selected + '>' + value['nama_fakultas'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#fakultas_edit').html(list_fak);

                }
            })


            $('#form-edit-masternilai').attr('action', '{{ route('masternilai.index') }}' + '/' + id_mn);
            $('#masternilai_id_edit').val(id_mn);
            $('#nilaihuruf_edit').val(nilaihuruf);
            $('#nilaiatas_edit').val(nilaiatas);
            $('#nilaibawah_edit').val(nilaibawah);
            $('#nilaiangka_edit').val(nilaiangka);
            $('.focus').attr('class', 'form-group m-t-20 focused');
            $('#modal-edit').modal('show');

        }

        function delete_masternilai(e, m_id) {
            var id_mn = m_id;
            var row = $(e).closest('tr').find('td');
            var jenjangprodi = row[2].innerHTML;
            var nama_fakultas = row[1].innerHTML;
            var nilai = row[3].innerHTML;

            swal({
                title: "Hapus " + jenjangprodi + " - " + nama_fakultas + " - " + nilai + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/masternilai/' + id_mn;
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
                                "Sukses menghapus " + jenjangprodi + " - " + nama_fakultas + " - " + nilai,
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
