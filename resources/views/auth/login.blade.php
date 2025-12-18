<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem LPD">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>Login - Sistem LPD</title>
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors/red.css') }}" id="theme" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <section id="wrapper">
        <div class="login-register" style="background-image:url({{ asset('assets/images/background/login-register.jpg') }});">
            <div class="login-box card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form class="form-horizontal form-material" method="post" id="loginform" action="{{ route('login') }}">
                        @csrf
                        <h3 class="box-title m-b-20">Login Sistem LPD</h3>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="email" required="" 
                                       placeholder="Email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" 
                                       required="" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox" name="remember" 
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label for="checkbox-signup"> Ingat Saya </label>
                                </div>
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right">
                                    Lupa Password?
                                </a>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" 
                                        type="submit">Masuk</button>
                            </div>
                        </div>

                        <!-- <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                Belum punya akun? <a href="{{ route('register') }}" class="text-info m-l-5">
                                    <b>Daftar Sekarang</b>
                                </a>
                            </div>
                        </div> -->
                    </form>

                    <form class="form-horizontal" id="recoverform">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <h3>Reset Password</h3>
                                <p class="text-muted">Silakan hubungi administrator untuk reset password Anda.</p>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <a href="javascript:void(0)" id="back-to-login" class="btn btn-primary btn-lg btn-block text-uppercase">
                                    Kembali ke Login
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#to-recover').on('click', function() {
                $('#loginform').slideUp();
                $('#recoverform').fadeIn();
            });
            
            $('#back-to-login').on('click', function() {
                $('#recoverform').slideUp();
                $('#loginform').fadeIn();
            });
        });
    </script>
</body>

</html>