@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Bidang Minat
@endsection

@section('page-name')
  Data Bidang Minat
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Bidang Minat</li>
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
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card card-outline-danger">
      <div class="card-header">
        <h5 class="m-b-0 text-white">Filter</h5>
      </div>
        <div class="card-body">
          <form class="" action="{{route('bidang-minat.index')}}" method="get" id="form-filter">
            <div class="row mt-1">
              <div class="col-md-4">
                <label>Fakultas</label>
              </div>
              <div class="col-md-8">
                <select class="select2 form-control custom-select" name="fakultas_id_filter" id="fakultas_id_filter" style="width: 100%">
                    @if ($tipe == 'admin')
                      <option value="">Semua</option>
                    @endif
                    @foreach($faks as $fak)
                      <option {{($fak->fakultas_id == request()->fakultas_id_filter ? 'selected':'')}} value="{{$fak->fakultas_id}}">{{$fak->nama_fakultas}}</option>
                                            
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
              <div class="col-md-8">
                <select class="select2 form-control custom-select" name="prodi_id_filter" id="prodi_id_filter" style="width: 100%" >
                    @if ($tipe == 'admin')
                      <option value="">Semua</option>
                    @elseif($tipe = 'operator')
                      @foreach($prodis as $prodi)
                        <option {{($prodi->prodi_id == request()->prodi_id_filter ? 'selected':'')}} value="{{$prodi->prodi_id}}">{{$prodi->nama_prodi}}</option>
                                              
                      @endforeach
                    @endif
                    
                </select>

              </div>
            </div>      
            <div class="row mt-1">
              <div class="col-md-4">
                <select class="form-control custom-select" name="cari_f">
                  <option value="">Cari</option>
                  <option {{(request()->cari_f == 'nama_binat' ? 'selected':'')}} value="nama_binat">Nama Bidang Minat</option>
                </select>
              </div>
              <div class="col-md-8">
                  <input type="text" class="form-control" name="keterangan_f" value="{{request()->keterangan_f}}">
                
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
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card card-outline-danger">
      <div class="card-header">
        <h4 class="m-b-0 text-white">Daftar Bidang Minat</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover mt-4">
              <thead>
                <tr>
                  <th width="30px">#</th>
                  <th>Nama Bidang Minat</th>
                  <th>Nama Prodi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($binats as $key => $binat)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$binat->nama_bidang}}</td>
                    <td>{{$binat->prodi->nama_prodi}}</td>
                    <td>
                      <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_binat(this, {{$binat->bidangminat_id.','.$binat->prodi_id}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_binat(this, {{$binat->bidangminat_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        
        <div class="pull-right mt-2">
          {{$binats->links()}}
        </div>
      </div>
    </div>    
  </div>
</div>


{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-binat" action="{{route('bidang-minat.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="prodi">Nama Prodi</label>
                <select style="width:100%" class="select2 form-control custom-select" name="prodi_id" id="prodi_id" required>
                  <option value="">Pilih Prodi</option>    
                  @foreach ($prodis as $prodi)
                    <option value={{$prodi->prodi_id}}>{{$prodi->nama_prodi}}</option>
                  @endforeach
                </select>
                
              </div>

              <div class="form-group">
                  <label for="binat" class="control-label">Bidang Minat Baru</label>
                  
                  <input type="text" class="form-control" id="binat" name="nama_bidang" required="" placeholder="Contoh: Umum">
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
          <form class="" id="form-edit-binat" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              
              <input type="text" class="form-control" id="binat_id_edit" name="bidangminat_id" required="" hidden="">
              
              <div class="form-group">
                <label for="prodi">Nama Prodi</label>
                <select class="form-control p-0" name="prodi_id" id="prodi_id_edit" required>
                  
                </select>
                
              </div>

              <div class="form-group">
                  <label for="binat_edit" class="control-label">Nama Bidang</label>
                  
                  <input type="text" class="form-control" id="binat_edit" name="nama_bidang" required="">
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
<script src="{{asset('/assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script>
// $('#table').DataTable();
$('.select2').select2();

function edit_binat(e, binat_id, prodi_id){
  var id_binat = binat_id;
  var row = $(e).closest('tr').find('td');
  var binat = row[1].innerHTML;

  var prodilist = '';
  var selected;
  $.get({
    url: '{{route('prodi.index')}}' + '/' + id_binat,
    success: function(data){
      // console.log(data);
      $.each(data['prodi'], function(key, value){
        selected = (value['prodi_id'] == prodi_id) ? 'selected' : '';
        prodilist += '<option value="'+ value['prodi_id'] +'"'+selected+'>'+ value['nama_prodi'] +'</option>';
        // console.log(kab_sma);
        
      })
      $('#prodi_id_edit').html(prodilist);
      

    }
  })

  $('#form-edit-binat').attr('action', '{{route('bidang-minat.index')}}' + '/' + id_binat);
  $('#binat_id_edit').val(id_binat);
  $('#binat_edit').val(binat);
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}

function delete_binat(e, binat_id){
  var id_binat = binat_id;
  var row = $(e).closest('tr').find('td');
  var binat = row[1].innerHTML;
  
  swal({   
      title: "Hapus "+ binat +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/bidang-minat/' + id_binat;
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
                      "Sukses menghapus "+ binat, 
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

function get_prodi_by_fak_id(id, tag_prodi_id, tag_loading){
  var url = '{{route('prodi.index')}}' + '/fakultas/' + id;
  var prodi_list = '<option value="">Pilih Prodi</option>';

  // alert(url);
  $.get({
    url:url,
    success: function(data){
      // console.log(data);
      $.each(data, function(key, value){
        prodi_list += '<option value="'+ value['prodi_id'] +'" >'+ value['nama_prodi'] +'</option>'
      })

      $(tag_prodi_id).html(prodi_list);
      $(tag_prodi_id).removeAttr('disabled');
      $(tag_loading).hide();

      var p_id = {!! json_encode(request()->prodi_id_filter) !!};
      if (p_id) {
        $('#prodi_id_filter').val(p_id).trigger('change');
        
      }
    }
  })
}

$(document).ready(function() {
    var f_id = $('#fakultas_id_filter').val();
    var tipe = {!! json_encode($tipe) !!};
    if (f_id && tipe == 'admin') {
      $('#load-prodi_filter').show();
      get_prodi_by_fak_id(f_id, '#prodi_id_filter', '#load-prodi_filter');
      
    }

});

$('#fakultas_id_filter').change(function(){
  $('#load-prodi_filter').show();
  var id = $('#fakultas_id_filter').val();
  $('#prodi_id_filter').empty();
  get_prodi_by_fak_id(id, '#prodi_id_filter', '#load-prodi_filter');
})
</script>
@endsection