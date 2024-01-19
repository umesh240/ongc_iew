@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Way_Finder';
@endphp
@section('title', $pageNm)
@section('content')

<section class="way_finder">
     <iframe src="https://route.heliware.co.in/basemap" width="100%" height="600" frameborder="0" allowfullscreen></iframe>

</section>
    
@endsection
@section('javascript')
  <script>
        document.querySelector('iframe').onerror = function (event) {
            console.error('Error loading iframe:', event);
        };
    </script>
@endsection