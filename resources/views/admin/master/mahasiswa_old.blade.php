@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Mahasiswa
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Mahasiswa</li>
@endsection

@section('css')

@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tabel Mahasiswa</h4>
    <div class="table-responsive m-t-40">
      <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm waves-effect waves-light" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</a>
      
        <table id="table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>NIM</th>
              <th>Nama Lengkap</th>
              <th>Angkatan</th>
              <th>Prodi</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($mahasiswas as $key => $mhs)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$mhs->nim}}</td>
                <td>{{$mhs->nama}}</td>
                <td>{{$mhs->angkatan->tahun}}</td>
                <td>{{$mhs->prodi->nama_prodi}}</td>
                <td>{{$mhs->statusaktif->status}}</td>
                <td>
                  <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" onclick="view_mhs({{$mhs->nim}})" data-toggle="tooltip" title="Lihat Mahasiswa"><i class="fa fa-eye"></i></button>
                  <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_angkatan({{$key+1}})" data-toggle="tooltip" title="Sunting Mahasiswa"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_angkatan({{$key+1}})" data-toggle="tooltip" title="Hapus Mahasiswa"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
</div>


{{-- modal view --}}
<div id="modal-view" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="floating-labels" id="form-edit-angkatan" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Lihat Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs customtab" role="tablist">
                  <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Data Pribadi</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#studi" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Data Studi</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Data Tempat Tinggal</span></a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Data Keluarga</span></a> </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content" id="view-mhs">
                  <div class="tab-pane active" id="home2" role="tabpanel">
                      <div class="p-20">
                        <div class="loading m-t-20" style="position: relative;">
                            <svg class="circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                        </div>
                        <div class="data-mhs" style="display: none;">
                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="nim_view" name="nim_view" required=""  value="1" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">NIM</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="nik_view" name="nik_view" required=""  value="1" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">NIK</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="nama_lengkap_view" name="nama_lengkap_view" required=""  value="1" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Nama Lengkap</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="tgl_lahir_view" name="tgl_lahir_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Tanggal Lahir</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="tmp_lahir_view" name="tmp_lahir_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Tempat Lahir</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="telepon_view" name="telepon_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Telepon</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="email_view" name="email_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Email</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="agama_view" name="agama_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Agama</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="jk_view" name="jk_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Jenis Kelamin</label>
                              
                          </div>

                          <div class="form-group m-t-20 focus">
                  
                            <input type="text" class="form-control" id="darah_view" name="darah_view" required=""  value="1/1/2018" readonly="">
                            <span class="bar"></span>
                            <label for="" class="control-label">Golongan Darah</label>
                              
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="tab-pane  p-20" id="studi" role="tabpanel">
                    <div class="loading m-t-20" style="position: relative;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                    </div>

                    <div class="data-mhs" style="display: none;">
                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="tercetak_view" name="tercetak_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Nama Tercetak</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="angkatan_view" name="angkatan_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Angkatan</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="prodi_view" name="prodi_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Program Studi</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="jenjang_view" name="jenjang_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Jenjang Program Studi</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="program_view" name="program_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Program</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="binat_view" name="binat_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Bidang Minat</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="fakultas_view" name="fakultas_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Fakultas</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="pa_view" name="pa_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Pembimbing Akademik</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="status_view" name="status_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Status</label>
                          
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane  p-20" id="profile2" role="tabpanel">
                    <div class="loading m-t-20" style="position: relative;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                    </div>

                    <div class="data-mhs" style="display: none;">
                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="asal_view" name="asal_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Alamat Asal</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="kecamatan_view" name="kecamatan_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Kecamatan</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="kabupaten_view" name="kabupaten_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Kabupaten</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="provinsi_view" name="provinsi_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Provinsi</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="tinggal_view" name="tinggal_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Alamat Tinggal</label>
                          
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane p-20" id="messages2" role="tabpanel">
                    <div class="loading m-t-20" style="position: relative;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                    </div>

                    <div class="data-mhs" style="display: none;">
                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="ayah_view" name="ayah_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Nama Ayah</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="ibu_view" name="ibu_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Nama Ibu</label>
                          
                      </div>

                      <div class="form-group m-t-20 focus">
                  
                        <input type="text" class="form-control" id="telp_rmh_view" name="telp_rmh_view" required=""  value="1/1/2018" readonly="">
                        <span class="bar"></span>
                        <label for="" class="control-label">Telepon Rumah/Wali</label>
                          
                      </div>
                    </div>
                  </div>
              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
    </div>
</div>
{{-- modal view --}}

{{-- modal edit --}}
<div id="modal-edit" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
          <form class="floating-labels" id="form-edit-angkatan" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20 focus">
                  
                  <input type="text" class="form-control" id="angkatan_id_edit" name="angkatan_id" required=""  value="{{ old('angkatan_id') }}" readonly="">
                  <span class="bar"></span>
                  <label for="angkatan_id" class="control-label">ID:</label>
                  
              </div>

              <div class="form-group m-t-20 focus {{ ($errors->has('angkatan_edit')) ? 'has-danger has-error has-feedback' : ''}}">
                  
                  <input type="number" class="form-control" id="angkatan_edit" name="angkatan_edit" required="" autofocus" value="{{ old('angkatan_edit') }}">
                  <span class="bar"></span>
                  <label for="angkatan_edit" class="control-label">Tahun Angkatan:</label>
                  @if ($errors->has('angkatan_edit'))
                    <span class="input-error">
                        <strong>{{ $errors->first('angkatan_edit') }}</strong>
                    </span>
                  @endif
              </div>

              <div class="form-group m-t-20 focus">
                  <select class="form-control p-0" name="semester_edit" required="" id="semester_edit">
                    <option value=""></option>
                    <option id="smt1" value="1">1</option>
                    <option id="smt2" value="2">2</option>
                  </select><span class="bar"></span>
                  <label for="input6">Semester:</label>
              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
            </div>
          </form>
        </div>
    </div>
</div>
{{-- modal edit --}}

{{-- modal delete --}}
<div id="modal-delete" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="floating-labels" id="form-delete-angkatan" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <div class="modal-header">
              <h4 class="modal-title">Hapus Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div id="delete-msg">
                 
              </div>                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
            </div>
          </form>
        </div>
    </div>
</div>
{{-- modal delete --}}


@endsection

@section('js')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script type="text/javascript">
  $('#table').DataTable();

function view_mhs(id){
  $('.loading').attr('style', 'position: relative;')
  $('.data-mhs').attr('style', 'display:none;');
  var url = "{{ route('mahasiswa.index') }}/" + id;

  $.ajax({
    type: 'get',
    url: url,
    success: function(data){
      // insert data pribadi
      $('#nim_view').val(data['nim']);
      $('#nama_lengkap_view').val(data['nama']);
      var dateObject = new Date(Date.parse(data['tanggal_lahir']));
      var dateReadable = dateObject.toDateString();
      $('#tgl_lahir_view').val(dateReadable);
      $('#tmp_lahir_view').val(data['tempat_lahir']);
      $('#telepon_view').val(data['alamat_asal_telepon']);
      $('#email_view').val(data['email']);
      $('#agama_view').val(data['agama']['agama']);
      $('#jk_view').val(data['kelamin_id']);
      $('#darah_view').val(data['goldarah_id']);


      // insert data studi
      $('#tercetak_view').val(data['nama_tercetak']); 
      $('#angkatan_view').val(data['angkatan']['tahun']); 
      $('#prodi_view').val(data['prodi']['nama_prodi']); 
      $('#jenjang_view').val(data['jenjang']['jenjang']); 
      $('#program_view').val(data['program']['nama_program']); 
      $('#binat_view').val(data['binat']['nama_bidang']); 
      $('#fakultas_view').val(data['fakultas']['nama_fakultas']); 
      $('#pa_view').val(data['pa']['nama']); 
      $('#status_view').val(data['statusaktif']['status']); 

      // insert data tempat tinggal
      $('#asal_view').val(data['alamat_asal']); 
      $('#kecamatan_view').val(data['kecamatan']['nama_kecamatan']);
      $('#kabupaten_view').val(data['kabupaten']['nama_kabupaten']);
      $('#provinsi_view').val(data['provinsi']['nama_provinsi']);
      $('#tinggal_view').val(data['alamat_tinggal']);

      // insert data keluarga
      $('#ayah_view').val(data['nama_ayah']); 
      $('#ibu_view').val(data['nama_ibu']);
      $('#telp_rmh_view').val(data['alamat_tinggal_telepon']);


      $('.loading').attr('style', 'display: none;')
      $('.data-mhs').attr('style', '');
    }

  })
  $('#modal-view').modal('show');
}

function edit_angkatan(id){
  var id_angkatan = $('#table tr').eq(id).find('td').eq(1).html();
  var angkatan = $('#table tr').eq(id).find('td').eq(2).html();
  var semester = $('#table tr').eq(id).find('td').eq(3).html();


  $('#form-edit-angkatan').attr('action', '{{route('angkatan.index')}}' + '/' + id_angkatan);
  $('#angkatan_id_edit').val(id_angkatan);
  $('#angkatan_edit').val(angkatan);
  $('#semester_edit option:selected').removeAttr('selected');
  $('#smt'+semester).attr('selected', '');
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_angkatan(id){
  var id_angkatan = $('#table tr').eq(id).find('td').eq(1).html();
  var angkatan = $('#table tr').eq(id).find('td').eq(2).html();
  var semester = $('#table tr').eq(id).find('td').eq(3).html();
  
  $('#form-delete-angkatan').attr('action', '{{route('angkatan.index')}}' + '/' + id_angkatan);
  $('#angkatan_delete').val(angkatan);
  $('#semester_delete').val(semester);

  var msg = 'Apakah anda yakin ingin menghapus <b>Angkatan ' + angkatan + ' Semester ' + semester + '</b>?';
  $('#delete-msg').html(msg);
  $('#modal-delete').modal('show');
}

@if ($errors->has('angkatan'))
  insert_error();
@endif


@if ($errors->has('angkatan_edit'))
  edit_error();
  var id_angkatan = $('#angkatan_id_edit').val();
  $('#form-edit-angkatan').attr('action', '{{route('angkatan.index')}}' + '/' + id_angkatan);
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

@section('js')

@endsection
