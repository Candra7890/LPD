@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Fakultas 
@endsection

@section('page-name')
  Data Fakultas 
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Fakultas</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
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
  <div class="col-md-1"></div>
  <div class="col-md-12">
    <div class="card card-outline-danger">
      {{-- <div class="card-header">
        <h4 class="m-b-0 text-white">Daftar Fakultas</h4>
      </div> --}}
      <div class="card-body">
        <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="btn-label"><i class="mdi mdi-printer"></i></span>Cetak
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="print-fakultas">Cetak PDF</a>
            </div>
        </div>
        
          <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="30px">#</th>
                  <th>Nama Fakultas </th>
                  <th width="10">Kode</th>
                  <th>Nama Dekan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($fakultases as $key => $fak)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$fak->nama_fakultas}}</td>
                    <td>{{ $fak->kode_fakultas }}</td>
                    <td>{{$fak->dekan->nama_tercetak}}</td>
                    <td>
                      <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_fak(this, {{$fak->fakultas_id}}, {{$fak->dekan_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_fak(this, {{$fak->fakultas_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                      
                      <div class="btn-group">
                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-eye"></i>
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="prodi?fakultas_id_filter={{$fak->fakultas_id}} ">Cari Prodi</a>
                          </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row">
              {{$fakultases->links()}}
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-1"></div>
  
</div>

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-fakultas" action="{{route('fakultas.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group ">
                  <label for="fakultas" class="control-label">Fakultas</label>
                  
                  <input type="text" class="form-control" id="fakultas" name="nama_fakultas" required="" placeholder="Contoh: Teknik">
                  <span class="bar"></span>
              </div>

              <div class="form-group ">
                  <label for="fakultas" class="control-label">Kode Fakultas </label>
                  
                  <input type="text" class="form-control" id="kode_fakultas" name="kode_fakultas" required="" placeholder="Contoh: 01">
                  <span class="bar"></span>
              </div>

              <div class="form-group ">
                  <label class="control-label">Dekan</label>
                  
                  <!-- <select class="form-control select2" name="dekan" required=""> -->
                  <select class="select2 form-control custom-select" style="width: 100%" name="dekan_id" required="">
                    <option value="">Pilih Dekan</option>
                    @foreach ($dekans as $dekan)
                      <option value="{{$dekan->dosen_id}}">{{$dekan->nama_tercetak}}</option>
                    @endforeach                  
                  </select>
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
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-edit-fakultas" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">  
              <input type="text" class="form-control" id="fakultas_id_edit" name="fakultas_id" required="" readonly="" hidden="">
              
              <div class="form-group ">
                  <label for="fakultas_edit" class="control-label">Fakultas </label>
                  
                  <input type="text" class="form-control" id="fakultas_edit" name="nama_fakultas" required="" >
                  <span class="bar"></span>
                  
              </div>

              <div class="form-group ">
                  <label for="fakultas_edit" class="control-label">Kode Fakultas</label>
                  
                  <input type="text" class="form-control" id="kode_fakultas_edit" name="kode_fakultas" required="" >
                  <span class="bar"></span>
                  
              </div>

              <div class="form-group ">
                  <label class="control-label">Dekan</label>
                  
                  <select class="select2 form-control custom-select" style="width: 100%" name="dekan_id" id="dekan_id_edit" required="">
                    <option value="">Pilih Dekan</option>
                    @foreach ($dekans as $dekan)
                      <option value="{{$dekan->dosen_id}}">{{$dekan->nama_tercetak}}</option>
                    @endforeach                  
                  </select>
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
$('#table').DataTable();
$('.select2').select2();

function edit_fak(e, fakultas_id, dekan_id){
  var id_fak = fakultas_id;
  var row = $(e).closest('tr').find('td');
  var nama_fakultas = row[1].innerHTML;
  let kode = row[2].innerHTML;

  $('#form-edit-fakultas').attr('action', '{{route('fakultas.index')}}' + '/' + id_fak);
  $('#fakultas_id_edit').val(id_fak);
  $('#fakultas_edit').val(nama_fakultas);
  $('#kode_fakultas_edit').val(kode);
  $('#dekan_id_edit').val(dekan_id).trigger('change');  
  $('#modal-edit').modal('show');

}

function delete_fak(e, fakultas_id){
  var id_fak = fakultas_id;
  var row = $(e).closest('tr').find('td');
  var nama_fakultas = row[1].innerHTML;

  swal({   
    title: "Hapus "+ nama_fakultas +"?",   
    text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
    type: "warning",   
    showCancelButton: true, 
    cancelButtonText: 'Batal',
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Ya, Hapus!",   
    closeOnConfirm: true 
  },function(){
      var url = '/master/fakultas/' + id_fak;
      var token = $('input[name=_token]').val();

      $.post({
        url: url,
        data: {
          _token: token,
          _method: 'DELETE'
        },
        success: function(data){
          if(data == 'prodi_exist'){
            swal("Gagal!", 
              "Fakultas "+ nama_fakultas +" tidak dapat dihapus karena telah memiliki program studi.", 
              "error")
            return false;
          }

          if(data == 'sukses'){
            swal("Sukses!", 
              "Sukses menghapus "+ nama_fakultas, 
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