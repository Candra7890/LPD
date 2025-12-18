@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Matakuliah
@endsection

@section('page-name')
    Data Matakuliah
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Matakuliah</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            /*width: 800px;*/
            margin: 0 auto;
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
    <div class="card card-outline-danger">
        <div class="card-header">
            <h5 class="m-b-0 text-white">Filter</h5>
        </div>
        <div class="card-body">
            {{-- <form class="" action="{{route('matakuliah.index')}}" method="get" id="form-filter"> --}}
            <form class="" id="form-filter">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Fakultas</label>
                            </div>
                            <div class="col-md-6">
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
                                <label>Program Studi</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-prodi_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="prodi_f" id="prodi_f" required="">
                                    @if ($tipe == 'admin')
                                        <option value="-">Semua</option>
                                    @elseif ($tipe == 'operator')
                                        @foreach ($prodis as $prodi)
                                            <option {{ $prodi->prodi_id == $request->prodi_f ? 'selected' : '' }} value="{{ $prodi->prodi_id }}">
                                                {{ $prodi->jenjangprodi->jenjang . ' ' . $prodi->nama_prodi }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Kurikulum</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-kurikulum_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="kur_f" id="kur_f" required="">
                                    <option value="-">Semua</option>
                                    @if ($tipe == 'operator')
                                        @foreach ($kurikulums as $kur)
                                            <option {{ $kur->kurikulum_id == $request->kur_f ? 'selected' : '' }} value="{{ $kur->kurikulum_id }} ">{{ $kur->nama_kurikulum }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Kelompok</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="klp_f" id="klp_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($kelompokmatkuls as $klp)
                                        <option {{ $klp->kelompokmatakuliah_id == $request->klp_f ? 'selected' : '' }} value="{{ $klp->kelompokmatakuliah_id }}">{{ $klp->nama_kelompok }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Semester</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="smt_f" id="smt_f" required="">
                                    <option value="-">Semua</option>
                                    <option {{ '1' == $request->smt_f ? 'selected' : '' }} value="1">1</option>
                                    <option {{ '2' == $request->smt_f ? 'selected' : '' }} value="2">2</option>
                                    <option {{ '3' == $request->smt_f ? 'selected' : '' }} value="3">3</option>
                                    <option {{ '4' == $request->smt_f ? 'selected' : '' }} value="4">4</option>
                                    <option {{ '5' == $request->smt_f ? 'selected' : '' }} value="5">5</option>
                                    <option {{ '6' == $request->smt_f ? 'selected' : '' }} value="6">6</option>
                                    <option {{ '7' == $request->smt_f ? 'selected' : '' }} value="7">7</option>
                                    <option {{ '8' == $request->smt_f ? 'selected' : '' }} value="8">8</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Jenis</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="jns_f" id="jns_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($jenismatkuls as $jns)
                                        <option {{ $jns->jenismatakuliah_id == $request->jns_f ? 'selected' : '' }} value="{{ $jns->jenismatakuliah_id }} ">{{ $jns->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <select class="form-control custom-select" name="cari_f" required="">
                                    <option value="-">Cari</option>
                                    <option {{ $request->cari_f == 'kode_matakuliah' ? 'selected' : '' }} value="kode_matakuliah">Kode Matakuliah</option>
                                    <option {{ $request->cari_f == 'nama_matakuliah' ? 'selected' : '' }} value="nama_matakuliah">Nama Matakuliah</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="keterangan_f" value="{{ $request->keterangan_f }}" required="">
                            </div>
                        </div>
                    </div>
                </div>


                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check1" class="filled-in chk-col-red" name="check[]" value="nama_matakuliah" checked />
                            <label for="check1">Nama Matakuliah</label>

                            <input type="checkbox" id="check13" class="filled-in chk-col-red" name="check[]" value="kode_matakuliah" checked="" />
                            <label for="check13">Kode</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check2" class="filled-in chk-col-red" name="check[]" value="prodi" />
                            <label for="check2">Prodi</label>

                            <input type="checkbox" id="check3" class="filled-in chk-col-red" name="check[]" value="fakultas" />
                            <label for="check3">Fakultas</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check6" class="filled-in chk-col-red" name="check[]" value="kurikulum" />
                            <label for="check6">Kurikulum</label>

                            <input type="checkbox" id="check7" class="filled-in chk-col-red" name="check[]" value="bidang" />
                            <label for="check7">Bidang Minat</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check8" class="filled-in chk-col-red" name="check[]" value="jenis_matakuliah" />
                            <label for="check8">Jenis Matakuliah</label>

                            <input type="checkbox" id="check11" class="filled-in chk-col-red" name="check[]" value="metode_pembelajaran" />
                            <label for="check11">Metode Pembelajaran</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check12" class="filled-in chk-col-red" name="check[]" value="pengampu" />
                            <label for="check12">Pengampu</label>

                            <input type="checkbox" id="check4" class="filled-in chk-col-red" name="check[]" value="semester" />
                            <label for="check4">Semester</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check5" class="filled-in chk-col-red" name="check[]" value="sks" />
                            <label for="check5">Sks</label>

                        </div>
                    </div>

                </div>
                <hr>

                <input type="hidden" name="output" id="output">
                <div class="form-actions mt-3">
                    <button class="btn btn-sm btn-info waves-effect waves-light" type="button" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>

                    <button class="btn btn-sm btn-secondary waves-effect waves-light" type="button" id="btn-cawang"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</button>

                    <button class="btn btn-sm btn-success waves-effect waves-light" type="button" id="btn-excel"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak Excel</button>

                    <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i
                                class="fa fa-plus"></i></span>Tambah Data</button>

                </div>
            </form>
        </div>
    </div>

    <div class="card card-outline-danger">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Daftar Matakuliah</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- <a href="print-matakuliah{{$parameter}} " class="btn btn-info btn-sm waves-effect waves-light" type="button"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</a> --}}
                <table id="table" class="table table-bordered table-hover table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="30px">#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Fakultas</th>
                            <th>Kurikulum</th>
                            <th>Jenis Matakuliah</th>
                            <th>Metode Pembelajaran</th>
                            <th>Wajib/Pilihan</th>
                            <th>Pengampu</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matkuls as $key => $matkul)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $matkul->kode_matakuliah }}</td>
                                <td>{{ $matkul->nama_matakuliah }}</td>
                                <td>{{ $matkul->prodi->nama_prodi }}</td>
                                <td>{{ $matkul->fakultas->nama_fakultas }}</td>
                                <td>{{ $matkul->kurikulum->nama_kurikulum ?? '-' }}</td>
                                <td>{{ $matkul->jenismatkul->nama_jenis ?? '-' }}</td>
                                <td>{{ $matkul->kelompokmatkul->nama_kelompok ?? '-' }}</td>
                                @if ($matkul->wajibpilihan_id == 1)
                                    <td>wajib</td>
                                @else
                                    <td>pilihan</td>
                                @endif
                                <td>{{ $matkul->pengampu->nama_tercetak ?? '-' }}</td>
                                <td>{{ $matkul->semester }}</td>

                                <td>
                                    <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_matakuliah(this, {{ $matkul->matakuliah_id . ',' . $matkul->prodi_id }})"
                                        data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_matakuliah(this, {{ $matkul->matakuliah_id }})" data-toggle="tooltip"
                                        title="Hapus"><i class="fa fa-trash"></i></button>
                                    {{-- <button class="btn btn-outline-info btn-sm btn-prasyarat" data-toggle="tooltip" title="Set Prasyarat Matakuliah" data-id="{{ $matkul->matakuliah_id }}"><span class="fa fa-cogs"></span></button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-right mt-2">
                {{ $matkuls->links() }}
            </div>
        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="" id="form-add-matakuliah" action="{{ route('matakuliah.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Prodi</label>
                            <select class="select2 form-control custom-select" style="width: 100%" name="prodi_id" id="prodi_id" required="">
                                @if ($tipe == 'operator')
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                @else
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($faks as $fak)
                                        <optgroup label="Fakultas {{ $fak->nama_fakultas }}">
                                            @foreach ($fak->prodi as $prodi)
                                                <option value={{ $prodi->prodi_id }}>{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group m-t-20">
                            <label class="control-label">Kode Matakuliah</label>
                            <input type="text" class="form-control" id="kode_matakuliah" name="kode_matakuliah" required="">
                        </div>
                        <div class="form-group m-t-20">
                            <label class="control-label">Nama Matakuliah</label>
                            <input type="text" class="form-control" id="nama_matakuliah" name="nama_matakuliah" required="">
                        </div>
                        <div class="form-group m-t-20">
                            <label class="control-label">Name English</label>
                            <input type="text" class="form-control" id="name_english_matakuliah" name="name_english_matakuliah" required="">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Kurikulum</label>
                                <select class="form-control" name="kurikulum" id="kurikulum" required="">
                                    @foreach ($kurikulums as $kurikulum)
                                        <option value="{{ $kurikulum->kurikulum_id }}">{{ $kurikulum->nama_kurikulum }} - {{ $kurikulum->prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bidang Minat</label>
                                <select class="form-control" name="bidangminat" id="bidangminat" required="" {{ $tipe == 'admin' ? 'disabled' : '' }}>
                                    <option value="">Pilih Bidang Minat</option>
                                    @if ($tipe == 'operator')
                                        @foreach ($binats as $binat)
                                            <option value="{{ $binat->bidangminat_id }}">{{ $binat->nama_bidang }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">Semester</label>
                                <input type="number" class="form-control" id="semester" name="semester" required="">
                            </div>
                        </div>

                        <div class="form-group m-t-30">
                            <label>Pengampu</label>
                            <select class="select2 form-control custom-select" style="width: 100%" name="pengampu_id" id="pengampu_id" {{ $tipe == 'admin' ? 'disabled' : '' }}>
                                <option value="">Pilih Pengampu</option>
                                @if ($tipe == 'operator')
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->dosen_id }}">{{ $dosen->fakultas->nama_fakultas . ' - ' . $dosen->prodi->nama_prodi . ' - ' . $dosen->nama_tercetak }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Matakuliah</label>
                                <input type="number" class="form-control" id="sks" name="sks" value="0" required="" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Tatap Muka</label>
                                <input type="number" class="form-control" id="sks_tatapmuka" name="sks_tatapmuka" value="0" required="" onchange="onSksInsertChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Praktikum</label>
                                <input type="number" class="form-control" id="sks_praktikum" name="sks_praktikum" value="0" required="" onchange="onSksInsertChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Praktek Lapangan</label>
                                <input type="number" class="form-control" id="sks_prakteklapangan" name="sks_prakteklapangan" value="0" required="" onchange="onSksInsertChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Simulasi</label>
                                <input type="number" class="form-control" id="sks_simulasi" name="sks_simulasi" value="0" required="" onchange="onSksInsertChange(this)">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Prasyarat SKS</label>
                                <input type="number" class="form-control" id="prasyarat_sks" name="prasyarat_sks" value="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Wajib Pilihan</label>
                                <select class="form-control" name="wajibpilihan" id="wajibpilihan" required="">
                                    <option value="1">Wajib</option>
                                    <option value="2">Pilihan</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Jenis Matakuliah</label>
                                <select class="form-control" name="jenismatkul" id="jenismatkul" required="">
                                    @foreach ($jenismatkuls as $jenis)
                                        <option value="{{ $jenis->jenismatakuliah_id }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Metode Pembelajaran</label>
                                <select class="form-control" name="kelompokmatkul" id="kelompokmatkul">
                                    @foreach ($kelompokmatkuls as $kelompok)
                                        <option value="{{ $kelompok->kelompokmatakuliah_id }}">{{ $kelompok->nama_kelompok }}</option>
                                    @endforeach
                                </select>
                            </div>

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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="" id="form-edit-matakuliah" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Prodi</label>
                            <select class="select2 form-control custom-select" style="width: 100%" name="prodi_id" id="prodi_id_edit" required="">
                                @if ($tipe == 'operator')
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                @else
                                    @foreach ($faks as $fak)
                                        <optgroup label="Fakultas {{ $fak->nama_fakultas }}">
                                            @foreach ($fak->prodi as $prodi)
                                                <option value={{ $prodi->prodi_id }}>{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label">Kode Matakuliah</label>
                            <input type="text" class="form-control" id="kode_matakuliah_edit" name="kode_matakuliah" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Matakuliah</label>
                            <input type="text" class="form-control" id="nama_matakuliah_edit" name="nama_matakuliah" required="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Name English</label>
                            <input type="text" class="form-control" id="name_english_matakuliah_edit" name="name_english_matakuliah" required="">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Kurikulum</label>
                                <select class="form-control" name="kurikulum" id="kurikulum_edit" required="">
                                    @foreach ($kurikulums as $kurikulum)
                                        <option value="{{ $kurikulum->kurikulum_id }}">{{ $kurikulum->nama_kurikulum }} - {{ $kurikulum->prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bidang Minat</label>
                                <select class="form-control" name="bidangminat" id="bidangminat_edit" required="">
                                    <option value="">Pilih Bidang Minat</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">Semester</label>
                                <input type="number" class="form-control" id="semester_edit" name="semester" required="">
                            </div>
                        </div>

                        <div class="form-group m-t-30">
                            <label>Pengampu</label>
                            <select class="select2 form-control custom-select" style="width: 100%" name="pengampu_id" id="pengampu_id_edit">
                                <option value="">Pilih Pengampu</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Matakuliah</label>
                                <input type="number" class="form-control" id="sks_edit" name="sks" required="" value="0" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Tatap Muka</label>
                                <input type="number" class="form-control" id="sks_tatapmuka_edit" name="sks_tatapmuka" value="0" required="" onchange="onSksUpdateChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Praktikum</label>
                                <input type="number" class="form-control" id="sks_praktikum_edit" name="sks_praktikum" value="0" required="" onchange="onSksUpdateChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Praktek Lapangan</label>
                                <input type="number" class="form-control" id="sks_prakteklapangan_edit" name="sks_prakteklapangan" value="0" required="" onchange="onSksUpdateChange(this)">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Bobot Simulasi</label>
                                <input type="number" class="form-control" id="sks_simulasi_edit" name="sks_simulasi" value="0" required="" onchange="onSksUpdateChange(this)">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Prasyarat SKS</label>
                                <input type="number" class="form-control" id="prasyarat_sks_edit" name="prasyarat_sks" value="0" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Wajib Pilihan</label>
                                <select class="form-control" name="wajibpilihan" id="wajibpilihan_edit" required="">
                                    <option value="1">Wajib</option>
                                    <option value="2">Pilihan</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Jenis Matakuliah</label>
                                <select class="form-control" name="jenismatkul" id="jenismatkul_edit" required="">
                                    @foreach ($jenismatkuls as $jenis)
                                        <option value="{{ $jenis->jenismatakuliah_id }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Metode Pembelajaran</label>
                                <select class="form-control" name="kelompokmatkul" id="kelompokmatkul_edit">
                                    @foreach ($kelompokmatkuls as $kelompok)
                                        <option value="{{ $kelompok->kelompokmatakuliah_id }}">{{ $kelompok->nama_kelompok }}</option>
                                    @endforeach
                                </select>
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

    <div id="modal-none" data-backdrop="static" data-keyboard="false" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white text-uppercase"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/master-matakuliah/main.js') }}"></script>
    <script>
        $('#table').DataTable({
            paging: false,
            bInfo: false
        });
        // $('a.toggle-vis').on( 'click', function (e) {
        //     e.preventDefault();

        //     // Get the column API object
        //     var column = table.column( $(this).attr('data-column') );

        //     // Toggle the visibility
        //     column.visible( ! column.visible() );
        // } );


        $('.select2').select2();

        function edit_matakuliah(e, id_matkul, id_prodi) {
            var row = $(e).closest('tr').find('td');
            var kode = row[1].innerHTML;
            var nama = row[2].innerHTML;
            var smt = row[10].innerHTML;

            var binat_id;
            var dosen_id;

            $('#kode_matakuliah_edit').val(kode);
            $('#nama_matakuliah_edit').val(nama);
            $('#semester_edit').val(smt);
            $('#prodi_id_edit').val(id_prodi).trigger('change');

            $('#name_english_matakuliah_edit').val('');
            $('#sks_edit').val('');
            $('#sks_tatapmuka_edit').val('');
            $('#sks_praktikum_edit').val('');
            $('#sks_praktek_lapangan_edit').val('');
            $('#prasyarat_sks_edit').val('');



            $.get({
                url: '{{ route('matakuliah.index') }}' + '/matkul/' + id_matkul,
                success: function(data) {
                    console.log(data);
                    binat_id = data['bidangminat_id'];
                    dosen_id = data['pengampu_id'];

                    $('#name_english_matakuliah_edit').val(data['name_english']);
                    $('#kurikulum_edit').val(data['kurikulum_id']).trigger('change');
                    $('#sks_edit').val(data['sks']);
                    $('#sks_tatapmuka_edit').val(data['sks_tatapmuka']);
                    $('#sks_praktikum_edit').val(data['sks_praktikum']);
                    $('#sks_prakteklapangan_edit').val(data['sks_prakteklapangan']);
                    $('#sks_simulasi_edit').val(data['sks_simulasi']);
                    $('#prasyarat_sks_edit').val(data['prasyarat_sks']);
                    $('#wajibpilihan_edit').val(data['wajibpilihan_id']).trigger('change');
                    $('#kelompokmatkul_edit').val(data['kelompokmatakuliah_id']).trigger('change');
                    $('#jenismatkul_edit').val(data['jenismatakuliah_id']).trigger('change');

                }
            })

            var binat_list = '';
            $.get({
                url: '{{ route('bidang-minat.index') }}' + '/prodi/' + id_prodi,
                success: function(data) {
                    $.each(data, function(key, value) {
                        binat_list += '<option value="' + value['bidangminat_id'] + '" >' + value['nama_bidang'] + '</option>'
                    })

                    $('#bidangminat_edit').html(binat_list);
                    $('#bidangminat_edit').val(binat_id).trigger('change');
                }
            })

            var pengampu_list = '';
            $.get({
                url: '/master/dosen/allprodi/' + id_prodi,
                success: function(data) {
                    $.each(data, function(key, value) {
                        pengampu_list += '<option value="' + value['dosen_id'] + '" >' + value['fakultas']['nama_fakultas'] + ' - ' + value['prodi']['nama_prodi'] + ' - ' + value[
                            'nama_tercetak'] + '</option>'
                    })

                    $('#pengampu_id_edit').html(pengampu_list);
                    $('#pengampu_id_edit').val(dosen_id).trigger('change');
                }
            })

            $('#form-edit-matakuliah').attr('action', '{{ route('matakuliah.index') }}' + '/' + id_matkul);
            $('#modal-edit').modal('show');

        }

        function delete_matakuliah(e, id_matkul) {
            var row = $(e).closest('tr').find('td');
            var nama = row[2].innerHTML;

            swal({
                title: "Hapus " + nama + "?",
                text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: true
            }, function() {
                var url = '/master/matakuliah/' + id_matkul;
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
                                "Sukses menghapus " + nama,
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

        function get_binat_by_prodi(id, tag_target) {
            $(tag_target).empty();
            var url = '{{ route('bidang-minat.index') }}' + '/prodi/' + id;
            var binat_list = '';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        binat_list += '<option value="' + value['bidangminat_id'] + '" >' + value['nama_bidang'] + '</option>'
                    })

                    $(tag_target).html(binat_list);
                    $(tag_target).removeAttr('disabled');
                }
            })
        }

        // function get_dosen_by_prodi(id, tag_target){
        //   $(tag_target).empty();
        //   var url = '{{ route('dosen.index') }}' + '/prodi/' + id;
        //   var pengampu_list = '';
        //   $.get({
        //     url:url,
        //     success: function(data){
        //       $.each(data, function(key, value){
        //         pengampu_list += '<option value="'+ value['dosen_id'] +'" >'+ value['nama_tercetak'] +'</option>'
        //       })

        //       $(tag_target).html(pengampu_list);
        //       $(tag_target).removeAttr('disabled');
        //     }
        //   })
        // }

        $('#prodi_id').change(function() {
            var id = $('#prodi_id').val();
            get_binat_by_prodi(id, '#bidangminat');
            // get_dosen_by_prodi(id, '#pengampu_id');

        })

        $('#prodi_id_edit').change(function() {
            var id = $('#prodi_id_edit').val();
            get_binat_by_prodi(id, '#bidangminat_edit');
            // get_dosen_by_prodi(id, '#pengampu_id_edit');

        })

        $('#btn-tampilkan').click(function() {
            $('#form-filter').attr('action', '{{ route('matakuliah.index') }}');
            $('#form-filter').attr('method', 'get');
            $('#form-filter').submit();
        })

        $('#btn-cawang').click(function() {
            $('#form-filter').attr('action', '{{ route('matakuliah_print') }}');
            $('#form-filter').attr('method', 'post');
            $('#form-filter').submit();
        })

        $('#btn-excel').click(function() {
            $("#output").val('excel')
            $('#form-filter').attr('action', '{{ route('matakuliah_print') }}');
            $('#form-filter').attr('method', 'post');
            $('#form-filter').submit();
        })

        $(document).ready(function() {
            var f_id = $('#fak_f').val();
            var tipe = {!! json_encode($tipe) !!};

            if (f_id && f_id != '-' && tipe == 'admin') {
                $('#load-prodi_filter').show();
                // $('#load-kurikulum_filter').show();
                get_prodi_by_fak_id(f_id, '#prodi_f', '#load-prodi_filter');
                // get_kurikulum_by_fak_id(f_id, '#kur_f', '#load-kurikulum_filter');
                var p_id = $('#prodi_f').val();
                get_kurikulum_by_prodi_id(p_id, '#kur_f', '#load-kurikulum_filter');

            }

        });

        function get_prodi_by_fak_id(id, tag_prodi_id, tag_loading) {
            var url = '{{ route('prodi.index') }}' + '/fakultas/' + id;
            var prodi_list = '<option value="-">Pilih Prodi</option>';

            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        prodi_list += '<option value="' + value['prodi_id'] + '" >' + value['nama_prodi'] + '</option>'
                    })

                    $(tag_prodi_id).html(prodi_list);
                    $(tag_loading).hide();

                    var p_id = {!! json_encode(request()->prodi_f) !!};
                    if (p_id && p_id != '-') {
                        $('#prodi_f').val(p_id).trigger('change');

                    }
                }
            })
        }

        function get_kurikulum_by_fak_id(id, tag_kurikulum_id, tag_loading) {
            var url = '{{ route('kurikulum.index') }}' + '/fakultas/' + id;
            var kurikulums = '<option value="-">Pilih Kurikulum</option>';

            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        kurikulums += '<option value="' + value['kurikulum_id'] + '" >' + value['nama_kurikulum'] + '</option>'
                    })

                    $(tag_kurikulum_id).html(kurikulums);
                    $(tag_loading).hide();

                    var k_id = {!! json_encode(request()->kur_f) !!};
                    if (k_id && k_id != '-') {
                        $('#kur_f').val(k_id).trigger('change');

                    }


                }
            })
        }

        function get_kurikulum_by_prodi_id(id, tag_kurikulum_id, tag_loading) {
            var url = '{{ route('kurikulum.index') }}' + '/prodi/' + id;
            var kurikulums = '<option value="-">Pilih Kurikulum</option>';

            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        kurikulums += '<option value="' + value['kurikulum_id'] + '" >' + value['nama_kurikulum'] + '</option>'
                    })

                    $(tag_kurikulum_id).html(kurikulums);
                    $(tag_loading).hide();

                    var k_id = {!! json_encode(request()->kur_f) !!};
                    if (k_id && k_id != '-') {
                        $('#kur_f').val(k_id).trigger('change');

                    }


                }
            })
        }

        $('#fak_f').change(function() {
            $('#load-prodi_filter').show();
            // $('#load-kurikulum_filter').show();
            var id = $('#fak_f').val();
            $('#prodi_f').empty();
            // $('#kur_f').empty();
            get_prodi_by_fak_id(id, '#prodi_f', '#load-prodi_filter');
            // get_kurikulum_by_fak_id(id, '#kur_f', '#load-kurikulum_filter');
        })

        $('#prodi_f').change(function() {
            $('#load-kurikulum_filter').show();
            var id = $('#prodi_f').val();
            $('#kur_f').empty();
            get_kurikulum_by_prodi_id(id, '#kur_f', '#load-kurikulum_filter');
        })

        function onSksInsertChange(e) {

            let tatapmuka = $("#sks_tatapmuka").val()
            let praktikum = $("#sks_praktikum").val()
            let prakteklapangan = $("#sks_prakteklapangan").val()
            let simulasi = $("#sks_simulasi").val()

            let total_sks = parseInt(tatapmuka) + parseInt(praktikum) + parseInt(prakteklapangan) + parseInt(simulasi);

            $("#sks").val(total_sks)
        }

        function onSksUpdateChange(e) {

            let tatapmuka = $("#sks_tatapmuka_edit").val()
            let praktikum = $("#sks_praktikum_edit").val()
            let prakteklapangan = $("#sks_prakteklapangan_edit").val()
            let simulasi = $("#sks_simulasi_edit").val()

            let total_sks = parseInt(tatapmuka) + parseInt(praktikum) + parseInt(prakteklapangan) + parseInt(simulasi);

            $("#sks_edit").val(total_sks)
        }
    </script>
@endsection
