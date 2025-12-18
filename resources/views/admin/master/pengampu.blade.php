@extends('layouts.app_admin')
@section('pengampu-active')
  active
@endsection
@section('master')
  active
@endsection
@section('content')


<div class="box">
  <div class="box-header">
    <h3 class="box-title">Tabel Pengampu</h3>
    <div class="pull-right">
      <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><span class="fa fa-plus"></span> Tambah Pengampu</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
      <thead>
      <tr>
        <th width="30px">ID</th>
        <th>Mktawar ID</th>
        <th>Dosen</th>
        <th>Status</th>
        <th>Urutan</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($pengampus as $key => $pengampu)
          <tr>
            <td>{{$pengampu->pengampu_id}}</td>
            <td>{{$pengampu->mktawar_id}}</td>
            <td>{{$pengampu->dosen->nama}}</td>
            <td>{{$pengampu->status}}</td>
            <td>{{$pengampu->urutan}}</td>
            <td>
              <button class="btn btn-info" onclick="edit_pengampu({{$key+1}})"><span class="fa fa-pencil"></span></button>
              <button class="btn btn-danger" onclick="delete_pengampu({{$key+1}})"><span class="fa fa-trash"></span></button>
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
      <form class="form-horizontal" id="form-add-pengampu" action="{{route('pengampu.store')}}" method="post">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Pengampu</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Mk Tawar</label>
              <div class="col-sm-9">
                <select name="mktawar_id" class="form-control">
                  @foreach ($mktawars as $mktawar)
                    <option value={{$mktawar->mktawar_id}}>{{$mktawar->mktawar_id}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Dosen</label>
              <div class="col-sm-9">
                <select name="dosen_id" class="form-control">
                  @foreach ($dosens as $dosen)
                    <option value={{$dosen->dosen_id}}>{{$dosen->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <input type="text" id="status" name="status" class="form-control" required="" placeholder="Status..">
              </div>
            </div>
            
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Urutan</label>
              <div class="col-sm-9">
                <input type="number" id="urutan" name="urutan" class="form-control" required="" placeholder="Urutan..">
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
      <form class="form-horizontal" id="form-edit-pengampu" action="" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Pengampu</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input type="text" id="pengampu_id_edit" name="pengampu_id" class="form-control" required="" placeholder="ID Pengampu.." readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Mktawar ID</label>
              <div class="col-sm-9">
                <select name="mktawar_id" class="form-control">
                  @foreach ($mktawars as $mktawar)
                    <option value={{$mktawar->mktawar_id}}>{{$mktawar->mktawar_id}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Dosen</label>
              <div class="col-sm-9">
                <select name="dosen_id" class="form-control">
                  @foreach ($dosens as $dosen)
                    <option value={{$dosen->dosen_id}}>{{$dosen->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <input type="text" id="status_edit" name="status" class="form-control" required="" placeholder="Status..">
              </div>
            </div>
            
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Urutan</label>
              <div class="col-sm-9">
                <input type="number" id="urutan_edit" name="urutan" class="form-control" required="" placeholder="urutan..">
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
      <form class="form-horizontal" id="form-delete-pengampu" action="" method="post">
        @csrf
        {{ method_field('DELETE') }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete Pengampu</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input type="text" id="pengampu_id_delete" name="pengampu_id" class="form-control" required="" placeholder="ID.." readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Mktawar ID</label>
              <div class="col-sm-9">
                <input type="text" id="mktawar_delete" name="mktawar_id" class="form-control" required="" placeholder="Mktawar ID.." readonly="">
              </div>
            </div>

            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Dosen</label>
              <div class="col-sm-9">
                <input type="text" id="nama_dosen_delete" name="nama_dosen" class="form-control" required="" placeholder="nama dosen.." readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <input type="text" id="status_delete" name="status" class="form-control" required="" placeholder="status.." readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="pengampu" class="col-sm-3 control-label">Urutan</label>
              <div class="col-sm-9">
                <input type="text" id="urutan_delete" name="urutan" class="form-control" required="" placeholder="urutan.." readonly="">
              </div>
            </div>

            <div>
              Apakah anda yakin ingin menghapus Ruangan ini?
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

function edit_pengampu(id){
  var id_pengampu = $('#example1 tr').eq(id).find('td').eq(0).html();
  var mktawar_id = $('#example1 tr').eq(id).find('td').eq(1).html();
  var nama_dosen = $('#example1 tr').eq(id).find('td').eq(2).html();
  var status = $('#example1 tr').eq(id).find('td').eq(3).html();
  var urutan = $('#example1 tr').eq(id).find('td').eq(4).html();
  
  $('#form-edit-pengampu').attr('action', '{{route('pengampu.index')}}' + '/' + id_pengampu);
  $('#pengampu_id_edit').val(id_pengampu);
  $('#mktawar_edit').val(mktawar_id);
  $('#nama_dosen_edit').val(nama_dosen);
  $('#status_edit').val(status);
  $('#urutan_edit').val(urutan);
  $('#modal-edit').modal('show');

}

function delete_pengampu(id){
  var id_pengampu = $('#example1 tr').eq(id).find('td').eq(0).html();
  var mktawar_id = $('#example1 tr').eq(id).find('td').eq(1).html();
  var nama_dosen = $('#example1 tr').eq(id).find('td').eq(2).html();
  var status = $('#example1 tr').eq(id).find('td').eq(3).html();
  var urutan = $('#example1 tr').eq(id).find('td').eq(4).html();
  
  $('#form-delete-pengampu').attr('action', '{{route('pengampu.index')}}' + '/' + id_pengampu);
  $('#pengampu_id_delete').val(id_pengampu);
  $('#mktawar_delete').val(mktawar_id);
  $('#nama_dosen_delete').val(nama_dosen);
  $('#status_delete').val(status);
  $('#urutan_delete').val(urutan);
  $('#modal-delete').modal('show');
}

</script>
@endsection