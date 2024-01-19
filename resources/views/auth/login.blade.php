
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="mQ2N9odf46abAjHLsCii4HP2uzl8waz3Z2pJAMnR">

    <title>Login | ONGC</title>

    <link rel="shortcut icon" href="https://ongcevents.co.in/images/logo.png" type="image/x-icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://ongcevents.co.in/pages/dist/css/adminlte.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://ongcevents.co.in/pages/plugins/fontawesome-free/css/all.min.css">
    <style>
        input[type="text"]:not(.lc){
          text-transform: capitalize;
        }
        body{ overflow-x: hidden; }
        /** BEGIN CSS **/

        @keyframes rotate-loading {
            0%  { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        :root {
          --wd_ht: 100px;
          --logo_mr: 4%;
          --logo_wd: 92%;  
        }
        .loading-container {
            background-color: #797777b0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: fixed;
            top:0;
            left:0;
            width:100%;
            z-index: 1111;

        }

        .logo {
            position: absolute; 
            width: var(--wd_ht);
            height: var(--wd_ht);
        }

        .loading {
            width: var(--wd_ht);
            height: var(--wd_ht);
            border-radius: 50%;
            border: 2px solid transparent;
            border-color: transparent #fff transparent #fff; /* Change the color if needed */
            animation: rotate-loading 1.5s linear infinite;
            transform-origin: 50% 50%;
        }

        .logo img{    width: var(--logo_wd); margin: var(--logo_mr); }
        
input#name {
    border: 1px solid #D9D9D9;
    border-radius: 8px;
    position: relative;
    padding: 5px 40px;
}
.input-icon i.fas.fa-user {
    position: absolute;
    color: #F07E29;
    font-size: 16px;
    top: 10px;
    left: 15px;
}
input#password {
    border: 1px solid #D9D9D9;
    border-radius: 8px;
    position: relative;
    padding: 5px 40px;
}
.input-icon i.fas.fa-lock {
    position: absolute;
    color: #F07E29;
    font-size: 16px;
    top: 10px;
    left: 15px;
}
button.login-btn {
    background-color: #F07E29;
    border: 1px solid #F07E29;
    border-radius: 8px;
    width: 100%;
}
button.login-btn:hover {
    background-color: #F07E29 !important;
}
.form-control:focus {
    background-color: transparent;
}
.card-header.login-header.text-center {
    border-bottom: none;
}
.login-box, .register-box {
    width: 400px;
}
.card-primary.card-outline {
    border-top: none;
    padding: 30px 0px 30px 0px;
    box-shadow: 0px 1px 14px -3px #3f70a140;
}
section.login-page {
    position: relative;
    background-color: #fff !important;
}
section.login-page:before {
    content: '';
    background: url(/pages/images/login-shape.png);
    width: 320px;
    height: 200px;
    background-repeat: no-repeat;
    background-size: cover;
    left: 0;
    position: absolute;
    top: -23px;
}
section.login-page:after {
    content: '';
    background: url(/pages/images/login-down.png);
    width: 320px;
    height: 200px;
    background-repeat: no-repeat;
    background-size: cover;
    right: 0;
    position: absolute;
    bottom: 0;
}
.login-logo {
    width: 100%;
}
.login-logo img {
    float: left;
    width: 100px;
    position: relative;
    top: -133px;
    left: 25px;
}





@media only screen and (min-width : 320px) and (max-width : 767px) {

.card-primary.card-outline {
    margin: 0px 15px 0px 15px !important;
}
.login-box, .register-box {
    width: 100%;
}
section.login-page:before {
    width: 300px;
    left: -42px;
    top: 0px;
}
.login-logo img {
    width: 85px;
    top: -96px;
    left: 19px;
}
.login-header  h4 {
    font-size: 18px;
}
section.login-page:after {
    width: 300px;
    height: 110px;
}

}


@media only screen and (min-width : 414px) and (max-width : 896px){
.login-logo img {
    top: -185px;
}

}

@media only screen and (min-width : 768px) and (max-width : 1024px) {

.login-logo img {
    top: -250px;
    left: 40px;
}
section.login-page:before {
    height: 238px;
}
}




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
  
<section class="login-page">
<div class="login-logo">
 <img src="{{ asset('/pages/images/Ongc-Green-Logo1.png') }}" alt="ONGC Logo">
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
</script>

</html>

