@extends('layout/app')


@section('content')
<div class="card ml-auto mr-auto col-md-6 col-sm-12">
  <div class="card-body">
    <div class="col-sm-12 mb-5">
      <h3 style="font-weight: bold;">Reset Password Anda</h3>
    </div>


    <div class="col-sm-12">
    @if (empty($user))
      <p>Tidak ada informasi yang kami dapatkan berdasarkan masukan username anda.</p>

      <a href="{{ route('acc.beginPasswordReset') }}" class="btn btn-danger waves-effect mt-3"><span class="btn-label"><i class="ti-arrow-left"></i></span> Kembali</a>
    @else
      <div class="row">
        <div class="col-sm-2">
          <img src="{{ asset(App\Models\User::$dir.'/'.$user->profilepict) }}" class="img-circle" width="60">
        </div>
        <div class="col-sm-10">
          <h6 style="font-weight: bold;" class="mt-3 mb-0">{{ $user->name }}</h6>
          <p><small>{{ '@'.$user->username }}</small></p>
        </div>
      </div>

      <p>Kami menemukan informasi ini terkait dengan akun anda. Kami akan mengirimkan <span style="font-weight: bold;">tautan</span> untuk mengubah password anda.</p>

      <div class="row">
        <div class="col-sm-2">
          <h1 class="ti-email text-info" style="font-size: 50px;"></h1>
        </div>
        <div class="col-sm-10">
          <h6 style="font-weight: bold;" class="mt-2 mb-0">Kirim tautan via Email</h6>
          <p><small>email akan dikirim ke {{ App\Models\User::hideEmail($user->email) }}</small></p>        
        </div>
      </div>

      <form action="{{ route('acc.sendPasswordReset') }}" method="post">
        @csrf
        <input type="hidden" name="username" value="{{ $user->username }}">
        <a href="{{ route('acc.beginPasswordReset') }}" class="btn btn-danger waves-effect"><span class="btn-label"><i class="ti-arrow-left"></i></span> Kembali</a>

        <button type="submit" class="btn btn-info waves-effect"><span class="btn-label"><i class="ti-arrow-right"></i></span> Lanjutkan</button>
      </form>
    @endif
      
    </div>
  </div>
</div>
@endsection