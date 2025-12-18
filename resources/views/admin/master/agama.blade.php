@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Agama
@endsection
@section('page-name')
  Data Agama
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Agama</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
          {{-- <h4 class="card-title">Data Agama</h4> --}}
          <div class="table-responsive">
            <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
            
              <table id="table" class="table table-bordered table-hover">
                  <thead>
                      <tr>
                        <th width="30px">#</th>
                        <th>Agama</th>
                        <th width="20%" class="text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($religions as $key => $religion)
                      <tr>
                        <td>{{$key+1}}</td>
                        {{-- <td>{{$religion->agama_id}}</td> --}}
                        <td>{{$religion->agama}}</td>
                        <td class="text-center">
                          <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_agama(this, {{$religion->agama_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_agama(this, {{$religion->agama_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
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
          <form class="" id="form-add-agama" action="{{route('agama.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20 focus {{ ($errors->has('agama')) ? 'has-danger has-error has-feedback' : ''}}">
                  <label for="agama" class="control-label">Nama Agama atau Kepercayaan:</label>
                  
                  <input type="text" class="form-control" id="agama" name="agama" required="" autofocus" placeholder="-- Masukkan Nama Agama --" value="{{ old('agama') }}">
                  <span class="bar"></span>
                  @if ($errors->has('agama'))
                    <span class="input-error">
                        <strong>{{ $errors->first('agama') }}</strong>
                    </span>
                  @endif
              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
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
          <form class="" id="form-edit-agama" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20 focus" id="edit-input-div">
                  <label for="agama_id_edit" class="control-label">ID:</label>
                  
                  <input type="text" class="form-control" id="agama_id_edit" name="agama_id" required="" readonly="" value="{{ old('agama_id') }}">
                  <span class="bar"></span>

              </div>

              <div class="form-group m-t-20 focus {{ ($errors->has('agama_edit')) ? 'has-danger has-error has-feedback' : ''}}">
                  <label for="agama_edit" class="control-label">Nama Agama atau Kepercayaan:</label>
                  
                  <input type="text" class="form-control" id="agama_edit" name="agama_edit" required="" value="{{ old('agama_edit') }}">
                  <span class="bar"></span>
                  @if ($errors->has('agama_edit'))
                    <span class="input-error">
                        <strong>{{ $errors->first('agama_edit') }}</strong>
                    </span>
                  @endif

              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
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

function edit_agama(e, agama_id){
  var id_agama = agama_id;
  var row = $(e).closest('tr').find('td');
  var agama = row[1].innerHTML;

  $('#form-edit-agama').attr('action', '{{route('agama.index')}}' + '/' + id_agama);
  $('#agama_id_edit').val(id_agama);
  $('#agama_edit').val(agama);
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_agama(e, agama_id){
  var id_agama = agama_id;
  var row = $(e).closest('tr').find('td');
  var agama = row[1].innerHTML;
  
  swal({   
      title: "Hapus "+ agama +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/agama/' + id_agama;
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
                      "Sukses menghapus "+ agama, 
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

@if ($errors->has('agama'))
  insert_error();
@endif

@if ($errors->has('agama_edit'))
  edit_error();
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
