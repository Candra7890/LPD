<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asmk.png') }}">
    <title>{{ config('app.name') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        th {
            font-size: 1rem !important;
        }
    </style>
    <!-- morris CSS -->
    @yield('css')
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}?v=1" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ mix('/css/app.css') }}"> --}}
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('css/colors/red.css') }}" id="theme" rel="stylesheet">
    {{-- <link href="{{asset('css/colors/green.css')}}" id="theme" rel="stylesheet">
    <link href="{{asset('css/colors/megna.css')}}" id="theme" rel="stylesheet">
    <link href="{{asset('css/colors/purple.css')}}" id="theme" rel="stylesheet">
    <link href="{{asset('css/colors/red.css')}}" id="theme" rel="stylesheet"> --}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('asmk.png') }}" width="30" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('asmk.png') }}" width="30" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <span>
                            <!-- dark Logo text -->
                            {{-- <img src="{{asset('astamanik.png')}}" height="50" alt="homepage" class="dark-logo" /> --}}
                            <!-- Light Logo text -->
                            {{-- <img src="{{asset('astamanik.png')}}" class="light-logo" alt="homepage" /> --}}
                        </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </li>

                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ session()->get('currentRole')->nama_role }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right scale-up" id="top-roles">
                                <input type="text" name="" id="kw-role" class="form-control" autofocus="autofocus" placeholder="cari..">
                                <ul class="dropdown-user" id="roles" style="max-height: 300px; overflow-y: scroll;">
                                    @foreach (session()->get('role') as $role)
                                        <li><a {{ session()->get('currentRole')->brokerrole_id == $role->brokerrole_id ? '' : 'href=/service/role/change/' . $role->brokerrole_id }}
                                                {{ session()->get('currentRole')->brokerrole_id == $role->brokerrole_id ? 'style=font-weight:bold; class=text-primary' : '' }}>
                                                {{ $role->nama_role }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        {{-- test --}}
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{ config('app.sso') . '/users/' . $_SESSION['authUser']->profilepict }}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{ config('app.sso') . '/users/' . $_SESSION['authUser']->profilepict }}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>
                                                    @if (Auth::user()->jenisuser_sso == 2)
                                                        {{ Auth::user()->dosen->nama }}
                                                    @elseif(Auth::user()->jenisuser_sso == 1)
                                                        {{ Auth::user()->mhs->nama }}
                                                    @elseif(Auth::user()->jenisuser_sso == 3)
                                                        {{ Auth::user()->pegawai->nama }}
                                                    @endif
                                                </h4>
                                                <p class="text-muted">
                                                    @if (Auth::user()->jenisuser_sso == 2)
                                                        {{ Auth::user()->dosen->email }}
                                                    @elseif(Auth::user()->jenisuser_sso == 1)
                                                        {{ Auth::user()->mhs->email }}
                                                    @elseif(Auth::user()->jenisuser_sso == 3)
                                                        {{ Auth::user()->pegawai->email }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ config('app.sso') . 'home' }}"><i class="ti-back-left"></i> Kembali Ke Nata Kerti</a></li>
                                    <li><a href="{{ config('app.sso') . 'logout' }}"><i class="ti-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{ config('app.sso') . '/users/' . $_SESSION['authUser']->profilepict }}" alt="user" />
                        <!-- this is blinking heartbit-->

                    </div>
                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5>
                            @if (Auth::user()->jenisuser_sso == 2)
                                {{ Auth::user()->dosen->nama }}
                            @elseif(Auth::user()->jenisuser_sso == 1)
                                {{ Auth::user()->mhs->nama }}
                            @elseif(Auth::user()->jenisuser_sso == 3)
                                {{ Auth::user()->pegawai->nama }}
                            @endif
                        </h5>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        @php
                            $role = App\Models\Role::find(session()->get('currentRole')->brokerrole_id);
                        @endphp
                        {{-- #tipe role pegawai --}}
                        @if ($role->jenisuser_sso == 3)
                            @if ($role->fakultas_id == 0)
                                {{-- #administrator --}}
                                @include('layouts.menu-admin')
                            @elseif ($role->fakultas_id == 405)
                                {{-- #akademik --}}
                                @include('layouts.menu-baa')
                            @elseif($role->fakultas_id > 0 && $role->prodi_id == 0)
                                @include('layouts.menu-operator-fakultas')
                            @else
                                @include('layouts.menu-operator')
                            @endif
                        @elseif($role->jenisuser_sso == 2)
                            {{-- #dosen --}}
                            @include('layouts.menu-dosen')
                        @elseif($role->jenisuser_sso == 1)
                            @include('layouts.menu-mhs')
                        @endif




                        <!-- menu admin padanan-->
                        {{-- // @if (session()->get('currentRole')->brokerrole_id == 9)
                        //     @include('layouts.menu-padanan')
                        // @endif --}}
                        <!-- menu admin padanan-->

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->

        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">@yield('page-name')</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')

                    </ol>
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                @yield('content')

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">{!! config('app.license') !!}</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    @yield('js')
    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/search-role.js') }}"></script>



    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    {{-- <script src="{{asset('/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script> --}}
    <!--morris JavaScript -->
    {{-- <script src="{{asset('/assets/plugins/raphael/raphael-min.js')}}"></script> --}}
    <!-- Chart JS -->
    {{-- <script src="{{asset('js/dashboard1.js')}}"></script> --}}
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    {{-- <script src="{{asset('/assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script> --}}
</body>

</html>
