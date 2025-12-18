@extends('layout/app')


@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12">
  <div class="card-body">
    <div class="col-sm-12 mb-5">
      <h3 style="font-weight: bold;">Reset Password</h3>
    </div>

    <div class="col-sm-12">
        @if ($errors->has('notFound'))
          <div class="alert alert-danger">
            <span>{{ $errors->first('notFound') }}</span>
          </div>
        @endif

        <form action="{{ route('acc.resetPassword') }}" method="post" class="form-horizontal">
          @csrf

          <input type="hidden" name="token" value="{{ $token }}">
          <div class="form-group {{ ($errors->has('new')) ? 'has-danger' : '' }}">
              <label>Password Baru</label>
              <input type="password" class="form-control {{ ($errors->has('new')) ? 'form-control-danger' : '' }}" name="new" placeholder="password baru.." required="">
              @if($errors->has('new'))
                <small><i class="text-danger">{{ $errors->first('new') }}</i></small>
              @endif
          </div>

          <div class="form-group">
              <label>Ulangi Password Baru</label>
              <input type="password" class="form-control" name="new_confirmation" placeholder="ketik ulang password baru" required="">
          </div>

          <div class="row mt-5">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">
              <button class="btn btn-info btn-block">Ubah Password</button>
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