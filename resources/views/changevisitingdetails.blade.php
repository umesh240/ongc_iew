
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="mQ2N9odf46abAjHLsCii4HP2uzl8waz3Z2pJAMnR">

    <title>Change Checkin Detials | ONGC</title>

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
        .form-control.is-invalid {    background-image: none; }
        .form-control[readonly]:focus{ background-color: #e9ecef; opacity: 3; }
        .alert{ width: 100%; }
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
<img src="{{asset('/storage/app/event_logo/'.$event_logo_1)}}" alt="Logo">
 </div>
    <div class="login-box justify-content-center">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header login-header text-center">
                <h4 style="color:#457CB2;">Change your visit details</h4>
                <small>In case you are rescheduling your visit, please change the CHECKIN and CHEKOUT dates</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('checkInOut_update') }}">
                <input type="hidden"   name="id" required     value="{{ @$id }}"   >
                    @csrf
                    <div class="row">
                        @if(session('status') == 2 && session('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if(session('status') == 1 && session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-3">
                            <span class="col-12 pl-0">CPF Number</span>
                            <input type="text" class="form-control is-invalid cpf_no" name="cpf" required  autocomplete="" placeholder="CPF No." value="{{ @$cpf_no }}" {{ @$user_id > 0?'readonly':'autofocus' }} >
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3">
                            <span class="col-12 pl-0">Mobile Number</span>
                            <input type="text" class="form-control is-invalid phone_no int" name="phoneno" required  autocomplete="" placeholder="Phone no." value="{{ @$mobile }}" maxlength="10" {{ @$user_id > 0?'readonly':'' }} >
                        </div>
                        
                        <div class="col-md-12 col-sm-12 mb-3">
                            <span class="col-6 pl-0">Check - in</span>
                            <input type="date" class="col-12 form-control is-invalid" name="checkin" value="" required  autocomplete="" placeholder="Checkin date." {{ @$user_id > 0?'autofocus':''}} >
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3">
                            <span class="col-12 pl-0">Check - out</span>
                            <input type="date" class="col-12 form-control is-invalid" name="checkout" value="" required  autocomplete="" placeholder="Checkout date.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4 mb-3">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary login-btn">{{ __('Update') }}</button>
                        </div>
                        @if(@$user_id > 0)
                        <div class="col-md-12 mt-4 mb-3">
                            <button type="button" class="btn btn-block btn-success" onclick="window.close();">{{ __('Back To Home') }}</button>
                        </div>
                        @endif
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</section>

    </div>
</body>
<!-- jQuery -->
<script src="{{ asset('pages/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('pages/others/common.js') }}"></script>
<script>
  setTimeout(function(){
    $('.loading-container').css('display', 'none');
  }, 200);
  sessionStorage.setItem("wel_cnt", 1);

</script>

</html>

