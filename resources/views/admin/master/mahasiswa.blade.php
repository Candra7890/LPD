@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Mahasiswa
@endsection

@section('page-name')
    Data Mahasiswa
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Master Mahasiswa</li>
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

    {{-- <script>
function edit_mhs(id, ids, idss){
  alert('ahl');
}
</script> --}}
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
            {{-- <form class="" action="{{route('mahasiswa.index')}}" method="get" id="form-filter"> --}}
            <form class="" id="form-filter">
                @csrf
                <div class="row">
                    <div class="col-md-6">
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
                                        <option {{ $fak->fakultas_id == $request->fak_f ? 'selected' : '' }} value="{{ $fak->fakultas_id }} ">{{ $fak->nama_fakultas }}</option>
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
                                <label>Program</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="prog_f" id="prog_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($programs as $prog)
                                        <option {{ $prog->program_id == $request->prog_f ? 'selected' : '' }} value="{{ $prog->program_id }}">{{ $prog->nama_program }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Bidang Minat</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-binat_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="binat_f" id="binat_f" required="" {{ $tipe != 'operator' ? 'disabled' : '' }}>
                                    <option value="-">Semua</option>
                                    {{-- ajax ketika prodi dipilih --}}
                                    @if ($tipe == 'operator')
                                        @foreach ($binats as $binat)
                                            <option {{ $binat->bidangminat_id == $request->binat_f ? 'selected' : '' }} value="{{ $binat->bidangminat_id }}">{{ $binat->nama_bidang }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Dosen PA</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-dosen_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="pa_f" id="pa_f" required="" {{ $tipe != 'operator' ? 'disabled' : '' }}>
                                    <option value="-">Semua</option>
                                    {{-- ajax ketika prodi dipilih --}}
                                    @if ($tipe == 'operator')
                                        @foreach ($dosens as $dosen)
                                            <option {{ $dosen->dosen_id == $request->pa_f ? 'selected' : '' }} value="{{ $dosen->dosen_id }}">{{ $dosen->nama_tercetak }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Angkatan</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="ang_f" id="ang_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($angkatans as $ang)
                                        <option {{ $ang->angkatan_id == $request->ang_f ? 'selected' : '' }} value="{{ $ang->angkatan_id }} ">
                                            {{ $ang->tahun . ' - ' }}{{ $ang->semester_id == 1 ? 'Ganjil' : 'Genap' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>MBKM</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="mbkm_f" id="mbkm_f" required="">
                                    <option value="-">Semua</option>
                                    <option {{ 5 == $request->mbkm_f ? 'selected' : '' }} value="5">MBKM Semester V / 5</option>
                                    <option {{ 6 == $request->mbkm_f ? 'selected' : '' }} value="6">MBKM Semester VI / 6</option>
                                    <option {{ 7 == $request->mbkm_f ? 'selected' : '' }} value="7">MBKM Semester VII / 7</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <select class="form-control custom-select" name="cari_f" required="">
                                    <option value="-">Cari</option>
                                    <option {{ $request->cari_f == 'nama' ? 'selected' : '' }} value="nama">Nama
                                    </option>
                                    <option {{ $request->cari_f == 'nim' ? 'selected' : '' }} value="nim">NIM
                                    </option>
                                    <option {{ $request->cari_f == 'nim_va' ? 'selected' : '' }} value="nim_va">NIM VA
                                    </option>
                                    <option {{ $request->cari_f == 'alamat' ? 'selected' : '' }} value="alamat">Alamat
                                        Asal</option>
                                    <option {{ $request->cari_f == 'email' ? 'selected' : '' }} value="email">Email
                                    </option>
                                    <option {{ $request->cari_f == 'telepon' ? 'selected' : '' }} value="telepon">
                                        Telepon</option>
                                    <option {{ $request->cari_f == 'ktp' ? 'selected' : '' }} value="ktp">Nomor KTP
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="keterangan_f" value="{{ $request->keterangan_f }}" required="">

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Status Aktif</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="stats_f" id="stats_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($stats as $stat)
                                        <option {{ $stat->statusaktif_id == $request->stats_f ? 'selected' : '' }} value="{{ $stat->statusaktif_id }}">{{ $stat->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Agama</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="agama_f" id="agama_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($agamas as $agama)
                                        <option {{ $agama->agama_id == $request->agama_f ? 'selected' : '' }} value="{{ $agama->agama_id }}">{{ $agama->agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Jenis Kelamin</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="gender_f" id="gender_f" required="">
                                    <option value="-">Semua</option>
                                    <option {{ 'Pria' == $request->gender_f ? 'selected' : '' }} value="Pria">Pria
                                    </option>
                                    <option {{ 'Wanita' == $request->gender_f ? 'selected' : '' }} value="Wanita">Wanita
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Golongan Darah</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="gol_f" id="gol_f" required="">
                                    <option value="-">Semua</option>
                                    <option {{ 'A' == $request->gol_f ? 'selected' : '' }} value="A">A</option>
                                    <option {{ 'B' == $request->gol_f ? 'selected' : '' }} value="B">B</option>
                                    <option {{ 'AB' == $request->gol_f ? 'selected' : '' }} value="AB">AB</option>
                                    <option {{ 'O' == $request->gol_f ? 'selected' : '' }} value="O">O</option>

                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Provinsi</label>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="prov_f" id="prov_f" required="">
                                    <option value="-">Semua</option>
                                    @foreach ($provs as $prov)
                                        <option {{ $prov->provinsi_id == $request->prov_f ? 'selected' : '' }} value="{{ $prov->provinsi_id }}">{{ $prov->nama_provinsi }}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Kabupaten</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-kab_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="kab_f" id="kab_f" required="">
                                    <option value="-">Semua</option>
                                    {{-- @foreach ($provs as $prov)
                            <optgroup label="Provinsi {{$prov->nama_provinsi}}">
                              @foreach ($prov->kabupaten as $kab)
                                <option {{($kab->kabupaten_id == $request->kab_f ? 'selected':'')}} value="{{ $kab->kabupaten_id }}">{{ $kab->nama_kabupaten}}</option>
                              @endforeach
                            </optgroup>
                          @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Kecamatan</label>
                                <span style="padding-right:3px; padding-top: 3px;">
                                    <img id="load-kec_filter" src="{{ asset('assets/images/loading-20px.gif') }}" style="display: none;"></img>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <select class="select2 form-control custom-select" name="kec_f" id="kec_f" required="">
                                    <option value="-">Semua</option>
                                    {{-- @foreach ($provs as $prov)
                            <optgroup label="Provinsi {{$prov->nama_provinsi}}">
                              @foreach ($prov->kabupaten as $kab)
                                <optgroup label="Kabupaten {{$kab->nama_kabupaten}}">
                                  @foreach ($kab->kecamatan as $kec)
                                    <option {{($kec->kecamatan_id == $request->kec_f ? 'selected':'')}} value="{{ $kec->kecamatan_id }}">{{ $kec->nama_kecamatan}}</option>
                                  @endforeach
                                </optgroup>
                              @endforeach
                            </optgroup>
                          @endforeach --}}
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check9" class="filled-in chk-col-red" name="check[]" value="nim" checked />
                            <label for="check9">NIM</label>

                            <input type="checkbox" id="check14" class="filled-in chk-col-red" name="check[]" value="nama" checked />
                            <label for="check14">Nama</label>

                            <input type="checkbox" id="check1" class="filled-in chk-col-red" name="check[]" value="tahun" />
                            <label for="check1">Angkatan</label>

                            <input type="checkbox" id="check2" class="filled-in chk-col-red" name="check[]" value="nama_prodi" />
                            <label for="check2">Prodi</label>

                            <input type="checkbox" id="check3" class="filled-in chk-col-red" name="check[]" value="nama_fakultas" />
                            <label for="check3">Fakultas</label>

                            <input type="checkbox" id="check26" class="filled-in chk-col-red" name="check[]" value="nama_jalur" />
                            <label for="check26">Jalur Masuk</label>



                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check6" class="filled-in chk-col-red" name="check[]" value="jenjang" />
                            <label for="check6">Jenjang Prodi</label>

                            <input type="checkbox" id="check7" class="filled-in chk-col-red" name="check[]" value="nama_program" />
                            <label for="check7">Program</label>

                            <input type="checkbox" id="check11" class="filled-in chk-col-red" name="check[]" value="agama" />
                            <label for="check11">Agama</label>

                            <input type="checkbox" id="check12" class="filled-in chk-col-red" name="check[]" value="kelamin_id" />
                            <label for="check12">Jenis Kelamin</label>

                            <input type="checkbox" id="check13" class="filled-in chk-col-red" name="check[]" value="nama_bidang" />
                            <label for="check13">Bidang Minat</label>

                            <input type="checkbox" id="check27" class="filled-in chk-col-red" name="check[]" value="nama_biaya" />
                            <label for="check27">Biaya Masuk</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check21" class="filled-in chk-col-red" name="check[]" value="nama_ayah" />
                            <label for="check21">Nama Ayah</label>

                            <input type="checkbox" id="check22" class="filled-in chk-col-red" name="check[]" value="nama_ibu" />
                            <label for="check22">Nama Ibu</label>

                            <input type="checkbox" id="check23" class="filled-in chk-col-red" name="check[]" value="email" />
                            <label for="check23">Email</label>

                            <input type="checkbox" id="check24" class="filled-in chk-col-red" name="check[]" value="no_ktp" />
                            <label for="check24">No KTP</label>

                            <input type="checkbox" id="check5" class="filled-in chk-col-red" name="check[]" value="nama_tercetak" />
                            <label for="check5">PA</label>

                            <input type="checkbox" id="check28" class="filled-in chk-col-red" name="check[]" value="MBKM" />
                            <label for="check28">MBKM</label>


                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check8" class="filled-in chk-col-red" name="check[]" value="nama_sma" />
                            <label for="check8">Asal SMA</label>

                            <input type="checkbox" id="check17" class="filled-in chk-col-red" name="check[]" value="alamat_asal" />
                            <label for="check17">Alamat Asal</label>

                            <input type="checkbox" id="check18" class="filled-in chk-col-red" name="check[]" value="alamat_asal_telepon" />
                            <label for="check18">Alamat Asal Telepon</label>

                            <input type="checkbox" id="check19" class="filled-in chk-col-red" name="check[]" value="alamat_tinggal" />
                            <label for="check19">Alamat Tinggal</label>

                            <input type="checkbox" id="check20" class="filled-in chk-col-red" name="check[]" value="alamat_tinggal_telepon" />
                            <label for="check20">Alamat Tinggal Telepon</label>

                            <input type="checkbox" id="check29" class="filled-in chk-col-red" name="check[]" value="jenis_mbkm" />
                            <label for="check29">Jenis MBKM</label>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="demo-checkbox">
                            <input type="checkbox" id="check10" class="filled-in chk-col-red" name="check[]" value="nisn" />
                            <label for="check10">NISN</label>

                            <input type="checkbox" id="check15" class="filled-in chk-col-red" name="check[]" value="tanggal_lahir" />
                            <label for="check15">Tanggal Lahir</label>

                            <input type="checkbox" id="check16" class="filled-in chk-col-red" name="check[]" value="tempat_lahir" />
                            <label for="check16">Tempat Lahir</label>

                            <input type="checkbox" id="check4" class="filled-in chk-col-red" name="check[]" value="goldarah_id" />
                            <label for="check4">Golongan Darah</label>

                            <input type="checkbox" id="check25" class="filled-in chk-col-red" name="check[]" value="status" />
                            <label for="check25">Status Aktif</label>

                            <input type="checkbox" id="check30" class="filled-in chk-col-red" name="check[]" value="nama_provinsi" />
                            <label for="check30">Provinsi</label>

                            <input type="checkbox" id="check31" class="filled-in chk-col-red" name="check[]" value="nama_kabupaten" />
                            <label for="check31">Kabupaten</label>
                        </div>
                    </div>

                </div>

                <div class="form-actions mt-3">
                    <button class="btn btn-sm btn-info waves-effect waves-light" type="button" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>

                    {{-- <button class="btn btn-sm btn-secondary waves-effect waves-light" type="button" id="btn-cawang"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</button> --}}

                </div>

                <hr>
                <h6>Cetak Data ini</h6>
                <input type="hidden" name="output" id="output">
                <button class="btn btn-sm btn-danger waves-effect waves-light" type="button" id="btn-cawang">PDF</button>
                <button class="btn btn-sm btn-success waves-effect waves-light" type="button" id="btn-excel">EXCEL</button>
            </form>
        </div>
    </div>

    <div class="card card-outline-danger">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Daftar Mahasiswa</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button> --}}
                {{-- <div class="btn-group">
          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak
          </button>
          <div class="dropdown-menu">
              <a class="dropdown-item" href="print-mahasiswa{{$parameter}}">Cetak PDF</a>
          </div>
      </div> --}}
                {{-- <a href="print-mahasiswa{{$parameter}} " class="btn btn-info btn-sm waves-effect waves-light" type="button"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</a> --}}
                <table id="table" class="table table-bordered table-hover table-sm table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="30px">#</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Fakultas</th>
                            <th>Agama</th>
                            <th>Gender</th>
                            <th>Bidang Minat</th>
                            {{-- <th>NIM VA</th> --}}

                            <th>PA</th>
                            <th>KTP</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $datum)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $datum->nim }}</td>
                                <td>{{ $datum->nama }}</td>
                                <td>{{ ($datum->jenjang->jenjang ?? ' ') . ' ' . $datum->prodi->nama_prodi }}</td>
                                <td>{{ $datum->fakultas->nama_fakultas }}</td>
                                <td>
                                    @if (isset($datum->agama->agama))
                                        {{ $datum->agama->agama }}
                                    @endif
                                </td>
                                <td>{{ $datum->kelamin_id }}</td>
                                <td>
                                    @if (isset($datum->binat->nama_bidang))
                                        {{ $datum->binat->nama_bidang }}
                                    @endif
                                </td>
                                {{-- <td>{{ $datum->nim_va }}</td> --}}

                                <td>
                                    @if (isset($datum->pa->nama_tercetak))
                                        {{ $datum->pa->nama_tercetak }}
                                    @endif
                                </td>
                                <td>{{ $datum->no_ktp }}</td>
                                <td>{{ $datum->alamat_tinggal_telepon }}</td>
                                <td>
                                    @if (isset($datum->statusaktif->status))
                                        {{ $datum->statusaktif->status }}
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_mhs(this, {{ $datum->mahasiswa_id . ',' . $datum->prodi_id }})"
                                        data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick="edit_email({{ $datum->mahasiswa_id }}, {{ "'" . $datum->nim . "'" }})"
                                        data-toggle="tooltip" title="Edit Email"><i class="mdi mdi-email"></i></button>
                                    {{-- <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_mhs(this, {{ $datum->mahasiswa_id }})" data-toggle="tooltip"
                                        title="Hapus"><i class="fa fa-trash"></i></button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-right mt-2">
                {{ $data->links() }}
            </div>

        </div>
    </div>

    {{-- modal insert --}}
    <div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="" id="form-add-mahasiswa" action="{{ route('mahasiswa.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Prodi</label>
                            <select class="form-control" style="width: 100%" name="prodi_id" id="prodi_id" required="">
                                @if ($tipe == 'operator')
                                    @foreach ($prodis as $prodi)
                                        <option {{ $prodi->prodi_id == $request->prodi_f ? 'selected' : '' }} value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                @else
                                    <option>Pilih Prodi</option>
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

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Angkatan</label>
                                <select class="form-control" name="angkatan" id="angkatan" required="">
                                    <option>Pilih Angkatan</option>
                                    @foreach ($angkatans as $ang)
                                        <option value="{{ $ang->angkatan_id }}">
                                            {{ $ang->tahun . ' Semester ' }}{{ $ang->semester_id == 1 ? 'Ganjil' : 'Genap' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bidang Minat</label>
                                <select class="form-control" name="bidangminat" id="bidangminat" required="">
                                    <option value="">Pilih Bidang Minat</option>
                                    @if ($tipe == 'operator')
                                        @foreach ($binats as $binat)
                                            <option {{ $binat->bidangminat_id == $request->binat_f ? 'selected' : '' }} value="{{ $binat->bidangminat_id }}">{{ $binat->nama_bidang }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Program</label>
                                <select class="form-control" name="program" id="program" required="">
                                    @foreach ($programs as $program)
                                        <option value={{ $program->program_id }}>{{ $program->nama_program }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">NIM</label>
                                <input type="number" class="form-control" id="nim" name="nim" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">NIM VA</label>
                                <input type="text" class="form-control" id="nim_va" name="nim_va" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required="">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Tempat / Tanggal Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>.</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="gender" id="gender" required="">
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Agama</label>
                                <select class="form-control" name="agama" id="agama" required="">
                                    @foreach ($agamas as $agama)
                                        <option value="{{ $agama->agama_id }}">{{ $agama->agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Golongan Darah</label>
                                <select class="form-control" name="goldar" id="goldar" required="">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Nama Ayah</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" required="">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Nama Ibu</label>
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" required="">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Asal</label>
                                <textarea class="form-control" id="alamat_asal" name="alamat_asal" required=""></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Asal Telepon</label>
                                <input type="number" class="form-control" id="alamat_asal_tlp" name="alamat_asal_tlp" required="">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Tinggal</label>
                                <textarea class="form-control" id="alamat_tinggal" name="alamat_tinggal" required=""></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Tinggal Telepon</label>
                                <input type="number" class="form-control" id="alamat_tinggal_tlp" name="alamat_tinggal_tlp" required="">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required="">
                            </div>


                            <div class="form-group col-md-4">
                                <label class="control-label">Nomor KTP</label>
                                <input type="number" class="form-control" id="ktp" name="ktp" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label>PA</label>
                                <select class="form-control" name="pa" id="pa_id" required="">
                                    {{-- @foreach ($dosens as $pa)
                      <option value="{{$pa->dosen_id}}">{{$pa->nama_tercetak}}</option>
                    @endforeach --}}
                                </select>
                            </div>



                        </div>

                        <div class="form-group m-t-20">
                            <label>SMA</label>
                            <select class="form-control" name="sma" id="sma" required="">
                                @foreach ($smas as $sma)
                                    <option value="{{ $sma->sma_id }}">{{ $sma->nama_sma }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-t-30">
                            <label>Wilayah</label>
                            <select class="select2 form-control custom-select" style="width: 100%" name="kec_id" id="kec_id_edit" required="">
                                @foreach ($provs as $prov)
                                    <optgroup label="Provinsi {{ $prov->nama_provinsi }}">
                                        @foreach ($prov->kabupaten as $kab)
                                    <optgroup label="Kabupaten {{ $kab->nama_kabupaten }}">
                                        @foreach ($kab->kecamatan as $kec)
                                            <option value={{ $kec->kecamatan_id }}>{{ '- ' . $kec->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                                </optgroup>
                                @endforeach
                            </select>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">SKS Awal</label>
                                <input type="number" class="form-control" id="sks_awal" name="sks_awal" required="">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">IPK Awal</label>
                                <input type="number" step="any" min="0" max="100" class="form-control" id="ipk_awal" name="ipk_awal" required="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status Aktif</label>
                                <select class="form-control" name="statusaktif" id="statusaktif" required="">
                                    @foreach ($stats as $stat)
                                        <option value="{{ $stat->statusaktif_id }}">{{ $stat->status }}</option>
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
                <form class="" id="form-edit-mahasiswa" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                        <h4 class="modal-title">Sunting Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Prodi</label>
                            <select class="form-control" style="width: 100%;" name="prodi_id" id="prodi_id_edit" required="">
                                @if ($tipe == 'operator')
                                    @foreach ($prodis as $prodi)
                                        <option {{ $prodi->prodi_id == $request->prodi_f ? 'selected' : '' }} value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                @else
                                    @foreach ($faks as $fak)
                                        <optgroup label="Fakultas {{ $fak->nama_fakultas }}">
                                            @foreach ($fak->prodi as $prodi)
                                                <option value={{ $prodi->prodi_id }}>{{ $prodi->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Angkatan</label>
                                <select class="form-control" name="angkatan" id="angkatan_edit" required="">
                                    @foreach ($angkatans as $ang)
                                        <option value="{{ $ang->angkatan_id }}">
                                            {{ $ang->tahun . ' Semester ' }}{{ $ang->semester_id == 1 ? 'Ganjil' : 'Genap' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Bidang Minat</label>
                                <select class="form-control" name="bidangminat" id="bidangminat_edit">
                                    <option value="">Pilih Bidang Minat</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Program</label>
                                <select class="form-control" name="program" id="program_edit" required="">
                                    @foreach ($programs as $program)
                                        <option value={{ $program->program_id }}>{{ $program->nama_program }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">NIM</label>
                                <input type="number" class="form-control" id="nim_edit" name="nim" required="" readonly="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input type="text" class="form-control" id="nama_edit" name="nama" required="">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nama Tercetak</label>
                            <input type="text" class="form-control" id="namatercetak_edit" name="namatercetak" required="">
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Tempat / Tanggal Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_edit" name="tempat_lahir" required="">
                            </div>

                            <div class="form-group col-md-4">
                                <label>.</label>
                                <input type="date" class="form-control" id="tgl_lahir_edit" name="tgl_lahir" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="gender" id="gender_edit" required="">
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Agama</label>
                                <select class="form-control" name="agama" id="agama_edit" required="">
                                    @foreach ($agamas as $agama)
                                        <option value="{{ $agama->agama_id }}">{{ $agama->agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Golongan Darah</label>
                                <select class="form-control" name="goldar" id="goldar_edit">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Nama Ayah</label>
                                <input type="text" class="form-control" id="nama_ayah_edit" name="nama_ayah">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Nama Ibu</label>
                                <input type="text" class="form-control" id="nama_ibu_edit" name="nama_ibu">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Asal</label>
                                <textarea class="form-control" id="alamat_asal_edit" name="alamat_asal"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Asal Telepon</label>
                                <input type="number" class="form-control" id="alamat_asal_tlp_edit" name="alamat_asal_tlp">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Tinggal</label>
                                <textarea class="form-control" id="alamat_tinggal_edit" name="alamat_tinggal"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Alamat Tinggal Telepon</label>
                                <input type="number" class="form-control" id="alamat_tinggal_tlp_edit" name="alamat_tinggal_tlp">
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" id="email_edit" name="email">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">NIK / No. Passport</label>
                                <input type="text" class="form-control" id="ktp_edit" name="ktp">
                            </div>
                            {{-- <div class="form-group col-md-4">
                  <label>PA</label>
                  <select class="form-control" name="pa" id="pa_edit">
                    @foreach ($dosens as $pa)
                      <option value="{{$pa->dosen_id}}">{{$pa->nama_tercetak}}</option>
                    @endforeach
                  </select>
                </div> --}}

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>SMA</label>
                                <select class="form-control" name="sma" id="sma_edit">
                                    @foreach ($smas as $sma)
                                        <option value="{{ $sma->sma_id }}">{{ $sma->nama_sma }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>NISN</label>
                                <input type="text" class="form-control" id="nisn_edit" name="nisn">
                            </div>
                        </div>

                        {{-- <div class="form-group m-t-30">
                <label>Wilayah</label>
                <select class="select2 form-control custom-select" style="width: 100%" name="kec_id" id="kec_id_edit" required="">
                  @foreach ($provs as $prov)
                    <optgroup label="Provinsi {{$prov->nama_provinsi}}">
                      @foreach ($prov->kabupaten as $kab)
                        <optgroup label="Kabupaten {{$kab->nama_kabupaten}}">
                          @foreach ($kab->kecamatan as $kec)
                            <option value={{$kec->kecamatan_id}}>{{'- '.$kec->nama_kecamatan}}</option>
                          @endforeach
                        </optgroup>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
                
              </div> --}}

                        <div class="form-group m-t-30">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <label>Provinsi</label>
                                    <select class="select2 form-control custom-select" style="width: 100%" name="provinsi_e" id="provinsi_e">
                                        @foreach ($provs as $p)
                                            <option value="{{ $p->provinsi_id }}">{{ $p->nama_provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label>Kabupaten</label>
                                    <select class="select2 form-control custom-select" style="width: 100%" name="kabupaten_e" id="kabupaten_e">

                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label>Kecamatan</label>
                                    <select class="select2 form-control custom-select" style="width: 100%" name="kecamatan_e" id="kecamatan_e">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">SKS Awal</label>
                                <input type="number" class="form-control" id="sks_awal_edit" name="sks_awal">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">IPK Awal</label>
                                <input type="number" step="any" min="0" max="100" class="form-control" id="ipk_awal_edit" name="ipk_awal">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status Aktif</label>
                                <select class="form-control" name="statusaktif" id="statusaktif_edit" style="pointer-events: none;">
                                    @foreach ($stats as $stat)
                                        <option value="{{ $stat->statusaktif_id }}">{{ $stat->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Tanggal Masuk/Diterima</label>
                                <input type="date" class="form-control" id="tgl_masuk_edit" name="tgl_masuk">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Jalur Masuk</label>
                                <select class="form-control" name="jalurmasuk_id" id="jalurmasuk_id_edit">
                                    @foreach ($jalurmasuk as $jalur)
                                        <option value="{{ $jalur->jalurmasuk_id }}">{{ $jalur->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Biaya Masuk</label>
                                <select class="form-control" name="biayamasuk_id" id="biayamasuk_id_edit">
                                    <option value="1">Mandiri</option>
                                    <option value="2">Beasiswa Tidak Penuh</option>
                                    <option value="3">Beasiswa Penuh</option>
                                    <option value="4">Bidikmisi</option>
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

    {{-- modal edit email --}}
    <div id="modal-edit-email" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" id="form-edit-email" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Email</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="id_mhs_edit_email" name="id_mhs" hidden="" required="">
                        <div class="form-group">
                            <label class="control-label">NIM</label>
                            <input type="number" class="form-control" id="nim_edit_email" name="nim" required="" readonly="">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input type="text" class="form-control" id="nama_edit_email" name="nama" required="" readonly="">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required="">
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
    {{-- modal edit email --}}

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

        let KAB_ID = 0;
        let KEC_ID = 0;
        var load = '<option value="" selected="" disabled="">mohon tunggu..</option>';

        $('#btn-tampilkan').click(function() {
            $('#form-filter').attr('action', '{{ route('mahasiswa.index') }}');
            $('#form-filter').attr('method', 'get');
            $('#form-filter').submit();
        })

        $('#btn-cawang').click(function() {
            $("#output").val('pdf')
            $('#form-filter').attr('action', '{{ route('mahasiswa_print') }}');
            $('#form-filter').attr('method', 'post');
            $('#form-filter').submit();
        })

        $('#btn-excel').click(function() {
            $("#output").val('excel')
            $('#form-filter').attr('action', '{{ route('mahasiswa_print') }}');
            $('#form-filter').attr('method', 'post');
            $('#form-filter').submit();
        })

        function edit_email(id_mhs, nim) {
            // alert(id_mhs+ ' '+ nim);
            $('#id_mhs_edit_email').val(id_mhs);
            $('#nim_edit_email').val(nim);
            $('#nama_edit_email').val('');
            $('#edit_email').val('');

            $.get({
                url: '{{ route('mahasiswa.index') }}' + '/' + nim,
                success: function(data) {
                    // console.log(data);
                    $('#nama_edit_email').val(data['nama']);
                    $('#edit_email').val(data['email']);
                }
            })

            $('#form-edit-email').attr('action', '{{ route('mahasiswa.updateemail') }}');
            $('#modal-edit-email').modal('show');

        }

        function edit_mhs(e, id_mhs, id_prodi) {
            var row = $(e).closest('tr').find('td');
            var nim = row[1].innerHTML;
            var nama = row[2].innerHTML;
            var gender = row[6].innerHTML;
            var nim_va = row[8].innerHTML;

            var binat_id;
            var dosen_id;

            $('#prodi_id_edit').val(id_prodi).trigger('change');
            $('#gender_edit').val(gender).trigger('change');

            $('#nim_edit').val('');
            $('#nim_va_edit').val('');
            $('#nama_edit').val('');
            $('#namatercetak_edit').val('');
            $('#nama_ayah_edit').val('');
            $('#nama_ibu_edit').val('');
            $('#alamat_asal_edit').val('');
            $('#alamat_asal_tlp_edit').val('');
            $('#alamat_tinggal_edit').val('');
            $('#alamat_tinggal_tlp_edit').val('');
            $('#tempat_lahir_edit').val('');
            $('#tgl_lahir_edit').val('');
            $('#email_edit').val('');
            $('#ktp_edit').val('');
            $('#sks_awal_edit').val('');
            $('#ipk_awal_edit').val('');
            $('#goldar_edit').val('');

            var binat_list = '';
            $.get({
                url: '{{ route('bidang-minat.index') }}' + '/prodi/' + id_prodi,
                success: function(data) {
                    $.each(data, function(key, value) {
                        binat_list += '<option value="' + value['bidangminat_id'] + '" >' + value[
                            'nama_bidang'] + '</option>'
                    })

                    $('#bidangminat_edit').html(binat_list);
                    $('#bidangminat_edit').val(binat_id).trigger('change');
                }
            })

            var pa_list = '';
            $.get({
                url: '{{ route('dosen.index') }}' + '/prodi/' + id_prodi,
                success: function(data) {
                    $.each(data, function(key, value) {
                        pa_list += '<option value="' + value['dosen_id'] + '" >' + value[
                            'nama_tercetak'] + '</option>'
                    })

                    $('#pa_edit').html(pa_list);
                    $('#pa_edit').val(dosen_id).trigger('change');
                }
            })

            $.get({
                url: '{{ route('mahasiswa.index') }}' + '/' + nim,
                success: function(data) {
                    console.log(data);
                    binat_id = data['bidangminat_id'];
                    dosen_id = data['pa_id'];

                    $('#kec_id_edit').val(data['kecamatan_id']).change();
                    $('#nim_edit').val(data['nim']);
                    $('#nim_va_edit').val(data['nim_va']);
                    $('#nama_edit').val(data['nama']);
                    $('#namatercetak_edit').val(data['nama_tercetak']);
                    $('#nama_ayah_edit').val(data['nama_ayah']);
                    $('#nama_ibu_edit').val(data['nama_ibu']);
                    $('#alamat_asal_edit').val(data['alamat_asal']);
                    $('#alamat_asal_tlp_edit').val(data['alamat_asal_telepon']);
                    $('#alamat_tinggal_edit').val(data['alamat_tinggal']);
                    $('#alamat_tinggal_tlp_edit').val(data['alamat_tinggal_telepon']);
                    $('#tempat_lahir_edit').val(data['tempat_lahir']);
                    $('#tgl_lahir_edit').val(data['tanggal_lahir']);
                    $('#email_edit').val(data['email']);
                    $('#angkatan_edit').val(data['angkatan_id']).trigger('change');
                    $('#sma_edit').val(data['sma_id']).trigger('change');
                    $('#agama_edit').val(data['agama_id']).trigger('change');
                    $('#ktp_edit').val(data['no_ktp']);
                    $('#nisn_edit').val(data['nisn']);
                    $('#sks_awal_edit').val(data['sks_awal']);
                    $('#ipk_awal_edit').val(data['ipk_awal']);
                    $('#program_edit').val(data['program_id']).trigger('change');
                    $('#goldar_edit').val(data['goldarah_id']);
                    $('#statusaktif_edit').val(data['statusaktif_id']).trigger('change');
                    $('#tgl_masuk_edit').val(data['created_at']);
                    $('#jalurmasuk_id_edit').val(data['jalurmasuk_id']).trigger('change');
                    $('#biayamasuk_id_edit').val(data['biayamasuk_id']).trigger('change');


                    $('#provinsi_e').val(data.provinsi_id).trigger('change');

                    loadKabupaten(data.provinsi_id, function() {
                        $('#kabupaten_e').val(data.kabupaten_id);

                        loadKecamatan(data.kabupaten_id, function() {
                            $('#kecamatan_e').val(data.kecamatan_id);
                            console.log(data.kecamatan_id)
                        })
                    })

                    KAB_ID = data.kabupaten_id;
                    KEC_ID = data.kecamatan_id;
                }
            })

            $('#form-edit-mahasiswa').attr('action', '{{ route('mahasiswa.index') }}' + '/' + id_mhs);
            $('#modal-edit').modal('show');

        }

        function delete_mhs(e, id_mhs) {
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
                var url = '/master/mahasiswa/' + id_mhs;
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
                        swal("Error", "Terjadi kesalahan sistem. Silakan hubungi pihak terkait",
                            "error");
                    }
                })
            });
        }

        function get_binat_by_prodi(id, tag_target) {
            var url = '{{ route('bidang-minat.index') }}' + '/prodi/' + id;
            var binat_list = '';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        binat_list += '<option value="' + value['bidangminat_id'] + '" >' + value[
                            'nama_bidang'] + '</option>'
                    })

                    $(tag_target).html(binat_list);
                    $(tag_target).removeAttr('disabled');
                }
            })
        }

        function get_dosen_by_prodi(id, tag_target) {
            var url = '{{ route('dosen.index') }}' + '/prodi/' + id;
            var pengampu_list = '';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        pengampu_list += '<option value="' + value['dosen_id'] + '" >' + value[
                            'nama_tercetak'] + '</option>'
                    })

                    $(tag_target).html(pengampu_list);
                    $(tag_target).removeAttr('disabled');
                }
            })
        }

        function get_binat_by_prodi_f(id, tag_target, tag_loading) {
            $(tag_target).empty();
            var url = '{{ route('bidang-minat.index') }}' + '/prodi/' + id;
            var binat_list = '<option value="-">Semua</option>';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        binat_list += '<option value="' + value['bidangminat_id'] + '" >' + value[
                            'nama_bidang'] + '</option>'
                    })

                    $(tag_target).html(binat_list);
                    $(tag_target).removeAttr('disabled');
                    $(tag_loading).hide();

                    var binat_id = {!! json_encode(request()->binat_f, JSON_HEX_TAG) !!};
                    if (binat_id && binat_id != '-') {
                        $('#binat_f').val(binat_id).trigger('change');

                    }
                }



            })
        }

        function get_dosen_by_prodi_f(id, tag_target, tag_loading) {
            $(tag_target).empty();
            var url = '{{ route('dosen.index') }}' + '/prodi/' + id;
            var pa_list = '<option value="-">Semua</option>';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        pa_list += '<option value="' + value['dosen_id'] + '" >' + value[
                            'nama_tercetak'] + '</option>'
                    })

                    $(tag_target).html(pa_list);
                    $(tag_target).removeAttr('disabled');
                    $(tag_loading).hide();

                    var pa_id = {!! json_encode(request()->pa_f, JSON_HEX_TAG) !!};
                    if (pa_id && pa_id != '-') {
                        $('#pa_f').val(pa_id).trigger('change');

                    }
                }
            })
        }

        $('#prodi_id').change(function() {
            var id = $('#prodi_id').val();
            get_binat_by_prodi(id, '#bidangminat');
            get_dosen_by_prodi(id, '#pa_id');

        })

        $('#prodi_id_edit').change(function() {
            var id = $('#prodi_id_edit').val();
            get_binat_by_prodi(id, '#bidangminat_edit');
            get_dosen_by_prodi(id, '#pa_id_edit');

        })

        $('#prodi_f').change(function() {

            // id_provinsi
            var id = $('#prodi_f').val();

            // alert('iseng: ' + id);
            // console.log('iseng: ' + id);
            $('#load-binat_filter').show();
            $('#load-dosen_filter').show();
            get_binat_by_prodi_f(id, '#binat_f', '#load-binat_filter');
            get_dosen_by_prodi_f(id, '#pa_f', '#load-dosen_filter');

        })

        function get_kab_by_prov_id(id, tag_kabupaten_id, tag_loading) {
            var url = '{{ route('kabupaten.index') }}' + '/provinsi/' + id;
            var kabupaten = '<option value="-">Semua</option>';
            // alert(url);
            $.get({
                url: url,
                success: function(data) {
                    // console.log(data);
                    $.each(data, function(key, value) {
                        kabupaten += '<option value="' + value['kabupaten_id'] + '" >' + value[
                            'nama_kabupaten'] + '</option>'
                    })

                    $(tag_kabupaten_id).html(kabupaten);
                    $(tag_kabupaten_id).removeAttr('disabled');
                    $(tag_loading).hide();

                    var kab_id = {!! json_encode(request()->kab_f, JSON_HEX_TAG) !!};
                    if (kab_id && kab_id != '-') {
                        $('#kab_f').val(kab_id).trigger('change');

                    }
                }
            })
        }

        function get_kec_by_kab_id(id, tag_kecamatan_id, tag_loading) {
            var url = '{{ route('kecamatan.index') }}' + '/kabupaten/' + id;
            var kecamatan = '<option value="-">Semua</option>';
            $.get({
                url: url,
                success: function(data) {
                    $.each(data, function(key, value) {
                        kecamatan += '<option value="' + value['kecamatan_id'] + '" >' + value[
                            'nama_kecamatan'] + '</option>'
                    })

                    $(tag_kecamatan_id).html(kecamatan);
                    $(tag_kecamatan_id).removeAttr('disabled');
                    $(tag_loading).hide();

                    var kec_id = {!! json_encode(request()->kec_f, JSON_HEX_TAG) !!};
                    if (kec_id && kec_id != '-') {
                        $('#kec_f').val(kec_id).trigger('change');

                    }
                }
            })
        }

        function get_prodi_by_fak_id(id, tag_prodi_id, tag_loading) {
            var url = '{{ route('prodi.index') }}' + '/fakultas/' + id;
            var prodi_list = '<option value="-">Pilih Prodi</option>';

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

                    var p_id = {!! json_encode(request()->prodi_f, JSON_HEX_TAG) !!};
                    if (p_id && p_id != '-') {
                        $('#prodi_f').val(p_id).trigger('change');

                    }
                }
            })
        }

        $(document).ready(function() {
            var f_id = $('#fak_f').val();
            var tipe = {!! json_encode($tipe) !!};
            var p_id = {!! json_encode($request->prodi_f) !!};
            var prov_id = {!! json_encode($request->prov_f) !!};

            if (f_id && f_id != '-' && tipe == 'admin') {
                $('#load-prodi_filter').show();
                get_prodi_by_fak_id(f_id, '#prodi_f', '#load-prodi_filter');

            }

            if (p_id && p_id != '-' && tipe == 'admin') {
                get_binat_by_prodi_f(p_id, '#binat_f', '#load-binat_filter');
                get_dosen_by_prodi_f(p_id, '#pa_f', '#load-dosen_filter');
            }

            if (prov_id && prov_id != '-') {
                $('#load-kab_filter').show();
                get_kab_by_prov_id(prov_id, '#kab_f', '#load-kab_filter');
            }

        });

        $('#prov_f').change(function() {
            var id = $('#prov_f').val();
            $('#load-kab_filter').show();
            get_kab_by_prov_id(id, '#kab_f', '#load-kab_filter');

        })

        $('#kab_f').change(function() {
            var id = $('#kab_f').val();
            $('#load-kec_filter').show();
            get_kec_by_kab_id(id, '#kec_f', '#load-kec_filter');
        })

        $('#fak_f').change(function() {
            $('#load-prodi_filter').show();
            var id = $('#fak_f').val();
            $('#prodi_f').empty();
            get_prodi_by_fak_id(id, '#prodi_f', '#load-prodi_filter');
        })

        function loadKabupaten(id, callback = null) {
            var option = '<option value="" selected="" disabled=""><< pilih kabupaten >></option>';
            $('select[name=kabupaten_e]').html(load);
            $('select[name=kecamatan_e]').html(
                '<option value="" selected="" disabled=""><< pilih kabupaten terlebih dahulu >></option>')

            $.get({
                url: '/api/kabupaten',
                data: {
                    pid: id
                },
                success: function(data) {
                    if (data['status'] == true) {


                        $.each(data['msg'], function(i, val) {
                            option += '<option value="' + val.kabupaten_id + '">' + val.nama_kabupaten +
                                '</option>';
                        })

                        $('select[name=kabupaten_e]').html(option);

                        if (callback) callback()
                        return;
                    }

                    $('select[name=kabupaten_e]').html(
                        '<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>'
                    );
                },
                error: function() {
                    $('select[name=kabupaten_e]').html(
                        '<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>'
                    );
                }
            });
        }

        $('select[name=provinsi_e]').change(function() {
            var pid = $(this).val();

            loadKabupaten(pid);
        })

        function loadKecamatan(id, callback = null) {
            var option = '<option value="" selected="" disabled=""><< pilih kecamatan >></option>';
            $('select[name=kecamatan_e]').html(load);
            $.get({
                url: '/api/kecamatan',
                data: {
                    kbid: id
                },
                success: function(data) {
                    if (data.status == true) {


                        $.each(data['msg'], function(i, val) {
                            option += '<option value="' + val.kecamatan_id + '">' + val.nama_kecamatan +
                                '</option>';
                        })

                        $('select[name=kecamatan_e]').html(option);

                        if (callback) callback()
                        return;
                    }

                    $('select[name=kecamatan_e]').html(
                        '<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>'
                    );
                },
                error: function() {
                    $('select[name=kecamatan_e]').html(
                        '<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>'
                    );
                }
            });
        }

        $('select[name=kabupaten_e]').change(function() {
            var kbid = $(this).val();
            loadKecamatan(kbid)
        })
    </script>
@endsection
