@extends('layouts.app_admin')
@section('sma-active')
  active
@endsection
@section('master')
  active
@endsection
@section('content')

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Tabel SMA</h3>
    <div class="pull-right">
      <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><span class="fa fa-plus"></span> Tambah SMA</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
      <thead>
      <tr>
        <th width="30px">ID</th>
        <th>SMA</th>
        <th>Kecamatan</th>
        <th>Kabupaten</th>
        <th>Provinsi</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($smas as $key => $sma)
          <tr>
            <td>{{$sma->sma_id}}</td>
            <td>{{$sma->nama_sma}}</td>
            <td>{{$sma->kecamatan->nama_kecamatan}}</td>
            <td>{{$sma->kabupaten->nama_kabupaten}}</td>
            <td>{{$sma->provinsi->nama_provinsi}}</td>
            <td>
              <button class="btn btn-info" onclick="edit_sma({{$key+1}})"><span class="fa fa-pencil"></span></button>
              <button class="btn btn-danger" onclick="delete_sma({{$key+1}})"><span class="fa fa-trash"></span></button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
</div>

{{-- modal insert --}}
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form-add-sma" action="{{route('sma.store')}}" method="post">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah SMA</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">SMA Baru</label>
              <div class="col-sm-9">
                <input type="text" id="nama_sma" name="nama_sma" class="form-control" required="" placeholder="nama SMA..">
              </div>
            </div>

            <div class="form-group">
              <label for="kecamatan" class="col-sm-3 control-label">Kecamatan</label>
              <div class="col-sm-9">
                <select name="kecamatan_id" class="form-control">
                  @foreach ($kecamatans as $kecamatan)
                    <option value={{$kecamatan->kecamatan_id}}>{{$kecamatan->nama_kecamatan}}</option>
                  @endforeach
                </select>
              </div>
            </div>
              
            <div class="form-group">
              <label for="kabupaten" class="col-sm-3 control-label">Kabupaten</label>
              <div class="col-sm-9">
                <select name="kabupaten_id" class="form-control">
                  @foreach ($kabupatens as $kabupaten)
                    <option value={{$kabupaten->kabupaten_id}}>{{$kabupaten->nama_kabupaten}}</option>
                  @endforeach
                </select>
              </div>
            </div>
              
            <div class="form-group">
              <label for="provinsi" class="col-sm-3 control-label">Provinsi</label>
              <div class="col-sm-9" id="provinsi">
                <select name="provinsi_id" class="form-control">
                  @foreach ($provinsis as $provinsi)
                    <option value={{$provinsi->provinsi_id}}>{{$provinsi->nama_provinsi}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
{{-- modal insert --}}

{{-- modal edit --}}
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form-edit-sma" action="" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit SMA</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input type="text" id="sma_id_edit" name="sma_id" class="form-control" required="" placeholder="ID SMA.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama SMA</label>
              <div class="col-sm-9">
                <input type="text" id="nama_sma_edit" name="nama_sma" class="form-control" required="" placeholder="nama SMA..">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Kecamatan</label>
              <div class="col-sm-9">
                <select name="kecamatan_id" class="form-control">
                  @foreach ($kecamatans as $kecamatan)
                    <option value={{$kecamatan->kecamatan_id}}>{{$kecamatan->nama_kecamatan}}</option>
                  @endforeach
                </select>

              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Kabupaten</label>
              <div class="col-sm-9">
                <select name="kabupaten_id" class="form-control">
                  @foreach ($kabupatens as $kabupaten)
                    <option value={{$kabupaten->kabupaten_id}}>{{$kabupaten->nama_kabupaten}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Provinsi</label>
              <div class="col-sm-9">
                <select name="provinsi_id" class="form-control">
                  @foreach ($provinsis as $provinsi)
                    <option value={{$provinsi->provinsi_id}}>{{$provinsi->nama_provinsi}}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" >Simpan Perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
{{-- modal edit --}}

{{-- modal delete --}}
<div class="modal fade" id="modal-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="form-delete-sma" action="" method="post">
        @csrf
        {{ method_field('DELETE') }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete SMA</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input type="text" id="sma_id_delete" name="sma_id" class="form-control" required="" placeholder="ID SMA.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama SMA</label>
              <div class="col-sm-9">
                <input type="text" id="nama_sma_delete" name="nama_sma" class="form-control" required="" placeholder="nama sma.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Kecamatan</label>
              <div class="col-sm-9">
                <input type="text" id="nama_kecamatan_delete" name="kecamatan_id" class="form-control" required="" placeholder="ID Kecamatan.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Kabupaten</label>
              <div class="col-sm-9">
                <input type="text" id="nama_kabupaten_delete" name="kabupaten_id" class="form-control" required="" placeholder="ID Kabupaten.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="sma" class="col-sm-3 control-label">Nama Provinsi</label>
              <div class="col-sm-9">
                <input type="text" id="nama_provinsi_delete" name="provinsi_id" class="form-control" required="" placeholder="ID Provinsi.." readonly="">
              </div>
            </div>

            <div>
              Apakah anda yakin ingin menghapus SMA ini?
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger" >Hapus</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
{{-- modal delete --}}
@endsection

@section('js')
<script>

function edit_sma(id){
  var id_sma = $('#example1 tr').eq(id).find('td').eq(0).html();
  var nama_sma = $('#example1 tr').eq(id).find('td').eq(1).html();
  var nama_kecamatan = $('#example1 tr').eq(id).find('td').eq(2).html();
  var nama_kabupaten = $('#example1 tr').eq(id).find('td').eq(3).html();
  var nama_provinsi = $('#example1 tr').eq(id).find('td').eq(4).html();

  $('#form-edit-sma').attr('action', '{{route('sma.index')}}' + '/' + id_sma);
  $('#sma_id_edit').val(id_sma);
  $('#nama_sma_edit').val(nama_sma);
  $('#nama_kecamatan_edit').val(nama_kecamatan);
  $('#nama_kabupaten_edit').val(nama_kabupaten);
  $('#nama_provinsi_edit').val(nama_provinsi);
  $('#modal-edit').modal('show');

}

function delete_sma(id){
  var id_sma = $('#example1 tr').eq(id).find('td').eq(0).html();
  var nama_sma = $('#example1 tr').eq(id).find('td').eq(1).html();
  var nama_kecamatan = $('#example1 tr').eq(id).find('td').eq(2).html();
  var nama_kabupaten = $('#example1 tr').eq(id).find('td').eq(3).html();
  var nama_provinsi = $('#example1 tr').eq(id).find('td').eq(4).html();
  
  $('#form-delete-sma').attr('action', '{{route('sma.index')}}' + '/' + id_sma);
  $('#sma_id_delete').val(id_sma);
  $('#nama_sma_delete').val(nama_sma);
  $('#nama_kecamatan_delete').val(nama_kecamatan);
  $('#nama_kabupaten_delete').val(nama_kabupaten);
  $('#nama_provinsi_delete').val(nama_provinsi);
  $('#modal-delete').modal('show');
}

</script>
@endsection