@extends('layouts.app_admin2')
@section('title')
SIMAK - Master SMA
@endsection

@section('page-name')
  Data SMA
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master SMA</li>
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
  <div class="col-md-10">
    <div class="card card-outline-danger">
      {{-- <div class="card-header">
        <h4 class="m-b-0 text-white">Daftar SMA</h4>
      </div> --}}
      <div class="card-body">
          <div class="table-responsive">
            <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
            
              <table id="table" class="table table-bordered table-hover table-sm mt-4">
                  <thead>
                      <tr>
                        <th width="30px">#</th>
                        {{-- <th width="30px">ID</th> --}}
                        <th>SMA</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th width="15%" class="text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($smas as $key => $sma)
                      <tr>
                        <td>{{$key+1}}</td>
                        {{-- <td>{{$sma->sma_id}}</td> --}}
                        <td>{{$sma->nama_sma}}</td>
                        <td>{{$sma->provinsi->nama_provinsi ?? '-'}}</td>
                        <td>{{$sma->kabupaten->nama_kabupaten ?? '-'}}</td>
                        <td>{{$sma->kecamatan->nama_kecamatan ?? '-'}}</td>
    
    
                        <td class="text-center">
                          <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_sma(this, {{($sma->sma_id).','.($sma->id_provinsi ?? 0).','.($sma->id_kabupaten ?? 0).','.($sma->id_kecamatan ?? 0)}})" data-toggle="tooltip" title="Sunting"><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_sma(this, {{$sma->sma_id}})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
              <div class="pull-right">
                {{$smas->links()}}
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
          <form class="" id="form-add-sma" action="{{route('sma.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group focus {{ ($errors->has('sma')) ? 'has-danger has-error has-feedback' : ''}}">
                  <label for="sma" class="control-label">Nama SMA</label>
                  <input type="text" placeholder="Contoh: SMAN 1 Kuta" class="form-control" id="sma" name="sma" required="" autofocus" value="{{ old('sma') }}" required="">
                  <span class="bar"></span>
                  
                  @if ($errors->has('sma'))
                    <span class="input-error">
                        <strong>{{ $errors->first('sma') }}</strong>
                    </span>
                  @endif
              </div>

              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control p-0" name="provinsi_id" id="provinsi_id_ins" required>
                  <option value="">Pilih Provinsi</option>
                  @foreach ($provinsis as $provinsi)
                    <option value={{$provinsi->provinsi_id}}>{{$provinsi->nama_provinsi}}</option>
                  @endforeach
                </select>
                
              </div>

              <div class="form-group m-t-20">
                <div class="row col-sm-12">
                  <label for="kabupaten">Kabupaten</label>
                  <div id="load-kab_ins" style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif')  }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;"></div>
                </div>
                <select class="form-control p-0" id="kabupaten_id_ins" name="kabupaten_id" disabled="" required>
                  <option value="">Pilih Kabupaten</option>
                </select><span class="bar"></span>   
                
              </div>

              <div class="form-group m-t-20">
                <div class="row col-sm-12">
                  <label for="kecamatan">Kecamatan</label>
                  <div id="load-kec_ins" style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif')  }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;"></div>
                </div>                
                <select class="form-control p-0" name="kecamatan_id" disabled="" id="kecamatan_id_ins" required>
                  <option value="">Pilih Kecamatan</option>
                  @foreach ($kecamatans as $kecamatan)
                    <option value={{$kecamatan->kecamatan_id}}>{{$kecamatan->nama_kecamatan}}</option>
                  @endforeach
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
          <form class="" id="form-edit-sma" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control" id="sma_id_edit" name="sma_id" required="" hidden="">
              

              <div class="form-group focus {{ ($errors->has('sma_edit')) ? 'has-danger has-error has-feedback' : ''}}">
                  <label for="sma_edit" class="control-label">Nama SMA</label>
                  
                  <input type="text" class="form-control" id="sma_edit" name="sma" required="" value="{{ old('sma_edit') }}">
                  <span class="bar"></span>
                  @if ($errors->has('sma_edit'))
                    <span class="input-error">
                        <strong>{{ $errors->first('sma_edit') }}</strong>
                    </span>
                  @endif

              </div>

              <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select class="form-control p-0" name="provinsi_id_edit" id="provinsi_id_edit">
                  <option value=""></option>
                  @foreach ($provinsis as $provinsi)
                    <option value={{$provinsi->provinsi_id}} id="prov{{$provinsi->provinsi_id}}">{{$provinsi->nama_provinsi}}</option>
                  @endforeach
                </select><span class="bar"></span>   
                
              </div>

              <div class="form-group">
                <label for="kabupaten">Kabupaten</label>
                <div id="load-kab_edit" style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif')  }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;"></div>
                <select class="form-control p-0" name="kabupaten_id_edit" id="kabupaten_id_edit" >
                  
                </select><span class="bar"></span>   
                
              </div>
              <div class="form-group m-t-20">
                <label for="kecamatan">Kecamatan</label>
                <div id="load-kec_edit" style="background-image: url('{{ asset('assets/images/Facebook-1s-30px.gif')  }}'); height: 30px; width: 40px; background-repeat: no-repeat; background-position: center; display: none;"></div>
                <select class="form-control p-0" name="kecamatan_id_edit" required="" id="kecamatan_id_edit">
                  {{-- <option value=""></option>
                  @foreach ($kecamatans as $kecamatan)
                    <option value={{$kecamatan->kecamatan_id}}>{{$kecamatan->nama_kecamatan}}</option>
                  @endforeach --}}
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

function edit_sma(e, sma_id, prov_id, kab_id, kec_id){
  var id_sma = sma_id;
  var row = $(e).closest('tr').find('td');
  var sma = row[1].innerHTML;

  var kab_sma = '';
  var kec_sma = '';
  var selected;
  $('#provinsi_id_edit option:selected').removeAttr('selected');
  $('#prov'+prov_id).attr('selected', '');
  $.get({
    url: '{{route('sma.index')}}' + '/' + id_sma,
    success: function(data){
      // console.log(data);
      $.each(data['kabupaten'], function(key, value){
        selected = (value['kabupaten_id'] == kab_id) ? 'selected' : '';
        kab_sma += '<option value="'+ value['kabupaten_id'] +'"'+selected+'>'+ value['nama_kabupaten'] +'</option>';
        // console.log(kab_sma);
        
      })
      $('#kabupaten_id_edit').html(kab_sma);
      
      $.each(data['kecamatan'], function(key, value){
        selected = (value['kecamatan_id'] == kec_id) ? 'selected' : '';
        kec_sma += '<option value="'+ value['kecamatan_id'] +'"'+selected+'>'+ value['nama_kecamatan'] +'</option>';
        // console.log(kab_sma);
        
      })
      $('#kecamatan_id_edit').html(kec_sma);

    }
  })

  $('#form-edit-sma').attr('action', '{{route('sma.index')}}' + '/' + id_sma);
  $('#sma_id_edit').val(id_sma);
  $('#sma_edit').val(sma);
  $('.focus').attr('class', 'form-group m-t-20 focused');
  $('#modal-edit').modal('show');

}


function delete_sma(e, sma_id){
  var id_sma = sma_id;
  var row = $(e).closest('tr').find('td');
  var sma = row[1].innerHTML;

  swal({   
      title: "Hapus SMA "+ sma +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/sma/' + id_sma;
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
                      "Sukses menghapus SMA "+ sma, 
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

function get_kab_by_prov_id(id, tag_kabupaten_id, tag_loading){
  var url = '{{route('kabupaten.index')}}' + '/provinsi/' + id;
  var kabupaten = '<option value="">--</option>';
  // alert(url);
  $.get({
    url:url,
    success: function(data){
      // console.log(data);
      $.each(data, function(key, value){
        kabupaten += '<option value="'+ value['kabupaten_id'] +'" >'+ value['nama_kabupaten'] +'</option>'
      })

      $(tag_kabupaten_id).html(kabupaten);
      $(tag_kabupaten_id).removeAttr('disabled');
      $(tag_loading).hide();
    }
  })
}

function get_kec_by_kab_id(id, tag_kecamatan_id, tag_loading){
  var url = '{{route('kecamatan.index')}}' + '/kabupaten/' + id;
  var kecamatan = '';
  $.get({
    url:url,
    success: function(data){
      $.each(data, function(key, value){
        kecamatan += '<option value="'+ value['kecamatan_id'] +'" >'+ value['nama_kecamatan'] +'</option>'
      })

      $(tag_kecamatan_id).html(kecamatan);
      $(tag_kecamatan_id).removeAttr('disabled');
      $(tag_loading).hide();
    }
  })
}

$('#provinsi_id_ins').change(function(){
  $('#load-kab_ins').show();
  // id_provinsi
  var id = $('#provinsi_id_ins').val();
  // alert('iseng: ' + id);
  // console.log('iseng: ' + id);
  get_kab_by_prov_id(id, '#kabupaten_id_ins', '#load-kab_ins');

})

$('#kabupaten_id_ins').change(function(){
  $('#load-kec_ins').show();
  var id = $('#kabupaten_id_ins').val();
  get_kec_by_kab_id(id, '#kecamatan_id_ins', '#load-kec_ins');

})

$('#provinsi_id_edit').change(function(){
  
  // id_provinsi
  var id = $('#provinsi_id_edit').val();
  // alert('iseng: ' + id);
  // console.log('iseng: ' + id);
  get_kab_by_prov_id(id, '#kabupaten_id_edit', '#load-kab_edit');
  
})

$('#kabupaten_id_edit').change(function(){

  var id = $('#kabupaten_id_edit').val();
  get_kec_by_kab_id(id, '#kecamatan_id_edit', '#load-kec_edit');
})


@if ($errors->has('sma'))
  insert_error();
@endif

@if ($errors->has('sma_edit'))
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
