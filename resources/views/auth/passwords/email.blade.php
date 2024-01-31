
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="mQ2N9odf46abAjHLsCii4HP2uzl8waz3Z2pJAMnR">

    <title>Password Reset | ONGC</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('pages/dist/css/adminlte.min.css') }}">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('pages/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pages/login.css') }}">
</head>
<!--<body class="control-sidebar-slide-open sidebar-collapse layout-navbar-fixed layout-fixed sidebar-mini ">-->
<body class="sidebar-mini layout-fixed">
    <div class="loading-container">
        <div class="logo">
            <img src="https://ongcevents.co.in/images/logo.png" alt="Logo">
        </div>
        <div class="loading"></div>
    </div>
    
    
    <!-- Site wrapper -->
    <div class="wrapper">
  
<section class="login-page">
<div class="login-logo">
 <img src="{{ asset('/pages/images/Ongc-Green-Logo1.png') }}" alt="ONGC Logo">
 </div>
    <div class="login-box justify-content-center">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header login-header text-center">
                <h4 style="color:#457CB2;">{{ __('Reset Password') }}</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-group login-pg mb-3">
                        <input id="name" type="text" class="form-control @error('cpf_mob') is-invalid @enderror" name="cpf_mob" value="{{ old('cpf_mob') }}" required autocomplete="off" placeholder="CPF No. or Mobile No." autofocus>
                        <div class="input-icon" style="text-transform: lowercase;">
                            <i class="fas fa-user"></i>
                        </div>
                        @error('cpf_mob')
                            <span class="invalid-feedback" role="alert">
                                <strong>@php echo  $message @endphp</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12 mt-4 mb-3">
                            <button type="submit" class="btn btn-primary login-btn">{{ __('Send Password Reset Link') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1 text-center">
                    @if (Route::has('password.request'))
                        <a class="ml-4" href="{{ route('login') }}"  style="color:#7A7A7A; font-size:16px;">{{ __('Login Now') }}</a>
                    @endif
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>

    </div>
</body>
<!-- jQuery -->
<script src="https://ongcevents.co.in/pages/plugins/jquery/jquery.min.js"></script>
<script>
  setTimeout(function(){
    $('.loading-container').css('display', 'none');
  }, 200);
</script>

</html>

