@extends('layout/app')

@section('css')
<link href="{{asset('/assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12">
  <div class="card-body">
    <div class="col-sm-12 mb-5">
      <h4 class="text-info">Ubah Password</h4>
      @if ($_SESSION['auth']['isNew'] == 1)
        <p>Sistem mendeteksi anda adalah pengguna baru. Untuk menjaga keamanan akun anda, silakan lakukan perubahan password.</p>
      @endif
    </div>

    <div class="col-sm-12">
        @if ($errors->has('notFound'))
          <div class="alert alert-danger">
            <span>{{ $errors->first('notFound') }}</span>
          </div>
        @endif

        <form action="{{ route('home.changePass') }}" method="post" class="form-horizontal" id="form-change">
          @csrf
          <div class="form-group {{ ($errors->has('current')) ? 'has-danger' : '' }}">
              <label>Password Saat Ini</label>
              <input type="password" class="form-control {{ ($errors->has('current')) ? 'form-control-danger' : '' }}" name="current" placeholder="password yang anda gunakan untuk login saat ini..">
              @if($errors->has('current'))
                <small><i class="text-danger">{{ $errors->first('current') }}</i></small>
              @endif
          </div>

          <div class="form-group {{ ($errors->has('new')) ? 'has-danger' : '' }}">
              <label>Password Baru</label>
              <input type="password" class="form-control {{ ($errors->has('new')) ? 'form-control-danger' : '' }}" name="new" placeholder="password baru..">
              @if($errors->has('new'))
                <small><i class="text-danger">{{ $errors->first('new') }}</i></small>
              @endif
          </div>

          <div class="form-group">
              <label>Ulangi Password Baru</label>
              <input type="password" class="form-control" name="new_confirmation" placeholder="ketik ulang password baru">
          </div>

          <div class="row mt-5">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">
              <button class="btn btn-info btn-block" type="button" id="btn-change">Ubah Password</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/captcha.js') }}"></script>
<script type="text/javascript" src="{{ asset('password/change.js') }}"></script>
@endsection