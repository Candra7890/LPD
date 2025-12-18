@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Nilai Kategori
@endsection

@section('page-name')
  Kategori Nilai
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Nilai Kategori</li>
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
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="card card-outline-danger">
      <div class="card-header">
        <h4 class="m-b-0 text-white">Data Nilai Kategori</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
          
            <table id="table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="30px">#</th>
                  <th>Nama Kategori</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($nilaiKategoris as $key => $kategori)
                  <tr>
                    <td>{{$key+1}}</td>
                    {{-- <td>{{$kategori->nilaikategori_id}}</td> --}}
                    <td>{{$kategori->nama_kategori}}</td>
                    <td>
                      <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_kategori(this, {{$kategori->nilaikategori_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_kategori(this, {{$kategori->nilaikategori_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row">
              {{$nilaiKategoris->links()}}
            </div>
        </div>
      </div>
    </div>
    
  </div>
  <div class="col-md-2"></div>
</div>

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-kategori" action="{{route('nilaikategori.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label for="kategori" class="control-label">Kategori Baru</label>
                  
                  <input type="text" class="form-control" id="kategori" name="nama_kategori" required="">
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
          <form class="" id="form-edit-kategori" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" id="kategori_id_edit" name="kategori_id" required="" hidden="" readonly="">
              
              <div class="form-group">
                  <label for="kategori_edit" class="control-label">Kategori</label>
                  
                  <input type="text" class="form-control" id="kategori_edit" name="nama_kategori" required="">
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
// $('#table').DataTable();

function edit_kategori(e, kategori_id){
  var id_kategori = kategori_id;
  var row = $(e).closest('tr').find('td');
  var nama_kategori = row[1].innerHTML;


  $('#form-edit-kategori').attr('action', '{{route('nilaikategori.index')}}' + '/' + id_kategori);
  $('#kategori_id_edit').val(id_kategori);
  $('#kategori_edit').val(nama_kategori);
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_kategori(e, kategori_id){
  var id_kategori = kategori_id;
  var row = $(e).closest('tr').find('td');
  var nama_kategori = row[1].innerHTML;
  
  swal({   
      title: "Hapus Kategori "+ nama_kategori +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/nilaikategori/' + id_kategori;
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
                      "Sukses menghapus kategori "+ nama_kategori, 
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