@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Angkatan
@endsection

@section('page-name')
  Data Angkatan
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Angkatan</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
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
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card card-outline-danger">
      {{-- <div class="card-header">
        <h4 class="m-b-0 text-white">Data Angkatan</h4>
      </div> --}}
      <div class="card-body">
        <div class="table-responsive">
          <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
          
            <table id="table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="30px">#</th>
                  <th>Tahun</th>
                  <th>Semester</th>
                  <th width="20%" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($angkatans as $key => $angkatan)
                  <tr>
                    <td>{{$key+1}}</td>
                    {{-- <td>{{$angkatan->angkatan_id}}</td> --}}
                    <td>{{$angkatan->tahun}}</td>
                    {{-- <td>{{$angkatan->semester_id}}</td> --}}
                    <td>{{($angkatan->semester_id == 1 ? 'Ganjil':'Genap')}}</td>
                    
                    <td class="text-center">
                      <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_angkatan(this, {{$angkatan->angkatan_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_angkatan(this, {{$angkatan->angkatan_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="pull-right">
              {{$angkatans->links()}}
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
          <form class="" id="form-add-angkatan" action="{{route('angkatan.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label for="angkatan" class="control-label">Angkatan Baru</label>
                  
                  <input type="number" class="form-control" id="angkatan" name="angkatan" required="" placeholder="Contoh: 2018">
                  <span class="bar"></span>
              </div>

              <div class="form-group">
                  <label for="input6">Semester</label>
                  <select class="form-control p-0" name="semester" required="">
                    <option value="">Pilih Semester</option>
                    <option value="1">Ganjil</option>
                    <option value="2">Genap</option>
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
          <form class="" id="form-edit-angkatan" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">        
              <input type="text" class="form-control" id="angkatan_id_edit" name="angkatan_id" required="" readonly="" hidden="">                  
              
              <div class="form-group">
                  <label for="angkatan_edit" class="control-label">Tahun Angkatan</label>
                  
                  <input type="number" class="form-control" id="angkatan_edit" name="angkatan_edit" required=""  >
                  <span class="bar"></span>
              </div>

              <div class="form-group">
                  <label for="input6">Semester</label>
                  <select class="form-control p-0" name="semester_edit" required="" id="semester_edit">
                    <option value="">Pilih Semester</option>
                    <option id="smt1" value="1">Ganjil</option>
                    <option id="smt2" value="2">Genap</option>
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
<script src="{{asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script>
// $('#table').DataTable();

function edit_angkatan(e, angkatan_id){
  var id_angkatan = angkatan_id;
  var row = $(e).closest('tr').find('td');
  var angkatan = row[1].innerHTML;
  var semester = row[2].innerHTML;

  smt = (semester == 'Ganjil') ? '1':'2';

  $('#form-edit-angkatan').attr('action', '{{route('angkatan.index')}}' + '/' + id_angkatan);
  $('#angkatan_id_edit').val(id_angkatan);
  $('#angkatan_edit').val(angkatan);
  $('#semester_edit option:selected').removeAttr('selected');
  $('#smt'+smt).attr('selected', '');
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_angkatan(e, angkatan_id){
  var id_angkatan = angkatan_id;
  var row = $(e).closest('tr').find('td');
  var angkatan = row[1].innerHTML;
  var semester = row[2].innerHTML;
  
  swal({   
      title: "Hapus Angkatan "+ angkatan + " - Semester " + semester  +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/angkatan/' + id_angkatan;
      var token = $('input[name=_token]').val();

      $.post({
          url: url,
          data: {
            _token: token,
            _method: 'DELETE'
          },
          success: function(data){
            
            if(data == 'denied') {
              swal("Gagal!", 
                "Angkatan "+ angkatan + " - Semester " + semester + " gagal dihapus karena telah memiliki data mahasiswa", 
                "error")
              return false;
            }
            if(data == 'sukses'){
              swal("Sukses!", 
                "Sukses menghapus Angkatan "+ angkatan + " - Semester " + semester, 
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

</script>
@endsection
