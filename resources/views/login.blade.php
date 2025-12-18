@extends('layout/app')


@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12" style="padding: 0px;s">
  <div class="col-sm-12 " style="padding: 15px; background-color: #e9ecef">
      <img src="{{asset('ssss.png')}}" class="" style="height: 70px; margin: 0 auto; display: block;" alt="homepage" /></span> </a>
      {{-- <h2 class="font-weight-bold text-info" style="text-align: center;">SRUTI</h2>
      <div style="text-align: center;">
        <span class="text-muted" style="text-align: center;">Sistem Informasi Universitas Terintegrasi</span> --}}
  </div>
  <div class="card-body">
    

    <div class="col-sm-12 mb-5">
        @if ($errors->has('notFound'))
          <div class="alert alert-danger">
            <span>{{ $errors->first('notFound') }}</span>
          </div>
        @endif

        @if($errors->has('cooldown'))
          <div class="alert alert-danger">
            <span>{{ $errors->first('cooldown') }}</span>
          </div>
        @endif
        <form action="{{ route('login.store') }}" method="post">
          @csrf
          <div class="input-group mt-2 {{ ($errors->has('username')) ? 'has-danger' : '' }}">
              <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="mdi mdi-account"></i>
                  </span>
              </div>
              <input type="text" class="form-control {{ ($errors->has('username')) ? 'form-control-danger' : '' }}" placeholder="username..." name="username" value="{{ old('username') }}">
          </div>
          @if($errors->has('username'))
            <small><i class="text-danger">{{ $errors->first('username') }}</i></small>
          @endif

          <div class="input-group mt-2 {{ ($errors->has('password')) ? 'has-danger' : '' }}">
              <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                      <i class="mdi mdi-key"></i>
                  </span>
              </div>
              <input type="password" class="form-control {{ ($errors->has('password')) ? 'form-control-danger' : '' }}" placeholder="password..." name="password">
          </div>
          @if($errors->has('password'))
            <small><i class="text-danger">{{ $errors->first('password') }}</i></small>
          @endif

          <div class="form-group mt-4">
              <img id="captcha-img" src="/captcha?id=0.4818471683985903">
              <a style="margin-top: 4px" class="btn-ganti-captcha" href="#" onclick="event.preventDefault(); refresh()"><i class="fa fa-rotate-right"></i> Ganti Captcha</a>
          </div>
          
          <div class="input-group mt-2 {{ ($errors->has('captcha')) ? 'has-danger' : '' }}">
              <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                      <i class="mdi mdi-qrcode-scan"></i>
                  </span>
              </div>
              <input type="text" class="form-control {{ ($errors->has('captcha')) ? 'form-control-danger' : '' }}" placeholder="kode captcha.." name="captcha">
          </div>
          @if($errors->has('captcha'))
            <small><i class="text-danger">{{ $errors->first('captcha') }}</i></small>
          @endif

          <div class="row mt-5">
            <div class="col-sm-6">
              <a href="{{ route('acc.beginPasswordReset') }}">Lupa Password?</a><br>
              <a href="">Butuh Bantuan?</a>
            </div>
            <div class="col-sm-6">
              <button class="btn btn-info btn-block">Login</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/captcha.js') }}"></script>
@endsection