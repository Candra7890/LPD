@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Pegawai
@endsection

@section('page-name')
  Data Pegawai
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Pegawai</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('/assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <style type="text/css">
        th, td { white-space: nowrap; }
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
@if(session()->has('insert'))
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
      {{-- <form class="" action="{{route('pegawai.index')}}" method="get" id="form-filter"> --}}
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
                            @foreach($faks as $fak)
                              <option {{($fak->fakultas_id == $request->fak_f ? 'selected':'')}} value="{{$fak->fakultas_id}} ">{{$fak->nama_fakultas}}</option>
                                                    
                            @endforeach
                            
                        </select>

                      </div>
                    </div>

                    <div class="row mt-1">
                      <div class="col-md-4">
                        <label>Program Studi</label>
                        <span style="padding-right:3px; padding-top: 3px;">
                          <img id="load-prodi_filter" src="{{ asset('assets/images/loading-20px.gif')}}" style="display: none;"></img>
                        </span>
                      </div>
                      <div class="col-md-6">
                        <select class="select2 form-control custom-select" name="prodi_f" id="prodi_f" required="">
                           @if ($tipe == 'admin')
                            <option value="-">Semua</option>
                          @elseif ($tipe == 'operator')
                            @foreach ($prodis as $prodi)
                              <option {{($prodi->prodi_id == $request->prodi_f ? 'selected':'')}} value="{{ $prodi->prodi_id }}">{{$prodi->jenjangprodi->jenjang.' '.$prodi->nama_prodi}}</option>
                            @endforeach
                          
                          @endif
                        </select>
                      </div>
                    </div>

                    <div class="row mt-1">
                      <div class="col-md-4">
                        <label>Jenis Kelamin</label>
                      </div>
                      <div class="col-md-6">
                          <select class="select2 form-control custom-select" name="gender_f" id="gender_f" required="" >
                          <option value="-">Semua</option>
                          <option {{('Pria' == $request->gender_f ? 'selected':'')}} value="Pria">Pria</option>
                          <option {{('Wanita' == $request->gender_f ? 'selected':'')}} value="Wanita">Wanita</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-md-4">
                        <select class="form-control custom-select" name="cari_f" required="" >
                          <option value="-">Cari</option>
                          <option {{($request->cari_f == 'nama' ? 'selected':'')}} value="nama">Nama</option>
                          <option {{($request->cari_f == 'nip' ? 'selected':'')}} value="nip">NIP</option>
                          <option {{($request->cari_f == 'nidn' ? 'selected':'')}} value="nidn">NIDN</option>
                          <option {{($request->cari_f == 'alamat' ? 'selected':'')}} value="alamat">Alamat</option>
                          <option {{($request->cari_f == 'telepon' ? 'selected':'')}} value="telepon">Telepon</option>
                          <option {{($request->cari_f == 'ktp' ? 'selected':'')}} value="ktp">Nomor KTP</option>
                        </select>
                      </div>
                      <div class="col-md-5">
                          <input type="text" class="form-control" name="keterangan_f" value="{{$request->keterangan_f}}" required="">
                        
                      </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="row mt-1">
                      <div class="col-md-4">
                        <label>Agama</label>
                      </div>
                      <div class="col-md-6">
                          <select class="select2 form-control custom-select" name="agama_f" id="agama_f" required="" >
                          <option value="-">Semua</option>
                          @foreach ($agamas as $agama)
                            <option {{($agama->agama_id == $request->agama_f ? 'selected':'')}} value="{{$agama->agama_id}}">{{$agama->agama}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row mt-1">
                      <div class="col-md-4">
                        <label>Jenis</label>
                      </div>
                      <div class="col-md-6">
                          <select class="select2 form-control custom-select" name="jenis_f" id="jenis_f" required="" >
                          <option value="-">Semua</option>
                          @foreach ($jenisdosens as $jenis)
                            <option {{($jenis->jenisdosen_id == $request->jenis_f ? 'selected':'')}} value="{{$jenis->jenisdosen_id}}">{{$jenis->jenis}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row mt-1">
                      <div class="col-md-4">
                        <label>Golongan Darah</label>
                      </div>
                      <div class="col-md-6">
                          <select class="select2 form-control custom-select" name="goldar_f" id="goldar_f" required="" >
                          <option value="-">Semua</option>
                            <option {{('A' == $request->goldar_f ? 'selected':'')}} value="A">A</option>
                            <option {{('B' == $request->goldar_f ? 'selected':'')}} value="B">B</option>
                            <option {{('AB' == $request->goldar_f ? 'selected':'')}} value="AB">AB</option>
                            <option {{('O' == $request->goldar_f ? 'selected':'')}} value="O">O</option>
                        </select>
                      </div>
                    </div>
                </div>
              
            </div>
            
                        
            <hr>
              <div class="row">
                <div class="col-md-2">
                  <div class="demo-checkbox">
                    <input type="checkbox" id="check1" class="filled-in chk-col-red" name="check[]" value="nama_tercetak" checked />
                    <label for="check1">Nama</label>

                    <input type="checkbox" id="check2" class="filled-in chk-col-red" name="check[]" value="nama_prodi" checked />
                    <label for="check2">Prodi</label>

                    <input type="checkbox" id="check3" class="filled-in chk-col-red" name="check[]" value="nama_fakultas"  />
                    <label for="check3">Fakultas</label>

                  </div>
                </div>
                <div class="col-md-2">
                  <div class="demo-checkbox">
                    <input type="checkbox" id="check6" class="filled-in chk-col-red" name="check[]" value="jenis" />
                    <label for="check6">Jenis Pegawai</label>

                    <input type="checkbox" id="check7" class="filled-in chk-col-red" name="check[]" value="goldarah_id" />
                    <label for="check7">Golongan Darah</label>

                    <input type="checkbox" id="check8" class="filled-in chk-col-red" name="check[]" value="nip" />
                    <label for="check8">NIP</label>

                  </div>
                </div>
                <div class="col-md-2">
                  <div class="demo-checkbox">
                    <input type="checkbox" id="check11" class="filled-in chk-col-red" name="check[]" value="email" />
                    <label for="check11">Email</label>

                    <input type="checkbox" id="check12" class="filled-in chk-col-red" name="check[]" value="telepon" />
                    <label for="check12">Telepon</label>

                    <input type="checkbox" id="check13" class="filled-in chk-col-red" name="check[]" value="tempat_lahir" />
                    <label for="check13">Tempat Lahir</label>

                  </div>
                </div>
                <div class="col-md-2">
                  <div class="demo-checkbox">
                    <input type="checkbox" id="check4" class="filled-in chk-col-red" name="check[]" value="kelamin_id"  />
                    <label for="check4">Jenis Kelamin</label>
                  
                    <input type="checkbox" id="check5" class="filled-in chk-col-red" name="check[]" value="agama"  />
                    <label for="check5">Agama</label>

                    <input type="checkbox" id="check9" class="filled-in chk-col-red" name="check[]" value="nidn"  />
                    <label for="check9">NIDN</label>              

                  </div>
                </div>
                <div class="col-md-2">
                  <div class="demo-checkbox">
                    <input type="checkbox" id="check10" class="filled-in chk-col-red" name="check[]" value="alamat" />
                    <label for="check10">Alamat</label>

                    <input type="checkbox" id="check14" class="filled-in chk-col-red" name="check[]" value="tanggal_lahir"  />
                    <label for="check14">Tanggal Lahir</label>
                  
                    <input type="checkbox" id="check15" class="filled-in chk-col-red" name="check[]" value="no_ktp" />
                    <label for="check15">No KTP</label>
                    

                  </div>
                </div>
                
              </div>
            <div class="form-actions mt-3">
              <button class="btn btn-sm btn-info waves-effect waves-light" type="button" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>

              <button class="btn btn-sm btn-secondary waves-effect waves-light" type="button" id="btn-cawang"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</button>
              
              <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
              
            </div>
        
        </form>
    </div>
</div>


  <div class="card card-outline-danger">
    <div class="card-header">
      <h5 class="m-b-0 text-white">Daftar Pegawai</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        {{-- <a href="print-pegawai{{$parameter}} " class="btn btn-info btn-sm waves-effect waves-light" type="button"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak</a> --}}
        <table id="table" class="table table-bordered table-hover table-sm table-striped" style="width: 100%">
          <thead>
            <tr align="center">
              <th width="30px">#</th>
              <th>NIP</th>
              <th>NIDN</th>
              <th>Nama</th>
              <th>Prodi</th>
              <th>Fakultas</th>
              <th>Gender</th>

              <th>Agama</th>
              <th>Jenis Pegawai</th>
              <th>Goldar</th>
              <th>Alamat</th>
              <th>Email</th>
              <th>Telepon</th>
              <th>TTL</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pegawais as $key => $pegawai)
              <tr align="center">
                <td>{{$key+1}}</td>
                <td>{{$pegawai->nip}}</td>
                <td>{{$pegawai->nidn}}</td>
                <td>{{$pegawai->nama_tercetak}}</td>
                <td>{{$pegawai->prodi->nama_prodi ?? ''}}</td>
                <td>{{$pegawai->fakultas->nama_fakultas ?? ''}}</td>
                <td>{{$pegawai->kelamin_id}}</td>

                <td>{{  $pegawai->agama->agama ?? 'belum diset'}}</td>
                <td>{{ $pegawai->jenisdosen->jenis ?? 'belum diset' }}</td>
                <td>{{$pegawai->goldarah_id}}</td>
                <td>{{$pegawai->alamat}}</td>
                <td>{{$pegawai->email}}</td>
                <td>{{$pegawai->telepon}}</td>
                <td>{{$pegawai->tempat_lahir}}, {{ $pegawai->tanggal_lahir}}</td>

                <td>
                  <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_dosen(this, {{($pegawai->pegawai_id).','.($pegawai->prodi_id)}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_dosen(this, {{($pegawai->pegawai_id)}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <div class="pull-right mt-2">
        {{$pegawais->links()}}
      </div>

    </div>
  </div>
  

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="" id="form-add-pegawai" action="{{route('pegawai.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Nama Prodi</label>
                  <select class="select2 form-control custom-select" style="width: 100%" name="prodi_id" id="prodi_id" required="">
                    @if ($tipe == 'operator')
                      @foreach ($prodis as $prodi)
                        <option {{($prodi->prodi_id == $request->prodi_f ? 'selected':'')}} value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi}}</option>
                      @endforeach
                    @else
                      <option value="">Pilih Prodi</option>
                      @foreach ($faks as $fak)
                        <optgroup label="Fakultas {{$fak->nama_fakultas}}">
                          @foreach ($fak->prodi as $prodi)
                            <option value={{$prodi->prodi_id}}>{{$prodi->nama_prodi}}</option>
                          @endforeach
                        </optgroup>
                      @endforeach
                    @endif
                  </select>
                  
                </div>
                <div class="form-group col-md-6">
                  <label>Jenis Pegawai</label>
                  <select class="form-control" name="jenis_pegawai" id="jenis_pegawai" required="">
                    @foreach ($jenisdosens as $jenisdosen)
                      <option value="{{$jenisdosen->jenisdosen_id}}">{{$jenisdosen->jenis}}</option>
                    @endforeach                  
                  </select>
                </div>
                
              </div>

              <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nomor KTP</label>
                    <input type="number" class="form-control" id="ktp" name="ktp" required="">    
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">NIDN</label>
                    <input type="text" class="form-control" id="nidn" name="nidn">
                </div>                
              </div>

              <div class="form-group">
                  <label class="control-label">Nama Pegawai</label>
                  <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required="">       
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Gelar Depan</label>
                    <input type="text" class="form-control" id="gelar_depan" name="gelar_depan">       
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label">Gelar Belakang</label>
                    <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang">    
                </div>
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
                      <option value="{{$agama->agama_id}}">{{$agama->agama}}</option>
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

              <div class="form-group m-t-20">
                  <label class="control-label">Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat" required=""></textarea>
              </div>

              <div class="row">
                
                <div class="form-group col-md-4">
                    <label class="control-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required="">    
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label">Telepon</label>
                    <input type="number" class="form-control" id="telepon" name="telepon" required="">    
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
          <form class="" id="form-edit-pegawai" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Nama Prodi</label>
                  <select class="select2 form-control custom-select" style="width: 100%" name="prodi_id" id="prodi_id_edit" required="">
                    @if ($tipe == 'operator')
                      @foreach ($prodis as $prodi)
                        <option {{($prodi->prodi_id == $request->prodi_f ? 'selected':'')}} value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi}}</option>
                      @endforeach
                    @else
                      @foreach ($faks as $fak)
                        <optgroup label="Fakultas {{$fak->nama_fakultas}}">
                          @foreach ($fak->prodi as $prodi)
                            <option value={{$prodi->prodi_id}}>{{$prodi->nama_prodi}}</option>
                          @endforeach
                        </optgroup>
                      @endforeach
                    @endif
                  </select>
                  
                </div>
                <div class="form-group col-md-6">
                  <label>Jenis</label>
                  <select class="form-control" name="jenis_pegawai" id="jenis_pegawai_edit" required="">
                    @foreach ($jenisdosens as $jenisdosen)
                      <option value="{{$jenisdosen->jenisdosen_id}}">{{$jenisdosen->jenis}}</option>
                    @endforeach                  
                  </select>
                </div>
                
              </div>

              <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Nomor KTP</label>
                    <input type="number" class="form-control" id="ktp_edit" name="ktp" required="">    
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">NIP</label>
                    <input type="text" class="form-control" id="nip_edit" name="nip">
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label">NIDN</label>
                    <input type="text" class="form-control" id="nidn_edit" name="nidn">
                </div>                
              </div>

              <div class="form-group m-t-20">
                  <label class="control-label">Nama Pegawai</label>
                  <input type="text" class="form-control" id="nama_pegawai_edit" name="nama_pegawai" required="">       
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Gelar Depan</label>
                    <input type="text" class="form-control" id="gelar_depan_edit" name="gelar_depan">       
                </div>

                <div class="form-group col-md-6">
                    <label class="control-label">Gelar Belakang</label>
                    <input type="text" class="form-control" id="gelar_belakang_edit" name="gelar_belakang">    
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-4">
                    <label class="control-label">Tempat / Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir_edit" name="tempat_lahir">    
                </div>

                <div class="form-group col-md-4">
                    <label>.</label>
                    <input type="date" class="form-control" id="tgl_lahir_edit" name="tgl_lahir">    
                </div>
              </div>    
              <div class="row">
                <div class="form-group col-md-4">
                  <label>Jenis Kelamin</label>
                  <select class="form-control" name="gender" id="gender_edit">
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                  </select>
                </div>                
                <div class="form-group col-md-4">
                  <label>Agama</label>
                  <select class="form-control" name="agama" id="agama_edit">
                    @foreach ($agamas as $agama)
                      <option value="{{$agama->agama_id}}">{{$agama->agama}}</option>
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

              <div class="form-group m-t-20">
                  <label class="control-label">Alamat</label>
                  <textarea class="form-control" id="alamat_edit" name="alamat"></textarea>
              </div>

              <div class="row">
                
                <div class="form-group col-md-4">
                    <label class="control-label">Email</label>
                    <input type="email" class="form-control" id="email_edit" name="email">    
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label">Telepon</label>
                    <input type="number" class="form-control" id="telepon_edit" name="telepon">    
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

@endsection

@section('js')
<script src="{{asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script>
// $('#table').DataTable();
$('.select2').select2();

function edit_dosen(e, id_pegawai, id_prodi){
  var row = $(e).closest('tr').find('td');
  var nip = row[1].innerHTML;
  var nidn = row[2].innerHTML;
  var nama_tercetak = row[3].innerHTML;
  var gender = row[6].innerHTML;

  $('#prodi_id_edit').val(id_prodi).trigger('change');  
  $('#gender_edit').val(gender).trigger('change');

  $('#nama_pegawai_edit').val('');
  $('#gelar_depan_edit').val('');
  $('#gelar_belakang_edit').val('');
  $('#alamat_edit').val('');
  $('#email_edit').val('');
  $('#telepon_edit').val('');
  $('#tempat_lahir_edit').val('');
  $('#tgl_lahir_edit').val('');
  $('#ktp_edit').val('');
  $('#nip_edit').val('');
  $('#nidn_edit').val('');

  $.get({
    url: '{{route('pegawai.index')}}' + '/pegawaiid/' + id_pegawai,
    success: function(data){
      console.log(data);

      $('#nama_pegawai_edit').val(data['nama']);
      $('#gelar_depan_edit').val(data['gelar_depan']);
      $('#gelar_belakang_edit').val(data['gelar_belakang']);
      $('#alamat_edit').val(data['alamat']);
      $('#jenis_edit').val(data['jenispegawai_id']).trigger('change');
      $('#email_edit').val(data['email']);
      $('#telepon_edit').val(data['telepon']);
      $('#tempat_lahir_edit').val(data['tempat_lahir']);
      $('#tgl_lahir_edit').val(data['tanggal_lahir']);
      $('#agama_edit').val(data['agama_id']).trigger('change');
      $('#goldar_edit').val(data['goldarah_id']).trigger('change');
      $('#ktp_edit').val(data['no_ktp']);
      $('#nip_edit').val(data['nip']);
      $('#nidn_edit').val(data['nidn']);    
            

    }
  })

  $('#form-edit-pegawai').attr('action', '{{route('pegawai.index')}}' + '/' + id_pegawai);
  $('#modal-edit').modal('show');

}

function delete_dosen(e, id_pegawai){
  var row = $(e).closest('tr').find('td');
  var nama = row[3].innerHTML;

  swal({   
      title: "Hapus "+ nama +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/pegawai/' + id_pegawai;
      var token = $('input[name=_token]').val();

      $.post({
          url: url,
          data: {
            _token: token,
            _method: 'DELETE'
          },
          success: function(data){
              if(data == 'sukses'){
                  swal("Sukses!", 
                      "Sukses menghapus "+ nama, 
                      "success")
                   location.reload();
              }
          },
          error: function(){
              swal("Error", "Terjadi kesalahan sistem. Silakan hubungi pihak terkait", "error"); 
          }
      })
      }
  );
}


$('#btn-tampilkan').click(function(){
  $('#form-filter').attr('action', '{{route('pegawai.index')}}');
  $('#form-filter').attr('method', 'get');
  $('#form-filter').submit();
})

$('#btn-cawang').click(function(){
  $('#form-filter').attr('action', '{{route('pegawai_print')}}');
  $('#form-filter').attr('method', 'post');
  $('#form-filter').submit();
})

$(document).ready(function() {
    var f_id = $('#fak_f').val();
    var tipe = {!! json_encode($tipe) !!};
    
    if (f_id != '-' && tipe == 'admin') {
      $('#load-prodi_filter').show();
      get_prodi_by_fak_id(f_id, '#prodi_f', '#load-prodi_filter');
      
    }

});

function get_prodi_by_fak_id(id, tag_prodi_id, tag_loading){
  var url = '{{route('prodi.index')}}' + '/fakultas/' + id;
  var prodi_list = '<option value="-">Semua</option>';

  // alert(url);
  $.get({
    url:url,
    success: function(data){
      // console.log(data);
      $.each(data, function(key, value){
        prodi_list += '<option value="'+ value['prodi_id'] +'" >'+ value['nama_prodi'] +'</option>'
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

$('#fak_f').change(function(){
  $('#load-prodi_filter').show();
  var id = $('#fak_f').val();
  $('#prodi_f').empty();
  get_prodi_by_fak_id(id, '#prodi_f', '#load-prodi_filter');
})

</script>
@endsection