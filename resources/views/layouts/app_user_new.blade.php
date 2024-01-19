<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @php
  $usrIdd = @Auth()->user()->id;
  $user_name = @Auth()->user()->name;
  @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="no-referrer-when-downgrade">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('pages/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('pages/plugins/fontawesome6.5.1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pages/plugins/toastr/toastr.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('pages/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pages/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ asset('pages/plugins/jquery/jquery.min.js') }}"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('pages/plugins/owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pages/plugins/owl/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pages/plugins/flickity/flickity.min.css') }}">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('pages/sweetalert2.min.css') }}">
    <script src="{{ asset('pages/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('pages/style.css') }}">
    
    <style>
        .content-header { padding: 4px 0.5rem !important; }
        label { margin-bottom: 0 !important; margin-top: 6px !important; }
        .select2-container{ min-width:100% !important; width:100% !important; }
        input[type="text"]{
          text-transform: capitalize;
        }
        body{ overflow-x: hidden; }
    </style>
    
  </head>
  <!--<body class="control-sidebar-slide-open sidebar-collapse layout-navbar-fixed layout-fixed sidebar-mini ">-->
  <body class="sidebar-mini layout-fixed">

  <section class="ongc-head desktop ccsticky-nav" id="mainHeader">
    <div class="container">
      @php
      $currentRouteName = Route::currentRouteName();
      @endphp
       @if($currentRouteName == 'my.dashboard')
      <nav class="navbar navbar-expand-lg ">
       
        <a class="navbar-brand" href="#">
          <img src="{{ asset('/pages/images/ongc-red-logo.png') }}" alt="ONGC" id="ongc-red">
          <img src="{{ asset('/pages/images/Ongc-Green-Logo1.png') }}" alt="ONGC Logo">
          <img src="{{ asset('/pages/images/logo_1.png') }}" alt="Indian Energy Logo" 
            id="logo-two">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="weather ml-auto">
          <div class="weather-image mr-3">
            <div class="logged-user"  style=" display: flex; align-items: center; color: #fff;">
              <i class="fas fa-user"></i><h5 style="font-size: 15px; margin-right: 35px; margin-bottom: 0px; color: #fff;">{{Auth::user()->name}}</h5>
            </div>
            <div id="sidebar">
              <ul>
                <li>
		              <a href="{{ route('my.page', ['page'=>'feedback']) }}">
                    <span class="icon">  <i class="far fa-comment-dots"></i></span>
                    <span class="title">Feedback</span>
                  </a>
                </li>
		            <li>
		              <a href="{{ route('logout'); }}">
                    <span class="icon">  <i class="fas fa-sign-out-alt"></i></span>
                    <span class="title">Log Out</span>
                  </a>
		            </li>
		          </ul>
  		        <div id="sidebar-btn">
  			        <i class="fas fa-ellipsis-v"></i>
  		        </div>
  		        <!-- <div id="close-btn" class="close-btn">
                        <span>&times;</span>
                 </div>-->
	          </div>
          </div>
        </div> 
        
      </nav>
        @else
        <nav class="inner-header">
            <div class="inner-head">
                <i class="fas fa-arrow-left" style="cursor: pointer;"  onclick="goBackToHomePage()"></i><h5>@yield('pageName')</h5>
          </div>
        </nav>
        @endif
    </div>
  </section>

  @yield('content')
 
 
@php
$embedded = session()->get('embedded'); 
if($embedded != 1){
@endphp

<!--- footer nav--->
 
<div class="container">
  <nav class="nav_bottom">
      <a href="{{ route('my.dashboard') }}" class="nav__link">
          <i class="material-icons nav__icon"><i class="fas fa-home"></i></i>
         
          <span class="nav__text">Home</span>
      </a>
      <a href="{{ route('my.page', ['page'=>'way_finder']) }}" class="nav__link nav__link--active" >
          <i class="material-icons nav__icon"><i class="fas fa-map-marked-alt"></i></i>
          <span class="nav__text">Way Finder</span>
      </a>
     <a href="{{ route('my.page', ['page'=>'day_wise']) }}" class="nav__link">
          <i class="material-icons nav__icon"><i class="far fa-calendar-alt"></i></i>
          <span class="nav__text">Event Details</span>
      </a>
      <a href="{{ route('my.page', ['page'=>'chat']) }}" class="nav__link">
          <i class="material-icons nav__icon"><i class="far fa-comment-alt"></i></i>
          <span class="nav__text">Chat</span>
      </a>

  </nav>
</div>
@php
}
@endphp
 
 
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery -->
  <script src="{{ asset('pages/plugins/jquery/jquery.slim.min.js') }}"></script>
  <script src="{{ asset('pages/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('pages/plugins/popper/popper.min.js') }}"></script>
  <script src="{{ asset('pages/plugins/owl/owl.carousel.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('pages/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('pages/plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('pages/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('pages/plugins/flickity/flickity.pkgd.min.js') }}"></script>

  <!-- Toastr -->
  <script src="{{ asset('pages/plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('pages/others/common.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('pages/dist/js/adminlte.min.js') }}"></script>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2();
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      });
    });
    
     //team//
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    navText: ["<i class='fa fa-long-arrow-left text-orange'></i>", "<i class='fa fa-long-arrow-right text-orange'></i>"],
    autoplay: false,
    autoplayHoverPause: false,
    responsive: {
      0: {
        items: 2
      },
      600: {
        items: 2
      },
      1000: {
        items: 3
      }
    }
  });


  //slider js//
  var flkty = new Flickity('.carousel', {
    cellAlign: 'center',
    contain: true,
    wrapAround: true,
    autoPlay: 2000,
    prevNextButtons: true,
    pageDots: false,
    cellSelector: '.carousel-cell',
    percentPosition: false,
    initialIndex: 1,
    rightToLeft: true, 
    friction: 0.5, 
  });



  //toggle//

$(document).ready(function () {
    $('#sidebar-btn').click(function () {
        $('#sidebar').toggleClass('visible');
        $('#close-btn').toggle(); // Toggle the visibility of the close button
    });

    $('#close-btn').click(function () {
        $('#sidebar').removeClass('visible');
        $(this).hide(); // Hide the close button
    });

    $(document).click(function (event) {
        var sidebar = $('#sidebar');
        var sidebarBtn = $('#sidebar-btn');

        if (!sidebar.is(event.target) && sidebar.has(event.target).length === 0 &&
            !sidebarBtn.is(event.target) && sidebarBtn.has(event.target).length === 0) {
            sidebar.removeClass('visible');
            $('#close-btn').hide(); // Hide the close button
        }
    });

    $(document).on('keydown', function (event) {
        if (event.key === 'Escape') {
            $('#sidebar').removeClass('visible');
            $('#close-btn').hide(); // Hide the close button
        }
    });
});
  
  

// for call when click on icon
        function openDialPad(phoneNumber) {
            window.location.href = 'tel:' + encodeURIComponent(phoneNumber);
        }

      function goBackToHomePage() {
        window.location.href = "/"; // Replace with the actual URL of your home page
    }

  
  </script>
  @yield('javascript')
  </body>
</html>
