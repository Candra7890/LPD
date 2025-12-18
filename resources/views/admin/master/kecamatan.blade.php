@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Kecamatan
@endsection
@section('page-name')
  Data Kecamatan
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Kecamatan</li>
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
  <div class="col-md-12">
    <div class="card card-outline-danger">
      <div class="card-header">
        <h5 class="m-b-0 text-white">Filter</h5>
      </div>
        <div class="card-body">
          <form class="" action="{{route('kecamatan.index')}}" method="get" id="form-filter">
            {{-- <form class="" id="form-filter"> --}}
                <div class="row">
                    <div class="col-md-6">  
                      <div class="row mt-1">
                        <div class="col-md-4">
                          <label>Provinsi</label>
                        </div>
                        <div class="col-md-8">
                          <select class="select2 form-control custom-select" style="width: 100%" id="prov_f" name="prov_f">
                              <option value="">Semua</option>
                              @foreach($provinsis as $prov)
                                <option {{($prov->provinsi_id == request()->prov_f ? 'selected':'')}} value="{{$prov->provinsi_id}}">{{$prov->nama_provinsi}}</option>
                                                      
                              @endforeach
                              
                          </select>

                        </div>
                      </div>   
                      <div class="row mt-1">
                        <div class="col-md-4">
                          <label>Kabupaten</label>
                          <span style="padding-right:3px; padding-top: 3px;">
                            <img id="load-kabupaten_filter" src="{{ asset('assets/images/loading-20px.gif')}}" style="display: none;"></img>
                          </span>
                        </div>
                        <div class="col-md-8">
                          <select class="select2 form-control custom-select" style="width: 100%" id="kab_f" name="kab_f">
                              <option value="">Semua</option>
                              
                              
                          </select>

                        </div>
                      </div>     
                      <div class="row mt-1">
                        <div class="col-md-4">
                          <label>Cari Kecamatan</label>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="nama_kec" value="{{request()->nama_kec}}">

                        </div>
                      </div>

                    </div>
                  
                </div>
                                   
                <hr>
                
                <div class="form-actions mt-3">
                  <button class="btn btn-sm btn-info waves-effect waves-light" type="submit" id="btn-tampilkan"><span class="btn-label"><i class="fa fa-search"></i></span>Tampilkan</button>          
                  <button class="btn btn-primary btn-sm waves-effect waves-light pull-right" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>    
                </div>
            </form>
        </div>
    </div>
    
  </div>
  
</div>
<div class="card card-outline-danger">
  <div class="card-header">
    <h4 class="m-b-0 text-white">Daftar Kecamatan</h4>
  </div>
  <div class="card-body">
    <div class="table-responsive m-t-40">
      
        <table id="table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="30px">#</th>
              <th>Nama Kecamatan</th>
              <th>Kabupaten</th>
              <th widht="15%" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kecamatans as $key => $kec)
              <tr>
                <td>{{$key+1}}</td>
                {{-- <td>{{$kec->kecamatan_id}}</td> --}}
                <td>{{$kec->nama_kecamatan}}</td>
                <td>{{$kec->kabupaten->nama_kabupaten}}</td>
                <td  class="text-center">
                  <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_kec(this, {{($kec->kecamatan_id).','.$kec->kabupaten_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_kec(this, {{$kec->kecamatan_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    <div class="pull-right mt-2">
      {{$kecamatans->links()}}
    </div>
  </div>
</div>

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-kecamatan" action="{{route('kecamatan.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20">
                <label for="kabupaten">Kabupaten</label>
                <select class="form-control p-0" name="kabupaten_id" required="">
                  <option value="">-- Pilih Kabupaten --</option>
                  @foreach ($kabupatens as $kab)
                    <option value={{$kab->kabupaten_id}}>{{$kab->nama_kabupaten}}</option>
                  @endforeach
                </select><span class="bar"></span>   
              </div>
              <div class="form-group m-t-20 ">
                  <label for="kecamatan" class="control-label">Kecamatan Baru:</label>
                  
                  <input type="text" class="form-control" id="kecamatan" name="kecamatan" required="" placeholder="-- Masukkan Nama Kecamatan --" >
                  <span class="bar"></span>
                  
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
          <form class="" id="form-edit-kecamatan" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" id="kecamatan_id_edit" name="kecamatan_id" required="" readonly="" hidden="">
              

              <div class="form-group m-t-20">
                <label for="kabupaten">Kabupaten</label>
                <select class="form-control p-0" name="kabupaten_id" required="" id="kabupaten_id_edit">
                  <option value=""></option>
                  @foreach ($kabupatens as $kab)
                    <option value={{$kab->kabupaten_id}} id="kab{{$kab->kabupaten_id}}">{{$kab->nama_kabupaten}}</option>
                  @endforeach
                </select><span class="bar"></span>   
              </div>

              <div class="form-group m-t-20 ">
                  <label for="kecamatan_edit" class="control-label">Kecamatan:</label>
                  
                  <input type="text" class="form-control" id="kecamatan_edit" name="kecamatan" required="" >
                  <span class="bar"></span>
                  
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
// $('#table').DataTable();

function edit_kec(e, kec_id, kab_id){
  var id_kec = kec_id;
  var row = $(e).closest('tr').find('td');
  var nama_kec = row[1].innerHTML;
  var nama_kab = row[2].innerHTML;

  var selected;
  $('#kab'+kab_id).attr('selected', '');


  $('#form-edit-kecamatan').attr('action', '{{route('kecamatan.index')}}' + '/' + id_kec);
  $('#kecamatan_id_edit').val(id_kec);
  $('#kecamatan_edit').val(nama_kec);
  $('#modal-edit').modal('show');

}

function delete_kec(e, kec_id){
  var id_kec = kec_id;
  var row = $(e).closest('tr').find('td');
  var nama_kec = row[1].innerHTML;
  var nama_kab = row[2].innerHTML;
  
  swal({   
      title: "Hapus "+ nama_kec + " - " + nama_kab + "?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/kecamatan/' + id_kec;
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
                      "Sukses menghapus "+ nama_kec + " - " + nama_kab, 
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

@if ($errors->has('kecamatan_edit'))
  edit_error();
  var id_kec = $('#kecamatan_id_edit').val();
  $('#form-edit-kecamatan').attr('action', '{{route('kecamatan.index')}}' + '/' + id_kec);
@endif

$(document).ready(function() {
    var prov_f = {!! json_encode(request()->prov_f) !!};

    if (prov_f) {
      $('#load-kabupaten_filter').show();
      get_kab_by_prov_id(prov_f, '#kab_f');
      
    }

});

function get_kab_by_prov_id(id, tag_kabupaten_id){
  var url = '{{route('kabupaten.index')}}' + '/provinsi/' + id;
  var kabupaten = '<option value="">Semua</option>';
  // alert(url);
  $.get({
    url:url,
    success: function(data){
      // console.log(data);
      $.each(data, function(key, value){
        kabupaten += '<option value="'+ value['kabupaten_id'] +'" >'+ value['nama_kabupaten'] +'</option>'
      })
      $('#load-kabupaten_filter').hide();
      $(tag_kabupaten_id).html(kabupaten);

      var kab_id = {!! json_encode(request()->kab_f) !!};
      if (kab_id) {
        $('#kab_f').val(kab_id).trigger('change');
        
      }
    }
  })
}

$('#prov_f').change(function(){
  $('#load-kabupaten_filter').show();
  var id = $('#prov_f').val();
  get_kab_by_prov_id(id, '#kab_f');
  
})

</script>
@endsection