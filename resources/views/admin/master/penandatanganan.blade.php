@extends('layouts.app_admin2')
@section('title')
    SIMAK - Master Penandatanganan Transkript
@endsection

@section('page-name')
    Setup Penandatanganan Transkript
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Penandatanganan Transkript</li>
@endsection

@section('css')
    <link href="{{ asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
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
    @if (session()->has('insert'))
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
            <div class="card card-outline-primary">
                {{-- <div class="card-header">
        <h5 class="m-b-0 text-white">Filter</h5>
      </div> --}}
                <div class="card-body">
                    <form class="" action="{{ route('penandatanganan-transkript') }}" method="post" id="form-filter">
                        @csrf
                        {{-- <input type="text" name="ttd_id" value="{{$data->penandatanganan_id}}" hidden=""> --}}
                        @if ($tipe != 'akademik')
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label>Fakultas</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="fak_id" required="">
                                        <option value="{{ $faks->fakultas_id }}">{{ $faks->nama_fakultas }}</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label>Jenjang Studi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="jenjang" required="" id="jenjangstudi">
                                        <option>Pilih Jenjang</option>
                                        @foreach ($jenjang as $jen)
                                            <option value="{{ $jen->jenjangprodi_id }}">{{ $jen->jenjang }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Nama</label>
                            </div>
                            <div class="col-md-8">
                                @if ($tipe == 'akademik')
                                    <input value="{{ !empty($data->nama) ? $data->nama : '' }}" type="text" id="nama" class=" form-control" name="nama" required="">
                                @else
                                    <input type="text" id="nama" class=" form-control" name="nama" required="">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>NIP</label>
                            </div>
                            <div class="col-md-8">
                                @if ($tipe == 'akademik')
                                    <input value="{{ !empty($data->nip) ? $data->nip : '' }}" type="text" id="nip" class="form-control" name="nip" required="">
                                @else
                                    <input type="text" id="nip" class="form-control" name="nip" required="">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Jabatan</label>
                            </div>
                            <div class="col-md-8">
                                @if ($tipe == 'akademik')
                                    <input value="{{ !empty($data->jabatan) ? $data->jabatan : '' }}" type="text" id="jabatan" class="form-control" name="jabatan" required="">
                                @else
                                    <input type="text" id="jabatan" class="form-control" name="jabatan" required="">
                                @endif
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Jabatan (English)</label>
                            </div>
                            <div class="col-md-8">
                                @if ($tipe == 'akademik')
                                    <input value="{{ !empty($data->jabatan_english) ? $data->jabatan_english : '' }}" type="text" id="jabatan_english" class="form-control" name="jabatan_english"
                                        required="">
                                @else
                                    <input type="text" id="jabatan_english" class="form-control" name="jabatan_english" required="">
                                @endif
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Tempat</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" value="{{ !empty($data->tempat) ? $data->tempat : '' }}" class="form-control" id="tempat" name="tempat" required="">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label>Tanggal</label>
                            </div>
                            <div class="col-md-8">
                                {{-- mydatepicker --}}
                                <input type="date" id="tanggal" value="{{ !empty($data->tanggal) ? $data->tanggal : '' }}" class="form-control form-control-sm " name="tanggal">
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions mt-3">
                            <button class="btn btn-sm btn-info waves-effect waves-light" type="submit" id="btn-simpan"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery('.mydatepicker, #datepicker').datepicker();
            jQuery('#date-range').datepicker({
                toggleActive: true
            });

        })

        $('#jenjangstudi').change(function() {

            // id_provinsi
            var jenjang_id = $('#jenjangstudi').val();
            var fak_id = {!! json_encode($f_id) !!};

            // alert('iseng: ' + todayTime);
            $.get({
                url: '{{ route('penandatanganan-transkript') }}' + '/' + jenjang_id + '/' + fak_id,
                success: function(data) {
                    console.log(data);

                    $('#tempat').val(data['tempat']);
                    $('#tanggal').val(data['tanggal']);
                    $('#nama').val(data['nama']);
                    $('#nip').val(data['nip']);
                    $('#jabatan').val(data['jabatan']);
                    $('#jabatan_english').val(data['jabatan_english']);

                }
            })

        })
    </script>
@endsection
