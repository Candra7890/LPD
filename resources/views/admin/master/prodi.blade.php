@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Prodi
@endsection

@section('page-name')
    Data Program Studi
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Prodi</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">

    <style>
        .modal {
            overflow-y: auto;
        }
    </style>
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
                    <form class="" action="{{ route('prodi.index') }}" method="get" id="form-filter">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Fakultas</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="fakultas_id_filter" id="fakultas_id_filter" required="">
                                            @if (session()->get('currentRole')->brokerrole_id == 1)
                                                <option value="-">Semua</option>
                                            @endif
                                            @foreach ($fakx as $fak)
                                                <option {{ $fak->fakultas_id == $request->fakultas_id_filter ? 'selected' : '' }} value="{{ $fak->fakultas_id }} ">{{ $fak->nama_fakultas }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Jenjang</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="jenjang_id_filter" id="jenjang_id_filter" required="">
                                            @if (session()->get('currentRole')->brokerrole_id == 1)
                                                <option value="-">Semua</option>
                                            @endif
                                            @foreach ($jenjangprodi as $jenjang)
                                                <option {{ $jenjang->jenjangprodi_id == $request->jenjang_id_filter ? 'selected' : '' }} value="{{ $jenjang->jenjangprodi_id }}">{{ $jenjang->jenjang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="row mt-1">
                                    <div class="col-md-4">
                                        <label>Akreditasi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="select2 form-control custom-select" name="akreditasi_filter" id="akreditasi_filter" required="">
                                            <option value="-">Semua</option>
                                            <option {{ 'A' == $request->akreditasi_filter ? 'selected' : '' }} value="A">A</option>
                                            <option {{ 'B' == $request->akreditasi_filter ? 'selected' : '' }} value="B">B</option>
                                            <option {{ 'C' == $request->akreditasi_filter ? 'selected' : '' }} value="C">C</option>

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
                                    <a class="dropdown-item" href="print-prodi{{ $parameter }}">Cetak PDF</a>
                                </div>
                            </div>

                            @if ($tipe == 'admin')
                                <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i
                                            class="fa fa-plus"></i></span>Tambah Data</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline-danger">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Daftar Program Studi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="30px">#</th>
                            <th>Nama Prodi</th>
                            <th>Jenjang</th>
                            <th>Fakultas</th>
                            <th>Kode Prodi</th>
                            <th>Kode Dikti</th>
                            <th>Akreditasi</th>
                            <th>Kelas Default</th>
                            <th>Mode Nilai</th>
                            <th>Koprodi</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prodis as $key => $prodi)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td>{{ $prodi->jenjangprodi->jenjang }}</td>
                                <td>{{ $prodi->fakultas->nama_fakultas }}</td>
                                <td>{{ $prodi->kode_prodi }}</td>
                                <td>{{ $prodi->kode_prodi_dikti }}</td>
                                <td>{{ $prodi->akreditasi }}</td>
                                <td>{{ $prodi->kelas_default }}</td>
                                <td>{{ $prodi->mode_nilai }}</td>
                                <td>{{ $prodi->koprodi->nama_tercetak ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm waves-effect waves-light" type="button"
                                        onclick="edit_prodi(this, {{ $prodi->fakultas_id . ',' . $prodi->jenjangprodi_id . ',' . $prodi->prodi_id }})" data-toggle="tooltip" title="Sunting"><i
                                            class="fa fa-pencil"></i></button>
                                    @if ($tipe == 'admin')
                                        <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_prodi(this, {{ $prodi->prodi_id }})" data-toggle="tooltip"
                                            title="Hapus"><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-right mt-2">
                {{ $prodis->links() }}
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <form class="" id="form-add-prodi" action="{{ route('prodi.store') }}" method="post">
                    @csrf



                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="fak">Fakultas</label>
                                    <select class="form-control p-0" name="fakultas_id" required="">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach ($fakx as $fak)
                                            <option value={{ $fak->fakultas_id }}>{{ $fak->nama_fakultas }}</option>
                                        @endforeach
                                    </select><span class="bar"></span>
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="jenjang">Jenjang Prodi</label>
                                    <select class="form-control p-0" name="jenjang_id" required="">
                                        <option value="">Pilih Jenjang</option>
                                        @foreach ($jenjangprodi as $jenjang)
                                            <option value={{ $jenjang->jenjangprodi_id }}>{{ $jenjang->jenjang }}</option>
                                        @endforeach
                                    </select><span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="prodi" class="control-label">Nama Prodi</label>

                                    <input type="text" class="form-control" name="nama_prodi" required="" placeholder="Contoh: Teknologi Informasi">
                                    <span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kode" class="control-label">Kode Prodi</label>

                                    <input type="text" class="form-control" name="kode_prodi" required="" placeholder="Contoh: 01">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="akreditasi" class="control-label">Akreditasi</label>

                                    <input type="text" class="form-control" name="akreditasi" required="" placeholder="Contoh: A">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="penerbit" class="control-label">Penerbit Akreditasi</label>

                                    <input type="text" class="form-control" name="penerbit" required="" placeholder="Contoh: BAN-PT">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="akreditasi" class="control-label">Kelas Default</label>

                                    <input type="text" class="form-control" name="kelas_default" required="" value="ada" placeholder="Contoh: ada">
                                    <span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kode" class="control-label">Kode Prodi Dikti</label>

                                    <input type="text" class="form-control" name="kode_prodi_dikti" required="" placeholder="Contoh: 59201">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="kode" class="control-label">No SK Akreditasi</label>

                                    <input type="text" class="form-control" name="no_surat_akreditasi" required="" placeholder="Contoh: 2022/ISI/VI/...">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_akreditasi" class="control-label">Tanggal Akreditasi</label>

                                    <input type="date" class="form-control" name="tanggal_akreditasi" placeholder="Contoh: 2022-12-31">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_akhir_akreditasi" class="control-label">Tanggal Akhir Berlaku Akreditasi</label>

                                    <input type="date" class="form-control" name="tanggal_akhir_akreditasi" placeholder="Contoh: 2022-12-31">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="mode_nilai">Mode Nilai</label>
                                    <select class="form-control p-0" name="mode_nilai" required="">
                                        <option value="terbaik">Terbaik</option>
                                        <option value="terakhir">Terakhir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mode_nilai">Ketua Program Studi</label>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input type="text" disabled class="form-control" name="ketua_prodi">
                                            <input type="hidden" class="form-control" name="ketua_prodi_id">
                                        </div>
                                        <div class="col-sm-2 my-auto" style="margin-left: -0.7em !important;">
                                            <a href="#" class="search-ketua-prodi"><i class="fa fa-search"></i> Cari</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" id="cek_plt_insert" name="cek_plt_insert" class="filled-in chk-col-teal"> <label for="cek_plt_insert">Pelaksana Tugas Ketua Program
                                    Studi</label>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><span class="btn-label"><i class="fa fa-close"></i></span>Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal insert --}}


    {{-- modal edit --}}
    <div id="modal-edit" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="" id="form-edit-prodi" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="prodi_id_edit" name="prodi_id" required="" readonly="" hidden="">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="fakultas">Fakultas</label>
                                    <select class="form-control" name="fakultas_id" required="" id="fakultas_id_edit">

                                    </select><span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="jenjang">Jenjang Prodi</label>
                                    <select class="form-control p-0" name="jenjang_id" required="" id="jenjang_id_edit">

                                    </select><span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="prodi" class="control-label">Nama Prodi</label>

                                    <input type="text" class="form-control" id="prodi_edit" name="nama_prodi" required="">
                                    <span class="bar"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kode" class="control-label">Kode Prodi</label>

                                    <input type="text" class="form-control" id="kode_edit" name="kode_prodi" required="">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group ">
                                    <label for="prodi" class="control-label">Akreditasi</label>

                                    <input type="text" class="form-control" id="akreditasi_edit" name="akreditasi">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="penerbit" class="control-label">Penerbit Akreditasi</label>

                                    <input type="text" class="form-control" name="penerbit" id="penerbit_edit" required="" placeholder="Contoh: BAN-PT">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="akreditasi" class="control-label">Kelas Default</label>

                                    <input type="text" class="form-control" id="kelas_default_edit" name="kelas_default" required="">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group ">
                                    <label for="mode_nilai">Mode Nilai</label>
                                    <select class="form-control p-0" name="mode_nilai" required="" id="mode_nilai_edit">
                                        <option value="terbaik">Terbaik</option>
                                        <option value="terakhir">Terakhir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="prodi" class="control-label">Kode Prodi Dikti</label>

                                    <input type="text" class="form-control" id="kode_prodi_edit" name="kode_prodi_dikti" required="">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="kode" class="control-label">No SK Akreditasi</label>

                                    <input type="text" class="form-control" name="no_surat_akreditasi" id="no_surat_akreditasi" required="" placeholder="Contoh: 2019/UNHI/VI/...">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_akreditasi" class="control-label">Tanggal Akreditasi</label>

                                    <input type="date" class="form-control" name="tanggal_akreditasi" id="tanggal_akreditasi" placeholder="Contoh: 2022-12-31">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_akhir_akreditasi" class="control-label">Tanggal Akhir Berlaku Akreditasi</label>

                                    <input type="date" class="form-control" name="tanggal_akhir_akreditasi" id="tanggal_akhir_akreditasi" placeholder="Contoh: 2022-12-31">
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group">
                                    <label for="akreditasi" class="control-label">Gunakan Sistem Paket Selama (dalam semester)</label>

                                    <input type="number" class="form-control" id="sistem_paket_edit" name="sistem_paket" required="">
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mode_nilai">Ketua Program Studi</label>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input type="text" disabled class="form-control" name="ketua_prodi">
                                            <input type="hidden" class="form-control" name="ketua_prodi_id">
                                        </div>
                                        <div class="col-sm-2 my-auto" style="margin-left: -0.7em !important;">
                                            <a href="#" class="search-ketua-prodi"><i class="fa fa-search"></i> Cari</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" id="cek_plt_edit" name="cek_plt_edit" class="filled-in chk-col-teal"> <label for="cek_plt_edit">Pelaksana Tugas Ketua Program Studi</label>
                            </div>
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

    <div id="modal-find" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel">Cari Ketua Program Studi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="" method="get" id="form-search-dosen">
                        <input type="hidden" name="service" value="search-dosen">
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="q" placeholder="NIP/Nama Dosen">
                            </div>
                            <div class="col-sm-3 my-auto">
                                <button type="button" id="btn-search-dosen" class="btn btn-info" style="font-size: 14.5px;"><span class="btn-label"><i class="ti-search"></i></span> Cari</button>
                            </div>
                        </div>
                    </form>

                    <table class="mt-3 table-bordered table-hover table" id="tb-search-dosen">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="160">NIP</th>
                                <th width="400">Nama</th>
                                <th width="200">Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('js')
    <script src="{{ asset('/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/master_prodi/main.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        // $('#table').DataTable();
        $('.select2').select2();

        function edit_prodi(e, fak_id, jenjang_id, prodi_id) {
            var id_prodi = prodi_id;
            var row = $(e).closest('tr').find('td');
            var nama_prodi = row[1].innerHTML;
            var jenjang = row[2].innerHTML;
            var nama_fak = row[3].innerHTML;
            var kode_prodi = row[4].innerHTML;
            var kode_prodi_dikti = row[5].innerHTML;
            var akreditasi = row[6].innerHTML;
            var kelas_default = row[7].innerHTML;
            var mode_nilai = row[8].innerHTML;

            var list_fak = '';
            var list_jenjang = '';
            var selected;

            $.get({
                url: '/master/prodi/' + prodi_id,
                success: function(data) {
                    if (data.status == true) {
                        $('input[name=ketua_prodi_id]').val(data.prodi.koprodi.dosen_id);
                        $('input[id=no_surat_akreditasi]').val(data.prodi.sk);
                        $('input[id=penerbit_edit]').val(data.prodi.penerbit);
                        $('input[id=tanggal_akreditasi]').val(data.prodi.tanggal_akreditasi);
                        $('input[id=tanggal_akhir_akreditasi]').val(data.prodi.tanggal_akhir_akreditasi);
                        $('input[name=ketua_prodi]').val(data.prodi.koprodi.nip + ' - ' + data.prodi.koprodi.nama);
                        $('#sistem_paket_edit').val(data.prodi.sistem_paket_selama)

                        if (data.prodi.is_koprodi_plt == 1) {
                            $("#cek_plt_edit").prop("checked", true)
                        } else {
                            $("#cek_plt_edit").prop("checked", false)
                        }
                    }
                },
                error: function(data) {

                }
            })

            $.get({
                url: '{{ route('fakultas.index') }}' + '/' + id_prodi,
                success: function(data) {
                    // console.log(data);
                    $.each(data['fak'], function(key, value) {
                        selected = (value['fakultas_id'] == fak_id) ? 'selected' : '';
                        list_fak += '<option value="' + value['fakultas_id'] + '"' + selected + '>' + value['nama_fakultas'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#fakultas_id_edit').html(list_fak);


                }
            })

            $.get({
                url: '{{ route('jenjang-prodi.index') }}' + '/' + id_prodi,
                success: function(data) {
                    // console.log(data);
                    $.each(data['jenjang'], function(key, value) {
                        selected = (value['jenjangprodi_id'] == jenjang_id) ? 'selected' : '';
                        list_jenjang += '<option value="' + value['jenjangprodi_id'] + '"' + selected + '>' + value['jenjang'] + '</option>';
                        // console.log(kab_sma);

                    })
                    $('#jenjang_id_edit').html(list_jenjang);


                }
            })


            $('#form-edit-prodi').attr('action', '{{ route('prodi.index') }}' + '/' + id_prodi);
            $('#prodi_id_edit').val(id_prodi);
            $('#prodi_edit').val(nama_prodi);
            $('#kode_edit').val(kode_prodi);
            $('#kode_prodi_edit').val(kode_prodi_dikti);
            $('#akreditasi_edit').val(akreditasi);
            $('#kelas_default_edit').val(kelas_default);
            $('#mode_nilai_edit').val(mode_nilai);
            $('#modal-edit').modal('show');

        }

        function delete_prodi(e, prodi_id) {
            var id_prodi = prodi_id;
            var row = $(e).closest('tr').find('td');
            var fakultas = row[3].innerHTML;
            var nama_prodi = row[1].innerHTML;

            swal({
                title: "Hapus " + fakultas + " - " + nama_prodi + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/prodi/' + id_prodi;
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
                                "Sukses menghapus " + fakultas + " - " + nama_prodi,
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
