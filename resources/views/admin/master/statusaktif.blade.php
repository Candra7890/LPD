@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Status Aktif
@endsection

@section('page-name')
  Data Status Aktif
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Status Aktif</li>
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
        <h4 class="m-b-0 text-white">Daftar Status Aktif</h4>
      </div> --}}
      <div class="card-body">
        <div class="table-responsive">
          <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
            <table id="table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="20%">#</th>
                  <th>Nama Status</th>
                  <th width="20%" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($statusaktifs as $key => $data)
                  <tr>
                    <td>{{$key+1}}</td>
                    {{-- <td>{{$data->statusaktif_id}}</td> --}}
                    <td>{{$data->status}}</td>
                    <td class="text-center">
                      <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_status(this, {{$data->statusaktif_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_status(this, {{$data->statusaktif_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
  
  </div>
</div>

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-status" action="{{route('statusaktif.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label for="status" class="control-label">Status Baru</label>
                  
                  <input type="text" class="form-control" id="status" name="nama_status" required="" placeholder="Contoh: Aktif">
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
          <form class="" id="form-edit-status" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">        
              <input type="text" class="form-control" id="status_id_edit" name="status_id" required="" readonly="" hidden="">
                
              <div class="form-group">
                  <label for="status_edit" class="control-label">Status</label>
                  
                  <input type="text" class="form-control" id="status_edit" name="nama_status" required="">
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
<script src="{{asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script>
$('#table').DataTable();

function edit_status(e, status_id){
  var id_status = status_id;
  var row = $(e).closest('tr').find('td');
  var nama_status = row[1].innerHTML;


  $('#form-edit-status').attr('action', '{{route('statusaktif.index')}}' + '/' + id_status);
  $('#status_id_edit').val(id_status);
  $('#status_edit').val(nama_status);
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_status(e, status_id){
  var id_status = status_id;
  var row = $(e).closest('tr').find('td');
  var nama_status = row[1].innerHTML;
  
  swal({   
      title: "Hapus "+ nama_status +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/statusaktif/' + id_status;
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
                      "Sukses menghapus "+ nama_status, 
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