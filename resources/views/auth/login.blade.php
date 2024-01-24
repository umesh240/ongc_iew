
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="mQ2N9odf46abAjHLsCii4HP2uzl8waz3Z2pJAMnR">

    <title>Login | ONGC</title>

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
    <style>
        
    </style>
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
 @php
    $embedded = request()->query('embedded');
    if($embedded){
        session()->put('embedded', 1);
    }else{
        session()->put('embedded', 2);
    }
@endphp 
<section class="login-page">
<div class="login-logo">
 <img src="{{ asset('/pages/images/green-logo.png') }}" alt="ONGC Logo">
 </div>
    <div class="login-box justify-content-center">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header login-header text-center">
                <h4 style="color:#457CB2;">Login to your account</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group login-pg mb-3">
                        <input id="name" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  autocomplete="" placeholder="CPF No. or Mobile No." autofocus>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group login-pg mb-3">
                       <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder=" Password" autocomplete="current-password">
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12 mt-4 mb-3">
                            <button type="submit" class="btn btn-primary login-btn">{{ __('Login') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1 text-center">
                    @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}"  style="color:#7A7A7A; font-size:16px;">
                        {{ __('Forgot Password?') }}
                        </a>
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
  sessionStorage.setItem("wel_cnt", 1);

</script>

</html>

