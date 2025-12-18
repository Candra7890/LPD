@extends('layout/app')


@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12">
  <div class="card-body">
    <div class="col-sm-12 mb-5">
      <h3 style="font-weight: bold;">Email Terkirim</h3>
    </div>

    <div class="col-sm-12">
        <p style="text-align: center;"><span class=" ti-check-box text-info" style="font-size: 70px"></span></p>

        <h6 class="text-center">Email reset password telah dikirim. Silakan periksa email anda dan klik tautan yang disediakan.</h6>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/captcha.js') }}"></script>
@endsection
