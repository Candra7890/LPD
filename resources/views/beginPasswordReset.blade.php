@extends('layout/app')


@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12">
  <div class="card-body">
    <div class="col-sm-12 mb-5">
      <h3 style="font-weight: bold;">Temukan Akun SRUTI Anda</h3>
    </div>

    <div class="col-sm-12">
        <form action="{{ route('acc.searchPasswordReset') }}" method="post">
          @csrf
          <div class="form-group">
              <label>Masukkan username anda untuk mencari akun anda</label>
              <input type="text" name="auth" class="form-control" required="">
          </div>

          <div class="form-group mt-4">
              <img id="captcha-img" src="{{ route('captcha.generate',['id' => time()]) }}">
              <a style="margin-top: 4px" class="btn-ganti-captcha" href="#" onclick="event.preventDefault(); refresh()"><i class="fa fa-rotate-right"></i> Ganti Captcha</a>
          </div>

          <div class="input-group mt-2 {{ ($errors->has('captcha')) ? 'has-danger' : '' }}">
              {{-- <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                      <i class="mdi mdi-qrcode-scan"></i>
                  </span>
              </div> --}}
              <input type="text" class="form-control {{ ($errors->has('captcha')) ? 'form-control-danger' : '' }}" placeholder="kode captcha.." name="captcha">
          </div>
          @if($errors->has('captcha'))
            <small><i class="text-danger">{{ $errors->first('captcha') }}</i></small><br>
          @endif


          <button type="submit" class="btn btn-info waves-effect mt-3"><span class="btn-label"><i class="ti-search"></i></span> Cari</button>
        </form>


    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/captcha.js') }}"></script>
@endsection
